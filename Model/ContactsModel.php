<?php

namespace Kanboard\Plugin\AddressBook\Model;

use Kanboard\Core\Base;

/**
 * Contacts model
 *
 * @package  model
 * @author   Martin Middeke
 */
class ContactsModel extends Base
{
    /**
     * SQL table name for ContactsItems
     *
     * @var string
     */
    const TABLE = 'address_book_contacts_contact';

    /**
     * Return contact by id
     *
     * @access public
     * @param  integer $contacts_id
     * @return array
     */
    public function getByID($contacts_id)
    {
        $contact = $this->db
            ->table(self::TABLE)
            ->eq('contacts_id', $contacts_id)
            ->join(ContactsItemsModel::TABLE, 'id', 'item_id')
            ->asc(ContactsItemsModel::TABLE.'.position')
            ->findAll();
        $return = array();
        foreach ($contact as $key => $value){
            $return[$value['id']] = $value;
        }
        return $return;
    }

    /**
     * Return all contacts
     *
     * @access public
     * @return array
     */
    public function getAll()
    {
        $firstPosition = $this->db->table(ContactsItemsModel::TABLE)->columns('id')->eq('position', 1)->findOne();
        return $this->db
            ->table(self::TABLE)
            ->join(ContactsItemsModel::TABLE, 'id', 'item_id')
            ->asc(ContactsItemsModel::TABLE.'.position')
            ->groupBy('contacts_id')
            ->asc(self::TABLE.'.value')
            ->findAll();
    }

    /**
     * Return contact with header items
     *
     * @access public
     * @return array
     */
    public function getByIDWithHeader($contacts_id)
    {
        return $this->db
            ->table(self::TABLE)
            ->columns(
                ContactsItemsModel::TABLE.'.item',
                self::TABLE.'.value'
            )
            ->eq('contacts_id', $contacts_id)
            ->join(ContactsItemsModel::TABLE, 'id', 'item_id')
            ->asc(ContactsItemsModel::TABLE.'.position')
            ->findAll();
    }

    /**
     * Return contact values for edit form
     *
     * @access public
     * @return array
     */
    public function getValuesByID($contacts_id)
    {
        $headings = $this->getHeadings();
        $contact = $this->getByID($contacts_id);

        $return = array();
        foreach ($headings as $key => $value){
            $return[$key . '_' . $value] = (empty($contact[$key]))?'':$contact[$key]['value'];
        }
       return $return;
    }

    /**
     * Return contact headings
     *
     * @access public
     * @return array
     */
    public function getHeadings()
    {
        $headings = $this->db
            ->table(ContactsItemsModel::TABLE)
            ->columns(
                ContactsItemsModel::TABLE.'.id',
                ContactsItemsModel::TABLE.'.item'
            )
            ->asc(ContactsItemsModel::TABLE.'.position')
            ->findAll();
        $return = array();
        foreach ($headings as $key => $value){
            $return[$value['id']] = $value['item'];
        }
        return $return;
    }

    
    /**
     * Create a new contact
     *
     * @access public
     * @param  array    $values    Form values
     * @return boolean
     */
    public function create(array $values)
    {
        $create = array();
        $results = array();
        $maxContacts = $this->db->table(self::TABLE)->columns('max('.self::TABLE.'.contacts_id) maxid')->findOne();
        $maxContacts_id = $maxContacts['maxid'];
        foreach ($values as $key => $value) {
            if (!empty($value)){
                $create['contacts_id'] = $maxContacts_id + 1;
                $item = explode('_', $key);
                $create['item_id'] = $item[0];
                $create['value'] = $value;
                $results[] = $this->db->table(self::TABLE)->persist($create);
            }
       }

        return !in_array(false, $results, true);
    }

    /**
     * Update a contact
     *
     * @access public
     * @param  array    $values    Form values
     * @return bool
     */
    public function update(array $values)
    {
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $create = array();
        foreach ($values as $key => $value) {
            $item = explode('_', $key);
            $item_id = $item[0];
            if (!empty($value)){
                $create['contacts_id'] = $contacts_id;
                $create['item_id'] = $item_id;
                $create['value'] = $value;
                if ($this->db
                    ->table(self::TABLE)
                    ->eq('contacts_id', $contacts_id)
                    ->eq('item_id', $item_id)
                    ->exists())
                    {
                        $results[] = $this->db
                            ->table(self::TABLE)
                            ->eq('contacts_id', $contacts_id)
                            ->eq('item_id', $item_id)
                            ->update($create);
                    }
                    else {
                        $results[] = $this->db
                            ->table(self::TABLE)
                            ->eq('contacts_id', $contacts_id)
                            ->eq('item_id', $item_id)
                            ->persist($create);
                    }
            }
            else {
                if ($this->db
                    ->table(self::TABLE)
                    ->eq('contacts_id', $contacts_id)
                    ->eq('item_id', $item_id)
                    ->exists())
                    {
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
     * Remove a contact
     *
     * @access public
     * @param  integer  $contacts_id
     * @return bool
     */
    public function remove($contacts_id)
    {
        return $this->db->table(self::TABLE)->eq('contacts_id', $contacts_id)->remove();
    }

    /**
     * Get available colors from application and replace with colors from board if not in ColorsController settings
     *
     * @access public
     * @param  bool $prepend
     * @return array
     */
    public function getList($listing)
    {
		// don nothing if in colors settings
		if ($this->router->getController() === 'ColorsController') return $listing;

        $project_id = $this->request->getIntegerParam('project_id', 0);
        $project_colors = $this->getProjectColors($project_id, $this->getAppColors($listing));

        return $this->colorsModel->getProjectColorNames($project_colors);
    }

    /**
     * Get all assigned colornames for a project
     *
     * @access public
     * @param  integer   $project_id
     * @return array
     */
    public function getProjectColors($project_id, $app_colors = NULL)
    {

        if(! isset($app_colors)) $app_colors = $this->getAppColors($this->helper->task->getColors());
        $projectMetadata = $this->projectMetadataModel->getAll($project_id);
        $project_colors = array();

        foreach ($app_colors as $color_id => $color_names) {
            $project_color = $projectMetadata['color_filter_' . $color_id];

            $color_hide = false;
            if (array_key_exists ('color_filter_' . $color_id . '_hide', $projectMetadata)) {
                $color_hide = true;
            }
            $project_colors[$color_id] = array('color_name' => $color_names['color_name'], 'app_color' => $color_names['app_color'], 'project_color' => $project_color, 'color_hide' => $color_hide);
        }

        return $project_colors;
    }

    /**
     * Get colornames for a project
     *
     * @access public
     * @param  integer   $project_id
     * @return array
     */
    public function getProjectColorNames($project_colors)
    {
        $colors = array();

		foreach ($project_colors as $color_id => $color_values) {
            if (! array_key_exists ('color_filter_' . $color_id, $project_colors)) {
                if(! $color_values['color_hide']){
                    $colors[$color_id] = $color_values['color_name'];
                    if (strlen($color_values['app_color']) > 0) $colors[$color_id] = $color_values['app_color'];
                    if (strlen($color_values['project_color']) > 0) $colors[$color_id] = $color_values['project_color'];
                }
            }
        }
        return $colors;

	}

    /**
     * Get all assigned colornames for the application
     *
     * @access private
     * @return array
     */
    private function getAppColors($colors)
    {
        $app_colors = array();

        foreach ($colors as $color_id => $color_name) {
            $app_colors[$color_id] = array('color_name' => $color_name, 'app_color' => $this->configModel->get('colors_' . $color_id, $color_name));
        }
            
        return $app_colors;
    }

    /**
     * Remove a specific colorname
     *
     * @access public
     * @param  integer  $project_id
     * @param  string   $name
     * @return boolean
     */
    public function xxxremove($project_id, $name)
    {
		return $this->projectMetadataModel->remove($project_id, 'color_filter_' . $name);
    }

}
