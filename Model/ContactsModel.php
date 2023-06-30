<?php

namespace Kanboard\Plugin\AddressBook\Model;

use Kanboard\Core\Base;

/**
 * Contacts Model
 *
 * @package  Model
 * @author   Martin Middeke
 * @author   aljawaid
 */
class ContactsModel extends Base
{
    /**
     * SQL table name for Contacts
     *
     * @var  string
     */
    const TABLE = 'address_book_contacts_contact';

    /**
     * Return contact by ID
     *
     * @access  public
     * @param   integer $contacts_id
     * @return  array
     * @author  Martin Middeke
     */
    public function getByID($contacts_id)
    {
        $contact = $this->db
            ->table(self::TABLE)
            ->eq('contacts_id', $contacts_id)
            ->join(ContactsItemsModel::TABLE, 'id', 'item_id')
            ->asc(ContactsItemsModel::TABLE . '.position')
            ->findAll();

        $return = array();
        foreach ($contact as $key => $value) {
            $return[$value['id']] = $value;
        }

        return $return;
    }

    /**
     * Return all contacts
     *
     * @access  public
     * @return  array
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function getAll()
    {
        $firstPosition = $this->db->table(ContactsItemsModel::TABLE)->columns('id')->eq('position', 1)->findOne();

        return $this->db
            ->table(self::TABLE)
            ->join(ContactsItemsModel::TABLE, 'id', 'item_id')
            ->asc(ContactsItemsModel::TABLE . '.position')
            ->groupBy('contacts_id')
            ->asc(self::TABLE . '.contact_item_value')
            ->findAll();
    }

    /**
     * Return contact with header items
     *
     * @access  public
     * @return  array
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function getByIDWithHeader($contacts_id)
    {
        return $this->db
            ->table(self::TABLE)
            ->columns(
                ContactsItemsModel::TABLE . '.item',
                ContactsItemsModel::TABLE . '.item_type',
                self::TABLE . '.contact_item_value',
                self::TABLE . '.last_updated',
                self::TABLE . '.updated_by_user_id'
            )
            ->eq('contacts_id', $contacts_id)
            ->join(ContactsItemsModel::TABLE, 'id', 'item_id')
            ->asc(ContactsItemsModel::TABLE . '.position')
            ->findAll();
    }

    /**
     * Return Contact Values for Edit Form
     *
     * @access  public
     * @return  array
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function getValuesByID($contacts_id)
    {
        $headings = $this->getHeadings();
        $contact = $this->getByID($contacts_id);

        $return = array();
        foreach ($headings as $key => $value) {
            $trimmedItemName = ucwords(strtolower($value));
            $trimmedItem = str_replace(array(' ', '|', '(', ')', '[', ']', '#', '°'), '', $trimmedItemName);
            $return[$key . '__' . $trimmedItem] = (empty($contact[$key])) ? '' : $contact[$key]['contact_item_value'];
        }

        return $return;
    }

    /**
     * Return contact headings
     *
     * @access  public
     * @return  array
     * @author  Martin Middeke
     */
    public function getHeadings()
    {
        $headings = $this->db
            ->table(ContactsItemsModel::TABLE)
            ->columns(
                ContactsItemsModel::TABLE . '.id',
                ContactsItemsModel::TABLE . '.item'
            )
            ->asc(ContactsItemsModel::TABLE . '.position')
            ->findAll();
        $return = array();
        foreach ($headings as $key => $value) {
            $return[$value['id']] = $value['item'];
        }

        return $return;
    }

    /**
     * Create a new contact
     *
     * @access  public
     * @param   array    $values    Form values
     * @return  boolean
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function create(array $values)
    {
        $create = array();
        $results = array();
        $maxContacts = $this->db->table(self::TABLE)->columns('max(' . self::TABLE . '.contacts_id) maxid')->findOne();
        $maxContacts_id = $maxContacts['maxid'];
        foreach ($values as $key => $value) {
            if (!empty($value)) {
                $create['contacts_id'] = $maxContacts_id + 1;
                $item = explode('_', $key);
                $create['item_id'] = $item[0];
                $create['contact_item_value'] = $value;
                $create['last_updated'] = time();
                if ($this->userSession->isLogged()) {
                    $create['updated_by_user_id'] = $this->userSession->getId();
                }
                $results[] = $this->db->table(self::TABLE)->persist($create);
            }
        }

        return !in_array(false, $results, true);
    }

    /**
     * Update a contact
     *
     * @access  public
     * @param   array    $values    Form values
     * @return  bool
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function update(array $values)
    {
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $create = array();
        foreach ($values as $key => $value) {
            $item = explode('__', $key);
            $item_id = $item[0];
            if (!empty($value)) {
                $create['contacts_id'] = $contacts_id;
                $create['item_id'] = $item_id;
                $create['contact_item_value'] = $value;
                $create['last_updated'] = time();
                if ($this->userSession->isLogged()) {
                    $create['updated_by_user_id'] = $this->userSession->getId();
                }
                if ($this->db->table(self::TABLE)->eq('contacts_id', $contacts_id)->eq('item_id', $item_id)->exists()) {
                    $results[] = $this->db
                        ->table(self::TABLE)
                        ->eq('contacts_id', $contacts_id)
                        ->eq('item_id', $item_id)
                        ->update($create);
                } else {
                    $results[] = $this->db
                        ->table(self::TABLE)
                        ->eq('contacts_id', $contacts_id)
                        ->eq('item_id', $item_id)
                        ->persist($create);
                }
            } else {
                if ($this->db->table(self::TABLE)->eq('contacts_id', $contacts_id)->eq('item_id', $item_id)->exists()) {
                    $results[] = $this->db
                        ->table(self::TABLE)
                        ->eq('contacts_id', $contacts_id)
                        ->eq('item_id', $item_id)
                        ->remove();
                }
            }
        }

        return !in_array(false, $results, true);
    }

    /**
     * Delete a contact
     *
     * @access  public
     * @param   integer  $contacts_id
     * @return  bool
     * @author  Martin Middeke
     */
    public function remove($contacts_id)
    {
        return $this->db->table(self::TABLE)->eq('contacts_id', $contacts_id)->remove();
    }
}
