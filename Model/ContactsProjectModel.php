<?php

namespace Kanboard\Plugin\AddressBook\Model;

use Kanboard\Core\Base;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\TaskModel;

/**
 * Manages the projects in which a global contact is available.
 * Covered by tests/Integration/GlobalDirectoryTest.php.
 *
 * @package Model
 * @author  aljawaid
 */
class ContactsProjectModel extends Base
{
    /**
     * SQL table name for project contact assignments
     *
     * @var string
     */
    const TABLE = 'address_book_contacts_project_has_contact';

    /**
     * Return contacts assigned to a project
     *
     * @param  integer $project_id
     * @return array
     */
    public function getAllByProjectId($project_id)
    {
        return $this->contactsModel->getAllByIds($this->db
            ->table(self::TABLE)
            ->eq('project_id', $project_id)
            ->findAllByColumn('contacts_id'));
    }

    /**
     * Return contacts that can still be assigned to a project
     *
     * @param  integer $project_id
     * @return array
     */
    public function getAvailableByProjectId($project_id)
    {
        $assigned = array_flip($this->db
            ->table(self::TABLE)
            ->eq('project_id', $project_id)
            ->findAllByColumn('contacts_id'));

        return array_values(array_filter($this->contactsModel->getAll(), function (array $contact) use ($assigned) {
            return ! isset($assigned[$contact['contacts_id']]);
        }));
    }

    /**
     * Return projects assigned to a contact
     *
     * @param  integer $contacts_id
     * @return array
     */
    public function getProjectsByContactId($contacts_id)
    {
        return $this->db
            ->table(self::TABLE)
            ->eq(self::TABLE . '.contacts_id', $contacts_id)
            ->columns(ProjectModel::TABLE . '.id', ProjectModel::TABLE . '.name')
            ->join(ProjectModel::TABLE, 'id', 'project_id')
            ->asc(ProjectModel::TABLE . '.name')
            ->findAll();
    }

    /**
     * Return true when a contact is assigned to a project
     *
     * @param  integer $contacts_id
     * @param  integer $project_id
     * @return boolean
     */
    public function isAssignedToProject($contacts_id, $project_id)
    {
        return $this->db
            ->table(self::TABLE)
            ->eq('contacts_id', $contacts_id)
            ->eq('project_id', $project_id)
            ->exists();
    }

    /**
     * Assign a global contact to a project
     *
     * @param  integer $contacts_id
     * @param  integer $project_id
     * @return boolean
     */
    public function assignToProject($contacts_id, $project_id)
    {
        if (! $this->contactsModel->exists($contacts_id) || ! $this->projectModel->exists($project_id)) {
            return false;
        }

        if ($this->isAssignedToProject($contacts_id, $project_id)) {
            return true;
        }

        return $this->db->table(self::TABLE)->persist(array(
            'contacts_id' => $contacts_id,
            'project_id' => $project_id,
        )) !== false;
    }

    /**
     * Remove a contact from a project and its tasks in that project
     *
     * @param  integer $contacts_id
     * @param  integer $project_id
     * @return boolean
     */
    public function removeFromProject($contacts_id, $project_id)
    {
        $task_ids = $this->db
            ->table(TaskModel::TABLE)
            ->eq('project_id', $project_id)
            ->findAllByColumn('id');

        $this->db->startTransaction();

        if (! empty($task_ids)) {
            $this->db
                ->table(ContactsTaskModel::TABLE)
                ->eq('contacts_id', $contacts_id)
                ->in('task_id', $task_ids)
                ->remove();
        }

        $removed = $this->db
            ->table(self::TABLE)
            ->eq('contacts_id', $contacts_id)
            ->eq('project_id', $project_id)
            ->remove();

        $this->db->closeTransaction();

        return $removed;
    }
}
