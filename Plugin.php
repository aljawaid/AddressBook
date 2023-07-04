<?php

namespace Kanboard\Plugin\AddressBook;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;
use Kanboard\Plugin\AddressBook\Helper\ContactsHelper;
use Kanboard\Helper;

class Plugin extends Base
{
    public function initialize()
    {
        // CSS - Asset Hook
        //  - Keep filename lowercase
        $this->hook->on('template:layout:css', array('template' => 'plugins/AddressBook/Assets/css/address-book.css'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/AddressBook/Assets/css/address-book-icons.css'));

        // Views - Template Hook
        //  - Override name should start lowercase e.g. pluginNameExampleCamelCase
        $this->template->hook->attach('template:config:sidebar', 'addressBook:config/sidebar');
        $this->template->hook->attach('template:project:sidebar', 'addressBook:project/sidebar');
        $this->template->hook->attach('template:task:sidebar:information', 'addressBook:task/sidebar');
        $this->template->hook->attach('template:board:task:icons', 'addressBook:task/footer-icon');
        $this->template->hook->attach('template:task:show:before-description', 'addressBook:task/description');

        // Extra Page - Routes
        //  - Example: $this->route->addRoute('/my/custom/route', 'MyController', 'show', 'PluginNameExampleStudlyCaps');
        $this->route->addRoute('/settings/address-book', 'ContactsItemsController', 'config', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property/:item_id/move/:direction', 'ContactsItemsController', 'movePosition', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property/:item_id/edit', 'ContactsItemsController', 'edit', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property/:item_id/delete', 'ContactsItemsController', 'confirm', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property/delete/:item_id', 'ContactsItemsController', 'remove', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property-set/add/personal', 'ContactsItemsController', 'insertSetPersonal', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property-set/add/business', 'ContactsItemsController', 'insertSetBusiness', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property-set/add/company', 'ContactsItemsController', 'insertSetCompany', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property-set/add/people', 'ContactsItemsController', 'insertSetPeople', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property-set/add/team', 'ContactsItemsController', 'insertSetTeam', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property-set/:set/delete/', 'ContactsItemsController', 'confirmRemoveSet', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property-set/delete/:set', 'ContactsItemsController', 'removeSet', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book', 'ContactsController', 'project', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book/contacts/:contacts_id/edit', 'ContactsController', 'edit', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book/contacts/:contacts_id/delete', 'ContactsController', 'confirm', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book/contacts/delete/:contacts_id', 'ContactsController', 'remove', 'AddressBook');
        $this->route->addRoute('/project/:project_id/task/:task_id/contacts', 'ContactsController', 'task', 'AddressBook');
        $this->route->addRoute('/project/:project_id/task/:task_id/contacts/:contacts_id/link', 'ContactsController', 'addToTask', 'AddressBook');
        $this->route->addRoute('/project/:project_id/task/:task_id/contacts/:contacts_id/delink', 'ContactsController', 'removeFromTask', 'AddressBook');
        $this->route->addRoute('/project/address-book/contacts/:contacts_id/view', 'ContactsController', 'details', 'AddressBook');

        // Helper
        //  - Example: $this->helper->register('helperClassNameCamelCase', '\Kanboard\Plugin\PluginNameExampleStudlyCaps\Helper\HelperNameExampleStudlyCaps');
        //  - Add each Helper in the 'use' section at the top of this file
        $this->helper->register('ContactsHelper', '\Kanboard\Plugin\AddressBook\Helper\ContactsHelper');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__ . '/Locale');
    }

    public function getClasses()
    {
        return array(
            'Plugin\AddressBook\Model' => array(
                'ContactsItemsModel', 'ContactsTaskModel', 'ContactsModel',
            ),
            'Plugin\AddressBook\Validator' => array('ContactsValidator')
        );
    }

    public function getPluginName()
    {
        // Plugin Name MUST be identical to namespace for Plugin Directory to detect updated versions
        // Do not translate the plugin name here
        return 'AddressBook';
    }

    public function getPluginDescription()
    {
        return t('Use the dedicated Address Book to create and manage contacts or organisations in projects and tasks. Add custom properties to standardise a deeper relationship between tasks and people or places. Contacts can be linked exclusively to tasks in a project. Users can sort their contact properties to show the first 3 properties (e.g. name, number and email) for quick reference from the task summary and the project board view.');
    }

    public function getPluginAuthor()
    {
        return 'aljawaid';
    }

    public function getPluginVersion()
    {
        return '1.3.0';
    }

    public function getCompatibleVersion()
    {
        // Examples:
        // >=1.0.37
        // <1.0.37
        // <=1.0.37
        return '>=1.2.20';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/aljawaid/AddressBook';
    }
}
