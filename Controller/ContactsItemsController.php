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
            'title' => t('Settings') . ' &gt; ' . t('Contacts'),
            'items' => $this->contactsItemsModel->getAllItems()
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
        $this->response->html($this->helper->layout->project('addressBook:config/remove', array(
            'item' => $item,
            'title' => t('Remove Item')
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

#        $this->checkPermission($project, $filter);

        if ($this->contactsItemsModel->remove($item_id)) {
            $this->flash->success(t('Item removed successfully.'));
        } else {
            $this->flash->failure(t('Unable to remove this item.'));
        }

        $this->response->redirect($this->helper->url->to('ContactsItemsController', 'config', array('plugin' => 'AddressBook')));
    }

    /**
     * Remove a new item
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
}
