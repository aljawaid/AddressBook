<?php

namespace Kanboard\Plugin\AddressBook\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Controller\PageNotFoundException;

/**
 * Contacts
 *
 * @package controller
 * @author  Martin Middeke
 */
class ContactsItemsController extends BaseController
{
    /**
     * Get the current item
     *
     * @access protected
     * @return array
     * @throws PageNotFoundException
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
     * @access public
     */
    public function config()
    {
        $this->response->html($this->helper->layout->config('addressBook:config/index', array(
            'title' => t('Address Book Settings'),
            'items' => $this->contactsItemsModel->getAllItems(),
        )));
    }

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
     * @access public
     */
    public function update()
    {
        $values = $this->request->getValues();

        list($valid, $errors) = $this->contactsValidator->validateItemModification($values);

        if ($valid) {
            if ($this->contactsItemsModel->update($values)) {
                $this->flash->success(t('Item updated successfully.'));
            } else {
                $this->flash->failure(t('Unable to update your item.'));
            }
        }

        return $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')), true);
    }

    /**
     * Move item position
     *
     * @access public
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
     */
    public function confirm()
    {
        $item = $this->contactsItemsModel->getById($this->request->getIntegerParam('item_id'));

        $this->response->html($this->helper->layout->config('addressBook:config/remove', array(
            'item' => $item,
            'title' => t('Remove Item'),
        )));
    }

    /**
     * Remove an item
     *
     * @access public
     */
    public function remove()
    {
        $this->checkCSRFParam();
        $item_id = $this->request->getIntegerParam('item_id');

        //$this->checkPermission($project, $filter);

        if ($this->contactsItemsModel->remove($item_id)) {
            $this->flash->success(t('Item removed successfully.'));
        } else {
            $this->flash->failure(t('Unable to remove this item.'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Save a new item
     *
     * @access public
     */
    public function save()
    {
        $values = $this->request->getValues();

        list($valid, $errors) = $this->contactsValidator->validateItemModification($values);

        if ($valid) {
            if ($this->contactsItemsModel->save($values)) {
                $this->flash->success(t('Item updated successfully.'));
            } else {
                $this->flash->failure(t('Unable to update your item.'));
            }
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Insert Property Set - Personal
     *
     * @access public
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
     * Remove Property Set - Personal
     *
     * @access public
     */
    public function removeSetPersonal()
    {
        if ($this->contactsItemsModel->removeSetPersonal()) {
            $this->flash->success(t('Personal Property Set Removed'));
        } else {
            $this->flash->failure(t('Unable to Remove Property Set'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Insert Property Set - Business
     *
     * @access public
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
     * Remove Property Set - Business
     *
     * @access public
     */
    public function removeSetBusiness()
    {
        if ($this->contactsItemsModel->removeSetBusiness()) {
            $this->flash->success(t('Business Property Set Removed'));
        } else {
            $this->flash->failure(t('Unable to Remove Property Set'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Insert Property Set - Company
     *
     * @access public
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
     * Remove Property Set - Company
     *
     * @access public
     */
    public function removeSetCompany()
    {
        if ($this->contactsItemsModel->removeSetCompany()) {
            $this->flash->success(t('Company Property Set Removed'));
        } else {
            $this->flash->failure(t('Unable to Remove Property Set'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Insert Property Set - People
     *
     * @access public
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
     * Remove Property Set - People
     *
     * @access public
     */
    public function removeSetPeople()
    {
        if ($this->contactsItemsModel->removeSetPeople()) {
            $this->flash->success(t('People Property Set Removed'));
        } else {
            $this->flash->failure(t('Unable to Remove Property Set'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }
}
