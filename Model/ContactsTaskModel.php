<?php

namespace Kanboard\Plugin\AddressBook\Model;

use Kanboard\Core\Base;
use Kanboard\Model\SubtaskModel;
use Kanboard\Model\UserModel;
use Kanboard\Model\TaskModel;

/**
 * Contacts Task Model
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
        $firstPosition = $this->db->table(ContactsItemsModel::TABLE)->columns('id')->eq('position', 1)->findOne();
        return $this->db
            ->table(self::TABLE)
            ->eq('task_id', $task_id)
            ->columns(
                self::TABLE . '.contacts_id',
                ContactsModel::TABLE . '.contact_item_value'
            )
            ->join(ContactsModel::TABLE, 'contacts_id', 'contacts_id')
            ->join(ContactsItemsModel::TABLE, 'id', 'item_id', ContactsModel::TABLE)
            ->asc(ContactsItemsModel::TABLE . '.position')
            ->groupBy(self::TABLE . '.contacts_id')
            ->asc(ContactsModel::TABLE . '.contact_item_value')
            ->findAll();
    }

    /**
     * Get all contacts not linked to task
     *
     * @access  public
     * @param   integer $task_id
     * @return  array
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function getNotLinked($task_id)
    {
        $subquery = $this->db
            ->table(self::TABLE)
            ->eq('task_id', $task_id)
            ->columns(
                self::TABLE . '.contacts_id'
            )
            ->join(ContactsModel::TABLE, 'contacts_id', 'contacts_id')
            ->join(ContactsItemsModel::TABLE, 'id', 'item_id', ContactsModel::TABLE)
            ->asc(ContactsItemsModel::TABLE . '.position')
            ->groupBy(ContactsModel::TABLE . '.contacts_id')
            ->asc(ContactsModel::TABLE . '.contact_item_value');

        return $this->db
            ->table(ContactsModel::TABLE)
            ->columns(
                ContactsModel::TABLE . '.contacts_id',
                ContactsModel::TABLE . '.contact_item_value'
            )
            ->notInSubquery('contacts_id', $subquery)
            ->groupBy('contacts_id')
            ->findAll();
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
        return $this->db->table(self::TABLE)->persist(array('contacts_id' => $contacts_id,'task_id' => $task_id,));
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
