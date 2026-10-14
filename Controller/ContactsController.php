<?php

namespace Kanboard\Plugin\AddressBook\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Controller\PageNotFoundException;

/**
 * Contacts Controller
 *
 * Project assignment flows are covered by tests/Integration/GlobalDirectoryTest.php.
 *
 * @package Controller
 * @author  Martin Middeke
 * @author  aljawaid
 */
class ContactsController extends BaseController
{
    /**
     * Display list of contacts and create new contacts
     *
     * @access  public
     * @param   array $values
     * @param   array $errors
     * @throws  \Kanboard\Core\Controller\PageNotFoundException
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function project(array $values = array(), array $errors = array())
    {
        $project = $this->getProject();
        $this->response->html($this->helper->layout->project('addressBook:project/contacts', array(
            'title' => t('Address Book'),
            'values' => $values,
            'errors' => $errors,
            'project' => $project,
            'contacts' => $this->contactsProjectModel->getAllByProjectId($project['id']),
            'availableContacts' => $this->contactsProjectModel->getAvailableByProjectId($project['id']),
            'addNew' => true,
        )));
    }

    /**
     * Save a new contact
     *
     * @access  public
     * @author  Martin Middeke
     */
    public function save()
    {
        $this->checkCSRFForm();
        $project = $this->getProject();
        $values = $this->request->getValues();

        list($valid, $errors) = $this->contactsValidator->validateCreation($values);

        if ($valid) {
            $contacts_id = $this->contactsModel->create($values);

            if ($contacts_id !== false && $this->contactsProjectModel->assignToProject($contacts_id, $project['id'])) {
                $this->flash->success(t('Your contact has been created successfully'));
                return $this->response->redirect($this->helper->url->to('ContactsController', 'project', array('project_id' => $project['id'], 'plugin' => 'AddressBook')));
            } else {
                if ($contacts_id !== false) {
                    $this->contactsModel->remove($contacts_id);
                }
                $this->flash->failure(t('Unable to create your contact'));
            }
        }

        return $this->project($values, $errors);
    }

    /**
     * Show all items from contact
     *
     * @access  public
     * @author  Martin Middeke
     */
    public function details()
    {
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $this->requireProjectContact($contacts_id, $project['id']);

        $this->response->html($this->helper->layout->app('addressBook:contact/details', array(
            'title' => t('Contact Details'),
            'contact' => $this->contactsModel->getByIDWithHeader($contacts_id),
            'contact_id' => $contacts_id,
        )));
    }

    /**
     * Show contact list in task footer (board view)
     *
     * @access  public
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function boardTaskFooter()
    {
        $task = $this->getTask();

        $this->response->html($this->helper->layout->app('addressBook:task/footer-tooltip', array(
            'title' => t('Contacts'),
            'contacts' => $this->contactsTaskModel->getByTaskId($task['id']),
            'task_id' => $task['id'],
            'project_id' => $task['project_id'],
        )));
    }

    /**
     * Edit a contact (display the form)
     *
     * @access public
     * @param   array $values
     * @param   array $errors
     * @throws  AccessForbiddenException
     * @throws  \Kanboard\Core\Controller\PageNotFoundException
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function edit(array $values = array(), array $errors = array())
    {
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $this->requireProjectContact($contacts_id, $project['id']);
        $contact = $this->contactsModel->getValuesByID($contacts_id);

        $this->response->html($this->helper->layout->project('addressBook:contact/edit', array(
            'title' => t('Edit Contact'),
            'values' => empty($values) ? $contact : $values,
            'errors' => $errors,
            'headings' => $this->contactsModel->getHeadings(),
            'contacts_id' => $contacts_id,
            'project' => $project,
        )));
    }

    /**
     * Update items from contact
     *
     * @access  public
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function update()
    {
        $this->checkCSRFForm();
        $project = $this->getProject();
        $this->requireProjectContact($this->request->getIntegerParam('contacts_id'), $project['id']);

        $values = $this->request->getValues();

        list($valid, $errors) = $this->contactsValidator->validateModification($values);

        if ($valid) {
            if ($this->contactsModel->update($values)) {
                $this->flash->success(t('Your contact has been updated successfully'));
                return $this->response->redirect($this->helper->url->to('ContactsController', 'project', array('project_id' => $project['id'], 'plugin' => 'AddressBook')));
            } else {
                $this->flash->failure(t('Unable to update contact'));
            }
        }

        return $this->project($values, $errors);
    }

    /**
     * Confirmation dialog before removing a contact
     *
     * @access  public
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function confirm()
    {
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $this->requireProjectContact($contacts_id, $project['id']);
        $contact = $this->contactsModel->getByIDWithHeader($contacts_id);

        $this->response->html($this->helper->layout->project('addressBook:contact/remove', array(
            'project' => $project,
            'contact' => $contact[0],
            'contacts_id' => $contacts_id,
            'title' => t('Delete Contact'),
            'contact_name' => $contact[0]['contact_item_value'],
        )));
    }

    /**
     * Delete a contact
     *
     * @access public
     */
    public function remove()
    {
        $this->checkCSRFParam();
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $this->requireProjectContact($contacts_id, $project['id']);

        if ($this->contactsModel->remove($contacts_id)) {
            $this->flash->success(t('Contact removed successfully'));
        } else {
            $this->flash->failure(t('Unable to remove this contact'));
        }

        $this->response->redirect($this->helper->url->to('ContactsController', 'project', array('project_id' => $project['id'], 'plugin' => 'AddressBook')));
    }

    /**
     * Show contacts in a task
     *
     * @access  public
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function task()
    {
        $project = $this->getProject();
        $task = $this->getTask();

        $contacts = $this->contactsTaskModel->getLinked($task['id']);
        $contactsNotInTask = $this->contactsTaskModel->getNotLinked($task['id'], $project['id']);
        $allContacts = $this->contactsProjectModel->getAllByProjectId($project['id']);

        $this->response->html($this->helper->layout->task('addressBook:task/link-contacts', array(
            'title' => t('Task Contacts'),
            'formtitle' => t('Linked Contacts'),
            'addformtitle' => t('Available Contacts'),
            'task' => $task,
            'project' => $project,
            'contacts' => $contacts,
            'contactsNotInTask' => $contactsNotInTask,
            'allProjectContacts' => $allContacts,
        )));
    }

    /**
     * Add a contact to task
     *
     * @access  public
     * @author  Martin Middeke
     */
    public function addToTask()
    {
        $this->checkCSRFParam();
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $task_id = $this->request->getIntegerParam('task_id');

        $this->getTask();

        if (! $this->contactsTaskModel->addToTask($contacts_id, $task_id)) {
            $this->flash->failure(t('Unable to link this contact to the task'));
        }

        $this->response->redirect($this->helper->url->to('ContactsController', 'task', array('project_id' => $project['id'], 'task_id' => $task_id, 'plugin' => 'AddressBook')));
    }

    /**
     * Remove a contact from task
     *
     * @access  public
     * @author  Martin Middeke
     */
    public function removeFromTask()
    {
        $this->checkCSRFParam();
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $task_id = $this->request->getIntegerParam('task_id');

        $this->getTask();
        $this->requireProjectContact($contacts_id, $project['id']);
        $this->contactsTaskModel->removeFromTask($contacts_id, $task_id);

        $this->response->redirect($this->helper->url->to('ContactsController', 'task', array('project_id' => $project['id'], 'task_id' => $task_id, 'plugin' => 'AddressBook')));
    }

    /**
     * Assign an existing global contact to a project
     *
     * @return void
     */
    public function assignToProject()
    {
        $this->checkCSRFForm();
        $project = $this->getProject();
        $contacts_id = (int) $this->request->getValue('contacts_id');

        if ($this->contactsProjectModel->assignToProject($contacts_id, $project['id'])) {
            $this->flash->success(t('Contact assigned to this project'));
        } else {
            $this->flash->failure(t('Unable to assign this contact to the project'));
        }

        $this->response->redirect($this->helper->url->to('ContactsController', 'project', array('project_id' => $project['id'], 'plugin' => 'AddressBook')));
    }

    /**
     * Remove a contact from a project without deleting the global contact
     *
     * @return void
     */
    public function removeFromProject()
    {
        $this->checkCSRFParam();
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $this->requireProjectContact($contacts_id, $project['id']);

        if ($this->contactsProjectModel->removeFromProject($contacts_id, $project['id'])) {
            $this->flash->success(t('Contact removed from this project'));
        } else {
            $this->flash->failure(t('Unable to remove this contact from the project'));
        }

        $this->response->redirect($this->helper->url->to('ContactsController', 'project', array('project_id' => $project['id'], 'plugin' => 'AddressBook')));
    }

    /**
     * Confirm removal of a contact and its task links from a project
     *
     * @return void
     */
    public function confirmRemoveFromProject()
    {
        $project = $this->getProject();
        $contacts_id = $this->request->getIntegerParam('contacts_id');
        $this->requireProjectContact($contacts_id, $project['id']);
        $contact = $this->contactsModel->getByIDWithHeader($contacts_id);

        $this->response->html($this->template->render('addressBook:project/remove-contact', array(
            'project' => $project,
            'contacts_id' => $contacts_id,
            'contact_name' => $contact[0]['contact_item_value'],
        )));
    }

    /**
     * Explain the global contact assignment model in a project tooltip
     *
     * @return void
     */
    public function assignmentHelp()
    {
        $this->getProject();
        $this->response->html($this->template->render('addressBook:project/assignment-help'));
    }

    /**
     * Require a contact to be assigned to the requested project
     *
     * @param  integer $contacts_id
     * @param  integer $project_id
     * @return void
     * @throws PageNotFoundException
     */
    private function requireProjectContact($contacts_id, $project_id)
    {
        if (! $this->contactsProjectModel->isAssignedToProject($contacts_id, $project_id)) {
            throw new PageNotFoundException();
        }
    }
}
