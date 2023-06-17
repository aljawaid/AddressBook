<?php

namespace Kanboard\Plugin\AddressBook\Helper;

use Kanboard\Core\Base;

class ContactsHelper extends Base
{
    public function selectItem(array $values, array $errors = array(), array $attributes = array())
    {
        $attributes = array_merge(array('tabindex="1"', 'required', 'maxlength="30"'), $attributes);

        $html = $this->helper->form->label(t('Property Name'), 'item');
        $html .= $this->helper->form->text('item', $values, $errors, $attributes);

        return $html;
    }

    public function getItems()
    {
        return $this->contactsItemsModel->getAllItems();
    }

    /**
     * Get contact items by id
     *
     * @access public
     * @param  integer $contacts_id
     * @return array
     */
    public function getContactByID($contacts_id)
    {
        return $this->contactsModel->getByID($contacts_id);
    }

    public function getContactsIDs($task_id)
    {
        return $this->contactsTaskModel->getByTaskId($task_id);
    }

    {
    }
}
