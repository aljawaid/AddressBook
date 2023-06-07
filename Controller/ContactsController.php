<?php

namespace Kanboard\Plugin\AddressBook\Controller;

use Kanboard\Controller\BaseController;

/**
 * Contacts
 *
 * @package controller
 * @author  Martin Middeke
 */
class ContactsController extends BaseController
{
    /**
     * Display list of contacts and create new contacts
     *
     * @access public
     * @param  array $values
     * @param  array $errors
     * @throws \Kanboard\Core\Controller\PageNotFoundException
     */
    public function project(array $values = array(), array $errors = array())
    {
        $project = $this->getProject();
        $this->response->html($this->helper->layout->project('addressBook:project/contacts', array(
            'title' => t('Address Book'),
            'values' => $values,
            'errors' => $errors,
            'project' => $project,
            'contacts' => $this->contactsModel->getAll(),
            'addNew' => true,
        )));
    }

    /**
     * Save a new contact
     *
     * @access public
     */
    public function save()
    {
        $project = $this->getProject();
        $values = $this->request->getValues();

        list($valid, $errors) = $this->contactsValidator->validateCreation($values);

        if ($valid) {
            if ($this->contactsModel->create($values) !== false) {
                $this->flash->success(t('Your contact has been created successfully.'));
                return $this->response->redirect($this->helper->url->to('ContactsController', 'project', array('plugin' => 'AddressBook', 'project_id' => $project['id'])));
            } else {
                $this->flash->failure(t('Unable to create your contact.'));
            }
        }

        return $this->index($values, $errors);
    }

    /**
     * Show all items from contact
     *
     * @access public
     */
    public function details()
    {
        $this->response->html($this->helper->layout->app('addressBook:contact/details', array(
            'title' => t('Contacts'),
            'contact' => $this->contactsModel->getByIDWithHeader($this->request->getIntegerParam('contacts_id')),
        )));
    }

    /**
     * Show contact list in task footer (board view)
     *
     * @access public
     */

    // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function task_footer()
    {
        $task = $this->getTask();

        $this->response->html($this->helper->layout->app('addressBook:task/contacts', array(
            'title' => t('Contacts'),
            'contacts' => $this->contactsTaskModel->getByTaskId($task['id']),
        )));
    }

    /**
     * Edit a contact (display the form)
     *
     * @access public
     * @param  array $values
     * @param  array $errors
     * @throws AccessForbiddenException
     * @throws \Kanboard\Core\Controller\PageNotFoundException
     */
    public function edit(array $values = array(), array $errors = array())
    {
        $contact = $this->contactsModel->getValuesByID($this->request->getIntegerParam('contacts_id'));
        $this->response->html($this->helper->layout->project('addressBook:contact/edit', array(
            'title' => t('Edit Contact'),
            'values' => empty($values) ? $contact : $values,
            'errors' => $errors,
            'headings' => $this->contactsModel->getHeadings(),
            'contacts_id' => $this->request->getIntegerParam('contacts_id'),
            'project' => $this->getProject(),
        )));
    }

    /**
     * Update items from contact
     *
     * @access public
     */
    public function update()
    {
        $project = $this->getProject();
//        $filter = $this->customFilterModel->getById($this->request->getIntegerParam('filter_id'));

//        $this->checkPermission($project, $filter);

        $values = $this->request->getValues();

//        if (! isset($values['is_shared'])) {
//            $values += array('is_shared' => 0);
//        }
//
//        if (! isset($values['append'])) {
//            $values += array('append' => 0);
//        }

        list($valid, $errors) = $this->contactsValidator->validateModification($values);

        if ($valid) {
            if ($this->contactsModel->update($values)) {
                $this->flash->success(t('Your contact has been updated successfully.'));
                return $this->response->redirect($this->helper->url->to('ContactsController', 'project', array('plugin' => 'AddressBook', 'project_id' => $project['id'])));
            } else {
                $this->flash->failure(t('Unable to update contact.'));
            }
        }

        return $this->project($values, $errors);
    }

    /**
     * Confirmation dialog before removing a contact
     *
     * @access public
     */
    public function confirm()
    {
        $project = $this->getProject();
        $contact = $this->contactsModel->getByIDWithHeader($this->request->getIntegerParam('contacts_id'));

        $this->response->html($this->helper->layout->project('addressBook:contact/remove', array(
            'project' => $project,
            'contact' => $contact[0],
            'contacts_id' => $this->request->getIntegerParam('contacts_id'),
            'title' => t('Remove Contact'),
        )));
    }

    /**
     * Remove a contact
     *
     * @access public
     */
    public function remove()
    {
        $this->checkCSRFParam();
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');

        //$this->checkPermission($project, $filter);

        if ($this->contactsModel->remove($contacts_id)) {
            $this->flash->success(t('Contact removed successfully.'));
        } else {
            $this->flash->failure(t('Unable to remove this contact.'));
        }

        $this->response->redirect($this->helper->url->to('ContactsController', 'project', array('plugin' => 'AddressBook', 'project_id' => $project['id'])));
    }

    /**
     * Edit contacts in a task
     *
     * @access public
     */
    public function task()
    {
        $project = $this->getProject();
        $task = $this->getTask();

        $contacts = $this->contactsTaskModel->getAssigned($task['id']);
        $contactsNotInTask = $this->contactsTaskModel->getNotAssigned($task['id']);

        $this->response->html($this->helper->layout->task('addressBook:task/assign-contacts', array(
            'title' => t('Task Contacts'),
            'formtitle' => t('Assigned Contacts'),
            'addformtitle' => t('Available Contacts'),
            'task' => $task,
            'project' => $project,
            'contacts' => $contacts,
            'contactsNotInTask' => $contactsNotInTask,
        )));
    }

    /**
     * Add a contact to task
     *
     * @access public
     */
    public function addToTask()
    {
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $task_id = $this->request->getIntegerParam('task_id');

        $this->contactsTaskModel->addToTask($contacts_id, $task_id);

        $this->response->redirect($this->helper->url->to('ContactsController', 'task', array('plugin' => 'AddressBook', 'project_id' => $project['id'], 'task_id' => $task_id)));
    }

    /**
     * Remove a contact from task
     *
     * @access public
     */
    public function removeFromTask()
    {
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $task_id = $this->request->getIntegerParam('task_id');

        $this->contactsTaskModel->removeFromTask($contacts_id, $task_id);

        $this->response->redirect($this->helper->url->to('ContactsController', 'task', array('plugin' => 'AddressBook', 'project_id' => $project['id'], 'task_id' => $task_id)));
    }
}
