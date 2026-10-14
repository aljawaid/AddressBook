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
     * SQL table name for stable contact identities
     *
     * @var string
     */
    const CONTACT_TABLE = 'address_book_contacts';

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
        $rows = $this->db
            ->table(self::TABLE)
            ->join(ContactsItemsModel::TABLE, 'id', 'item_id')
            ->asc(self::TABLE . '.contacts_id')
            ->asc(ContactsItemsModel::TABLE . '.position')
            ->findAll();

        return $this->getContactSummaries($rows);
    }

    /**
     * Return selected contacts without relying on database-specific grouping rules
     *
     * @access public
     * @param  array $contact_ids
     * @return array
     */
    public function getAllByIds(array $contact_ids)
    {
        if (empty($contact_ids)) {
            return array();
        }

        $rows = $this->db
            ->table(self::TABLE)
            ->in(self::TABLE . '.contacts_id', array_unique($contact_ids))
            ->join(ContactsItemsModel::TABLE, 'id', 'item_id')
            ->asc(self::TABLE . '.contacts_id')
            ->asc(ContactsItemsModel::TABLE . '.position')
            ->findAll();

        return $this->getContactSummaries($rows);
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
        $contactValues = array();

        foreach ($values as $key => $value) {
            if (!empty($value)) {
                $item = explode('_', $key);
                $contactValues[] = array(
                    'item_id' => $item[0],
                    'contact_item_value' => $value,
                );
            }
        }

        if (empty($contactValues)) {
            return false;
        }

        $this->db->startTransaction();

        if (! $this->db->table(self::CONTACT_TABLE)->persist(array('created_at' => time()))) {
            $this->db->cancelTransaction();
            return false;
        }

        $contact_id = (int) $this->db->getLastId();
        $updated_by_user_id = $this->userSession->isLogged() ? $this->userSession->getId() : 0;

        foreach ($contactValues as $contactValue) {
            $contactValue['contacts_id'] = $contact_id;
            $contactValue['last_updated'] = time();
            $contactValue['updated_by_user_id'] = $updated_by_user_id;

            if (! $this->db->table(self::TABLE)->persist($contactValue)) {
                $this->db->cancelTransaction();
                return false;
            }
        }

        $this->db->closeTransaction();

        return $contact_id;
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
        $results = array();

        if (! $this->exists($contacts_id)) {
            return false;
        }

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
        return $this->db->table(self::CONTACT_TABLE)->eq('id', $contacts_id)->remove();
    }

    /**
     * Return true when a stable contact identity exists
     *
     * @access public
     * @param  integer $contacts_id
     * @return boolean
     */
    public function exists($contacts_id)
    {
        return $this->db->table(self::CONTACT_TABLE)->eq('id', $contacts_id)->exists();
    }

    /**
     * Collapse ordered property rows to one deterministic summary row per contact
     *
     * @access private
     * @param  array $rows
     * @return array
     */
    private function getContactSummaries(array $rows)
    {
        $contacts = array();

        foreach ($rows as $row) {
            if (! isset($contacts[$row['contacts_id']])) {
                $contacts[$row['contacts_id']] = $row;
            }
        }

        uasort($contacts, function (array $left, array $right) {
            return strcasecmp($left['contact_item_value'], $right['contact_item_value']);
        });

        return array_values($contacts);
    }
}
