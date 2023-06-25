<?php

namespace Kanboard\Plugin\AddressBook\Model;

use Kanboard\Core\Base;

/**
 * Contacts Items Model
 *
 * @package  Model
 * @author   Martin Middeke
 * @author   aljawaid
 */
class ContactsItemsModel extends Base
{
    /**
     * SQL table name for Contacts Items
     *
     * @var  string
     */
    const TABLE = 'address_book_contacts_items';

    /**
     * Return all contact items
     *
     * @access  public
     * @return  array
     * @author  Martin Middeke
     */
    public function getAllItems()
    {
        return $this->db->table(self::TABLE)->asc(self::TABLE . '.position')->findAll();
    }

    /**
     * Get item by ID
     *
     * @access  public
     * @param   integer  $item_id
     * @return  array
     * @author  Martin Middeke
     */
    public function getByID($item_id)
    {
        return $this->db->table(self::TABLE)->eq('id', $item_id)->findOne();
    }

    /**
     * Get ID by position
     *
     * @access  public
     * @param   integer  $position
     * @return  array
     * @author  Martin Middeke
     */
    public function getByPosition($position)
    {
        return $this->db->table(self::TABLE)->eq('position', $position)->findOne();
    }

    /**
     * Change item position
     *
     * @access  public
     * @param   integer  $item_id
     * @param   string   $direction
     * @return  boolean
     * @author  Martin Middeke
     */
    public function changePosition($item_id, $direction)
    {
        if ($direction === 'up') {
            $offset = -1;
        } elseif ($direction === 'down') {
            $offset = 1;
        } else {
            return false;
        }

        $results = array();
        $old = $this->getByID($item_id);
        $old_position = $old['position'];
        $new_position = $old_position + $offset;
        $current_item = $this->getByPosition($new_position);
        $current_item_id = $current_item['id'];

        $results[] = $this->db->table(self::TABLE)->eq('id', $item_id)->update(array('position' => $new_position));
        $results[] = $this->db->table(self::TABLE)->eq('id', $current_item_id)->update(array('position' => $old_position));

        return !in_array(false, $results, true);
    }

    /**
     * Delete an item
     *
     * @access  public
     * @param   integer  $contacts_id
     * @return  bool
     * @author  Martin Middeke
     */
    public function remove($item_id)
    {
        return $this->db->table(self::TABLE)->eq('id', $item_id)->remove();
    }

    /**
     * Update an item
     *
     * @access  public
     * @param   array    $values    Form values
     * @return  bool
     * @author  Martin Middeke
     */
    public function update(array $values)
    {
        return $this->db->table(self::TABLE)->eq('id', $values['id'])->update($values);
    }

    /**
     * Save a new item
     *
     * @access  public
     * @param   array    $values    Form values
     * @return  boolean
     * @author  Martin Middeke
     */
    public function save(array $values)
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();
        $values += array('position' => $max['maxid'] + 1);

        return $this->db->table(self::TABLE)->persist($values);
    }

    /**
     * Delete Property Set
     *
     * @param   set         - name of property set
     * @author  aljawaid
     */
    public function removeSet($set)
    {
        switch ($set) {
            case 'personal':
                $this->db->startTransaction();

                $this->db->table(self::TABLE)->eq('item', 'Address')->remove();
                $this->db->table(self::TABLE)->eq('item', 'Telephone')->remove();
                $this->db->table(self::TABLE)->eq('item', 'Mobile')->remove();
                $this->db->table(self::TABLE)->eq('item', 'Email')->remove();
                $this->db->table(self::TABLE)->eq('item', 'Relationship')->remove();
                $this->db->table(self::TABLE)->eq('item', 'Note')->remove();

                $this->db->closeTransaction();

            case 'business':
                $this->db->startTransaction();

                $this->db->table(self::TABLE)->eq('item', 'Address')->remove();
                $this->db->table(self::TABLE)->eq('item', 'Telephone')->remove();
                $this->db->table(self::TABLE)->eq('item', 'Mobile')->remove();
                $this->db->table(self::TABLE)->eq('item', 'Email')->remove();
                $this->db->table(self::TABLE)->eq('item', 'Website')->remove();
                $this->db->table(self::TABLE)->eq('item', 'Note')->remove();

                $this->db->closeTransaction();

                return true;
                break;
                return true;
                break;
            default:
                return false;
        }

        return false;
    }

    /**
     * Add Property Set - Personal
     * - A general person
     *
     * @author  aljawaid
     */
    public function insertSetPersonal()
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();

        $this->db->startTransaction();

        $this->db->table(self::TABLE)->insert(['item' => 'Address', 'item_type' => 'address', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Telephone', 'item_type' => 'telephone', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Mobile', 'item_type' => 'telephone', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Email', 'item_type' => 'email', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Relationship', 'item_type' => 'text', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Note', 'item_type' => 'textarea', 'position' => $max['maxid'] + 1]);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Add Property Set - Business
     * - A general business or organisation
     *
     * @author  aljawaid
     */
    public function insertSetBusiness()
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();

        $this->db->startTransaction();

        $this->db->table(self::TABLE)->insert(['item' => 'Address', 'item_type' => 'address', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Telephone', 'item_type' => 'telephone', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Mobile', 'item_type' => 'telephone', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Email', 'item_type' => 'email', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Website', 'item_type' => 'url', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Note', 'item_type' => 'textarea', 'position' => $max['maxid'] + 1]);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Add Property Set - Company
     * - A large business with departments and extensions
     *
     * @author  aljawaid
     */
    public function insertSetCompany()
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();

        $this->db->startTransaction();

        $this->db->table(self::TABLE)->insert(['item' => 'Department', 'item_type' => 'text', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Address', 'item_type' => 'address', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Telephone', 'item_type' => 'telephone', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Extension', 'item_type' => 'number', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Contact Name', 'item_type' => 'text', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Mobile', 'item_type' => 'telephone', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Email', 'item_type' => 'email', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Website', 'item_type' => 'url', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Note', 'item_type' => 'textarea', 'position' => $max['maxid'] + 1]);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Remove Property Set - Company
     *
     * @author  aljawaid
     */
    public function removeSetCompany()
    {
        $this->db->startTransaction();

        $this->db->table(self::TABLE)->eq('item', 'Department')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Address')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Telephone')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Extension')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Contact Name')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Mobile')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Email')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Website')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Note')->remove();

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Add Property Set - People
     * - Names of people with contact numbers
     *
     * @author  aljawaid
     */
    public function insertSetPeople()
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();

        $this->db->startTransaction();

        $this->db->table(self::TABLE)->insert(['item' => 'Title', 'item_type' => 'text', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Telephone', 'item_type' => 'telephone', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Mobile', 'item_type' => 'telephone', 'position' => $max['maxid'] + 1]);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Remove Property Set - People
     *
     * @author  aljawaid
     */
    public function removeSetPeople()
    {
        $this->db->startTransaction();

        $this->db->table(self::TABLE)->eq('item', 'Title')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Telephone')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Mobile')->remove();

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Add Property Set - Team
     * - Names of people with contact numbers and email addresses
     *
     * @author  aljawaid
     */
    public function insertSetTeam()
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();

        $this->db->startTransaction();

        $this->db->table(self::TABLE)->insert(['item' => 'Title', 'item_type' => 'text', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Telephone', 'item_type' => 'telephone', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Mobile', 'item_type' => 'telephone', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Email', 'item_type' => 'email', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Note', 'item_type' => 'textarea', 'position' => $max['maxid'] + 1]);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Remove Property Set - Team
     *
     * @author  aljawaid
     */
    public function removeSetTeam()
    {
        $this->db->startTransaction();

        $this->db->table(self::TABLE)->eq('item', 'Title')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Telephone')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Mobile')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Email')->remove();
        $this->db->table(self::TABLE)->eq('item', 'Note')->remove();

        $this->db->closeTransaction();

        return true;
    }
}
