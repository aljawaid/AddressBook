<?php

namespace Kanboard\Plugin\AddressBook\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Controller\PageNotFoundException;

/**
 * Contacts Items Controller
 *
 * @package  Controller
 * @author   Martin Middeke
 * @author   aljawaid
 */
class ContactsItemsController extends BaseController
{
    /**
     * Get the current item
     *
     * @access  protected
     * @return  array
     * @throws  PageNotFoundException
     * @author  Martin Middeke
     */
    protected function getItem()
    {
        $item = $this->contactsItemsModel->getById($this->request->getIntegerParam('item_id'));

        if (empty($item)) {
            throw new PageNotFoundException();
        }

        return $item;
    }

    /**
     * Contacts items config page
     *
     * @access  public
     * @author  Martin Middeke
     */
    public function config()
    {
        $this->response->html($this->helper->layout->config('addressBook:config/index', array(
            'title' => t('Address Book Settings'),
            'items' => $this->contactsItemsModel->getAllItems(),
        )));
    }

    /**
     * Edit properties
     *
     * @return  void
     * @author  Martin Middeke
     * @author  aljawaid
     */
    public function edit(array $values = array(), array $errors = array())
    {
        $item = $this->getItem();

        $this->response->html($this->template->render('addressBook:config/edit', array(
            'values' => empty($values) ? $item : $values,
            'errors' => $errors,
            'item' => $item,
        )));
    }

    /**
     * Update and validate an item
     *
     * @access  public
     * @author  Martin Middeke
     */
    public function update()
    {
        $values = $this->request->getValues();

        list($valid, $errors) = $this->contactsValidator->validateItemModification($values);

        if ($valid) {
            if ($this->contactsItemsModel->update($values)) {
                $this->flash->success(t('Contact Property Updated'));
            } else {
                $this->flash->failure(t('Unable to Update Contact Property'));
            }
        }

        return $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')), true);
    }

    /**
     * Move item position
     *
     * @access  public
     * @author  Martin Middeke
     */
    public function movePosition()
    {
        $item_id = $this->request->getIntegerParam('item_id');
        $direction = $this->request->getStringParam('direction');
        $result = $this->contactsItemsModel->changePosition($item_id, $direction);

        // phpcs:ignore Generic.ControlStructures.InlineControlStructure.NotAllowed
        if ($result) return $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')), true);
    }

    /**
     * Confirmation dialog before removing an item
     *
     * @access public
     * @author  Martin Middeke
     */
    public function confirm()
    {
        $item = $this->contactsItemsModel->getById($this->request->getIntegerParam('item_id'));

        $this->response->html($this->helper->layout->config('addressBook:config/remove', array(
            'item' => $item,
            'title' => t('Delete Contact Property'),
        )));
    }

    /**
     * Delete an item
     *
     * @access  public
     * @author  Martin Middeke
     */
    public function remove()
    {
        $this->checkCSRFParam();
        $item_id = $this->request->getIntegerParam('item_id');

        if ($this->contactsItemsModel->remove($item_id)) {
            $this->flash->success(t('Contact Property Deleted Successfully'));
        } else {
            $this->flash->failure(t('Unable to Delete Contact Property'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Save a new item
     *
     * @access  public
     * @author  Martin Middeke
     */
    public function save()
    {
        $values = $this->request->getValues();

        list($valid, $errors) = $this->contactsValidator->validateItemModification($values);

        if ($valid) {
            if ($this->contactsItemsModel->save($values)) {
                $this->flash->success(t('Contact Property Saved'));
            } else {
                $this->flash->failure(t('Unable to Save Contact Property'));
            }
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Confirmation dialog before removing a property set
     *
     * @access public
     * @param   set         - name of property set
     * @author  aljawaid
     */
    public function confirmRemoveSet()
    {
        $this->response->html($this->helper->layout->config('addressBook:config/remove-set', array(
            'set' => $this->request->getStringParam('set'),
            'title' => t('Delete Property Set'),
        )));
    }

    /**
     * Delete Property Set
     *
     * @access  public
     * @param   set         - name of property set
     * @author  aljawaid
     */
    public function removeSet()
    {
        $this->checkCSRFParam();

        $set = $this->request->getStringParam('set');

        if ($this->contactsItemsModel->removeSet($set)) {
            $this->flash->success(t('Property Set Deleted'));
        } else {
            $this->flash->failure(t('Unable to Delete Property Set'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Insert Property Set - Personal
     *
     * @access  public
     * @author  aljawaid
     */
    public function insertSetPersonal()
    {
        if ($this->contactsItemsModel->insertSetPersonal()) {
            $this->flash->success(t('Personal Property Set Added'));
        } else {
            $this->flash->failure(t('Unable to Add Property Set'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Insert Property Set - Business
     *
     * @access  public
     * @author  aljawaid
     */
    public function insertSetBusiness()
    {
        if ($this->contactsItemsModel->insertSetBusiness()) {
            $this->flash->success(t('Business Property Set Added'));
        } else {
            $this->flash->failure(t('Unable to Add Property Set'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Insert Property Set - Company
     *
     * @access  public
     * @author  aljawaid
     */
    public function insertSetCompany()
    {
        if ($this->contactsItemsModel->insertSetCompany()) {
            $this->flash->success(t('Company Property Set Added'));
        } else {
            $this->flash->failure(t('Unable to Add Property Set'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Insert Property Set - People
     *
     * @access  public
     * @author  aljawaid
     */
    public function insertSetPeople()
    {
        if ($this->contactsItemsModel->insertSetPeople()) {
            $this->flash->success(t('People Property Set Added'));
        } else {
            $this->flash->failure(t('Unable to Add Property Set'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Insert Property Set - Team
     *
     * @access  public
     * @author  aljawaid
     */
    public function insertSetTeam()
    {
        if ($this->contactsItemsModel->insertSetTeam()) {
            $this->flash->success(t('Team Property Set Added'));
        } else {
            $this->flash->failure(t('Unable to Add Property Set'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }
}
