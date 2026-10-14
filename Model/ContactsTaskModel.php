<?php

namespace Kanboard\Plugin\AddressBook\Model;

use Kanboard\Core\Base;
use Kanboard\Model\UserModel;

/**
 * Contacts Task Model
 *
 * Project-scoped task links are covered by tests/Integration/GlobalDirectoryTest.php.
 *
 * @package  Model
 * @author   Martin Middeke
 * @author   aljawaid
 */
class ContactsTaskModel extends Base
{
    /**
     * SQL table name for Task Contacts
     *
     * @var  string
     */
    const TABLE = 'address_book_contacts_task_has_contact';

    /**
     * Return all contact items
     *
     * @access public
     * @return array
     * @author  Martin Middeke
     */
    public function getByTaskId($task_id)
    {
        return $this->db->table(self::TABLE)->columns(self::TABLE . '.contacts_id')->eq('task_id', $task_id)->findAll();
    }

    /**
     * Return linked contacts
     *
     * @access  public
     * @return  array
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function getLinked($task_id)
    {
        $contact_ids = $this->db
            ->table(self::TABLE)
            ->eq('task_id', $task_id)
            ->findAllByColumn('contacts_id');

        return $this->contactsModel->getAllByIds($contact_ids);
    }

    /**
     * Get all contacts not linked to task
     *
     * @access  public
     * @param   integer $task_id
     * @param   integer $project_id
     * @return  array
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function getNotLinked($task_id, $project_id)
    {
        $linked = array_flip($this->db
            ->table(self::TABLE)
            ->eq('task_id', $task_id)
            ->findAllByColumn('contacts_id'));

        return array_values(array_filter($this->contactsProjectModel->getAllByProjectId($project_id), function (array $contact) use ($linked) {
            return ! isset($linked[$contact['contacts_id']]);
        }));
    }

    /**
     * Get a item by the ID
     *
     * @access  public
     * @param   integer   $item_id    Subtask id
     * @param   bool      $more          Fetch more data
     * @return  array
     * @author  Martin Middeke
     */
    public function getById($item_id, $more = false)
    {
        if ($more) {
            return $this->db
                ->table(self::TABLE)
                ->eq(self::TABLE . '.id', $item_id)
                ->columns(self::TABLE . '.*', UserModel::TABLE . '.username', UserModel::TABLE . '.name')
                ->subquery($this->subtaskTimeTrackingModel->getTimerQuery($this->userSession->getId()), 'timer_start_date')
                ->join(UserModel::TABLE, 'id', 'user_id')
                ->callback(array($this, 'addStatusName'))
                ->findOne();
        }

        return $this->db->table(self::TABLE)->eq('id', $item_id)->findOne();
    }

    /**
     * Add a contact to task
     *
     * @access  public
     * @param   integer   $contacts_id    contact id
     * @param   integer   $task_id        task id
     * @return  array
     * @author  Martin Middeke
     */
    public function addToTask($contacts_id, $task_id)
    {
        $project_id = $this->taskFinderModel->getProjectId($task_id);

        if ($project_id <= 0 || ! $this->contactsProjectModel->isAssignedToProject($contacts_id, $project_id)) {
            return false;
        }

        if ($this->db->table(self::TABLE)->eq('contacts_id', $contacts_id)->eq('task_id', $task_id)->exists()) {
            return true;
        }

        return $this->db->table(self::TABLE)->persist(array('contacts_id' => $contacts_id, 'task_id' => $task_id)) !== false;
    }

    /**
     * Delete a contact from task
     *
     * @access  public
     * @param   integer   $contacts_id    contact id
     * @param   integer   $task_id        task id
     * @return  array
     * @author  Martin Middeke
     */
    public function removeFromTask($contacts_id, $task_id)
    {
        return $this->db->table(self::TABLE)->eq('contacts_id', $contacts_id)->eq('task_id', $task_id)->remove();
    }
}
