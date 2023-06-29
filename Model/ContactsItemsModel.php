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
     * SQL Table Name for Contacts Items
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
     * @author  aljawaid
     */
    public function update(array $values)
    {
        // return $this->db->table(self::TABLE)->eq('id', $values['id'])->update($values);
        $this->db->startTransaction();

        $this->db->table(self::TABLE)->eq('id', $values['id'])->update($values);
        $this->db->table(self::TABLE)->eq('id', $values['id'])->update(['property_set' => 'custom']);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Save a New Item
     * - Once the record is created, the last ID is fetched to update the `property_set` to 'custom'
     *
     * @access  public
     * @param   array    $values    Form values
     * @return  boolean
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function save(array $values)
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();
        $values += array('position' => $max['maxid'] + 1);

        // return $this->db->table(self::TABLE)->persist($values);
        $this->db->startTransaction();

        $this->db->table(self::TABLE)->persist($values);
        $this->db->table(self::TABLE)->eq('id', $this->db->getLastId())->save(['property_set' => 'custom']);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Delete Property Set
     *
     * @param   string      $set     Name of property set
     * @var     $set
     * @return  bool        All rows matching the $set name will be deleted
     * @author  aljawaid
     */
    public function removeSet($set)
    {
        switch ($set) {
            case 'personal':
                return $this->db->table(self::TABLE)->eq('property_set', 'personal')->remove();
                break;
            case 'business':
                return $this->db->table(self::TABLE)->eq('property_set', 'business')->remove();
                break;
            case 'company':
                return $this->db->table(self::TABLE)->eq('property_set', 'company')->remove();
                break;
            case 'people':
                return $this->db->table(self::TABLE)->eq('property_set', 'people')->remove();
                break;
            case 'team':
                return $this->db->table(self::TABLE)->eq('property_set', 'team')->remove();
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
     * @return  boolean     Position will be incremented after each record is inserted
     * @author  aljawaid
     */
    public function insertSetPersonal()
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();

        $this->db->startTransaction();

        $this->db->table(self::TABLE)->insert(['item' => 'Address', 'item_type' => 'address', 'property_set' => 'personal', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Telephone', 'item_type' => 'telephone', 'property_set' => 'personal', 'position' => $max['maxid'] + 2]);
        $this->db->table(self::TABLE)->insert(['item' => 'Mobile', 'item_type' => 'telephone', 'property_set' => 'personal', 'position' => $max['maxid'] + 3]);
        $this->db->table(self::TABLE)->insert(['item' => 'Email', 'item_type' => 'email', 'property_set' => 'personal', 'position' => $max['maxid'] + 4]);
        $this->db->table(self::TABLE)->insert(['item' => 'Relationship', 'item_type' => 'text', 'property_set' => 'personal', 'position' => $max['maxid'] + 5]);
        $this->db->table(self::TABLE)->insert(['item' => 'Note', 'item_type' => 'textarea', 'property_set' => 'personal', 'position' => $max['maxid'] + 6]);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Add Property Set - Business
     * - A general business or organisation
     *
     * @return  boolean     Position will be incremented after each record is inserted
     * @author  aljawaid
     */
    public function insertSetBusiness()
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();

        $this->db->startTransaction();

        $this->db->table(self::TABLE)->insert(['item' => 'Business Address', 'item_type' => 'address', 'property_set' => 'business', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Telephone', 'item_type' => 'telephone', 'property_set' => 'business', 'position' => $max['maxid'] + 2]);
        $this->db->table(self::TABLE)->insert(['item' => 'Mobile', 'item_type' => 'telephone', 'property_set' => 'business', 'position' => $max['maxid'] + 3]);
        $this->db->table(self::TABLE)->insert(['item' => 'Email', 'item_type' => 'email', 'property_set' => 'business', 'position' => $max['maxid'] + 4]);
        $this->db->table(self::TABLE)->insert(['item' => 'Website', 'item_type' => 'url', 'property_set' => 'business', 'position' => $max['maxid'] + 5]);
        $this->db->table(self::TABLE)->insert(['item' => 'Note', 'item_type' => 'textarea', 'property_set' => 'business', 'position' => $max['maxid'] + 6]);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Add Property Set - Company
     * - A large business with departments and extensions
     *
     * @return  boolean     Position will be incremented after each record is inserted
     * @author  aljawaid
     */
    public function insertSetCompany()
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();

        $this->db->startTransaction();

        $this->db->table(self::TABLE)->insert(['item' => 'Department', 'item_type' => 'text', 'property_set' => 'company', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Company Address', 'item_type' => 'address', 'property_set' => 'company', 'position' => $max['maxid'] + 2]);
        $this->db->table(self::TABLE)->insert(['item' => 'Telephone', 'item_type' => 'telephone', 'property_set' => 'company', 'position' => $max['maxid'] + 3]);
        $this->db->table(self::TABLE)->insert(['item' => 'Extension', 'item_type' => 'number', 'property_set' => 'company', 'position' => $max['maxid'] + 4]);
        $this->db->table(self::TABLE)->insert(['item' => 'Contact Name', 'item_type' => 'text', 'property_set' => 'company', 'position' => $max['maxid'] + 5]);
        $this->db->table(self::TABLE)->insert(['item' => 'Mobile', 'item_type' => 'telephone', 'property_set' => 'company', 'position' => $max['maxid'] + 6]);
        $this->db->table(self::TABLE)->insert(['item' => 'Email', 'item_type' => 'email', 'property_set' => 'company', 'position' => $max['maxid'] + 7]);
        $this->db->table(self::TABLE)->insert(['item' => 'Website', 'item_type' => 'url', 'property_set' => 'company', 'position' => $max['maxid'] + 8]);
        $this->db->table(self::TABLE)->insert(['item' => 'Note', 'item_type' => 'textarea', 'property_set' => 'company', 'position' => $max['maxid'] + 9]);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Add Property Set - People
     * - Names of people with contact numbers
     *
     * @return  boolean     Position will be incremented after each record is inserted
     * @author  aljawaid
     */
    public function insertSetPeople()
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();

        $this->db->startTransaction();

        $this->db->table(self::TABLE)->insert(['item' => 'Title', 'item_type' => 'text', 'property_set' => 'people', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Telephone', 'item_type' => 'telephone', 'property_set' => 'people', 'position' => $max['maxid'] + 2]);
        $this->db->table(self::TABLE)->insert(['item' => 'Mobile', 'item_type' => 'telephone', 'property_set' => 'people', 'position' => $max['maxid'] + 3]);

        $this->db->closeTransaction();

        return true;
    }

    /**
     * Add Property Set - Team
     * - Names of people with contact numbers and email addresses
     *
     * @return  boolean     Position will be incremented after each record is inserted
     * @author  aljawaid
     */
    public function insertSetTeam()
    {
        $max = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.position) maxid')->findOne();

        $this->db->startTransaction();

        $this->db->table(self::TABLE)->insert(['item' => 'Title', 'item_type' => 'text', 'property_set' => 'team', 'position' => $max['maxid'] + 1]);
        $this->db->table(self::TABLE)->insert(['item' => 'Telephone', 'item_type' => 'telephone', 'property_set' => 'team', 'position' => $max['maxid'] + 2]);
        $this->db->table(self::TABLE)->insert(['item' => 'Mobile', 'item_type' => 'telephone', 'property_set' => 'team', 'position' => $max['maxid'] + 3]);
        $this->db->table(self::TABLE)->insert(['item' => 'Email', 'item_type' => 'email', 'property_set' => 'team', 'position' => $max['maxid'] + 4]);
        $this->db->table(self::TABLE)->insert(['item' => 'Note', 'item_type' => 'textarea', 'property_set' => 'team', 'position' => $max['maxid'] + 5]);

        $this->db->closeTransaction();

        return true;
    }
}
