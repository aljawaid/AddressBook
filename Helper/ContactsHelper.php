<?php

namespace Kanboard\Plugin\AddressBook\Helper;

use Kanboard\Core\Base;

class ContactsHelper extends Base
{
    /**
     * Select Items
     *
     * @return  html
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function selectItem(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="1"', 'required', 'maxlength="30"'), $attributes);

        $html = $this->helper->form->label(t('Property Name'), 'item', array('class="profile-property-label"'));
        $html .= $this->helper->form->text('item', $values, $errors, $attributes);
        $html .= $this->helper->form->label(t('Property Note'), 'item_help', array('class="profile-property-label"'));
        $html .= $this->helper->form->text('item_help', $values, $errors, array('tabindex="2"', 'maxlength="100"', 'placeholder="' . $values['item_help'] . '"', 'title="' . t('Maximum 100 characters only') . '"'));
        $html .= '<p class="form-help modal-form-help">' . t('Add a short descriptive note for this property to help users when creating contacts') . '</p>';

        return $html;
    }

    public function getItems()
    {
        return $this->contactsItemsModel->getAllItems();
    }

    /**
     * Get Contact Items by Contact ID
     *
     * @access  public
     * @param   integer     $contacts_id
     * @return  array
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function getContactByID($contacts_id)
    {
        return $this->contactsModel->getByID($contacts_id);
    }

    /**
     * Get contacts by task id
     *
     * @return array
     * @author  Martin Middeke
     */
    public function getContactsIDs($task_id)
    {
        return $this->contactsTaskModel->getByTaskId($task_id);
    }

    /**
     * Get The Property Item Type
     *
     * @access  public
     * @param   integer     $item_id
     * @return  string      item_type
     * @author  aljawaid
     */
    public function getItemType($item_id)
    {
        $item_type = $this->contactsItemsModel->getByID($item_id);

        return $item_type['item_type'];
    }

    /**
     * Get The Property Item Help
     *
     * @access  public
     * @param   integer     $item_id
     * @return  string      item_help
     * @author  aljawaid
     */
    public function getItemHelp($item_id)
    {
        $item_help = $this->contactsItemsModel->getByID($item_id);

        return $item_help['item_help'];
    }
}
