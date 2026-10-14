<?php

namespace Kanboard\Plugin\AddressBook\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Controller\PageNotFoundException;

/**
 * Provides the administrator-managed global contact directory.
 * Covered by tests/Integration/GlobalDirectoryTest.php.
 *
 * @package Controller
 * @author  aljawaid
 */
class ContactsDirectoryController extends BaseController
{
    /**
     * Display the global contact directory
     *
     * @param  array $values
     * @param  array $errors
     * @return void
     */
    public function index(array $values = array(), array $errors = array())
    {
        $contacts = $this->contactsModel->getAll();
        $assignments = array();

        foreach ($contacts as $contact) {
            $assignments[$contact['contacts_id']] = $this->contactsProjectModel->getProjectsByContactId($contact['contacts_id']);
        }

        $this->response->html($this->helper->layout->config('addressBook:contact/index', array(
            'title' => t('Global Address Book'),
            'contacts' => $contacts,
            'assignments' => $assignments,
            'items' => $this->contactsItemsModel->getAllItems(),
            'values' => $values,
            'errors' => $errors,
        )));
    }

    /**
     * Save a new global contact
     *
     * @return mixed
     */
    public function save()
    {
        $this->checkCSRFForm();
        $values = $this->request->getValues();
        list($valid, $errors) = $this->contactsValidator->validateCreation($values);

        if ($valid && $this->contactsModel->create($values) !== false) {
            $this->flash->success(t('Your contact has been created successfully'));
            return $this->response->redirect($this->helper->url->to('ContactsDirectoryController', 'index', array('plugin' => 'AddressBook')));
        }

        $this->flash->failure(t('Unable to create your contact'));
        return $this->index($values, $errors);
    }

    /**
     * Display global contact details
     *
     * @return void
     */
    public function details()
    {
        $contacts_id = $this->getContactId();

        $this->response->html($this->template->render('addressBook:contact/details', array(
            'title' => t('Contact Details'),
            'contact' => $this->contactsModel->getByIDWithHeader($contacts_id),
            'contact_id' => $contacts_id,
        )));
    }

    /**
     * Display the global contact edit form
     *
     * @param  array $values
     * @param  array $errors
     * @return void
     */
    public function edit(array $values = array(), array $errors = array())
    {
        $contacts_id = $this->getContactId();
        $contact = $this->contactsModel->getValuesByID($contacts_id);

        $this->response->html($this->template->render('addressBook:contact/edit', array(
            'title' => t('Edit Contact'),
            'values' => empty($values) ? $contact : $values,
            'errors' => $errors,
            'headings' => $this->contactsModel->getHeadings(),
            'contacts_id' => $contacts_id,
            'form_controller' => 'ContactsDirectoryController',
            'form_action' => 'update',
            'form_params' => array('contacts_id' => $contacts_id, 'plugin' => 'AddressBook'),
        )));
    }

    /**
     * Update a global contact
     *
     * @return mixed
     */
    public function update()
    {
        $this->checkCSRFForm();
        $this->getContactId();
        $values = $this->request->getValues();
        list($valid, $errors) = $this->contactsValidator->validateModification($values);

        if ($valid && $this->contactsModel->update($values)) {
            $this->flash->success(t('Your contact has been updated successfully'));
            return $this->response->redirect($this->helper->url->to('ContactsDirectoryController', 'index', array('plugin' => 'AddressBook')));
        }

        $this->flash->failure(t('Unable to update contact'));
        return $this->edit($values, $errors);
    }

    /**
     * Display the global contact removal confirmation
     *
     * @return void
     */
    public function confirm()
    {
        $contacts_id = $this->getContactId();
        $contact = $this->contactsModel->getByIDWithHeader($contacts_id);

        $this->response->html($this->template->render('addressBook:contact/remove', array(
            'contact' => $contact[0],
            'contacts_id' => $contacts_id,
            'title' => t('Delete Contact'),
            'contact_name' => $contact[0]['contact_item_value'],
            'remove_controller' => 'ContactsDirectoryController',
            'remove_action' => 'remove',
            'remove_params' => array('contacts_id' => $contacts_id, 'plugin' => 'AddressBook'),
        )));
    }

    /**
     * Remove a global contact and all of its assignments
     *
     * @return void
     */
    public function remove()
    {
        $this->checkCSRFParam();
        $contacts_id = $this->getContactId();

        if ($this->contactsModel->remove($contacts_id)) {
            $this->flash->success(t('Contact removed successfully'));
        } else {
            $this->flash->failure(t('Unable to remove this contact'));
        }

        $this->response->redirect($this->helper->url->to('ContactsDirectoryController', 'index', array('plugin' => 'AddressBook')));
    }

    /**
     * Return a validated contact ID
     *
     * @return integer
     * @throws PageNotFoundException
     */
    private function getContactId()
    {
        $contacts_id = $this->request->getIntegerParam('contacts_id');

        if (!$this->contactsModel->exists($contacts_id)) {
            throw new PageNotFoundException();
        }

        return $contacts_id;
    }
}
