<?php

namespace Kanboard\Plugin\AddressBook;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Security\Role;
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
        $this->route->addRoute('/project/:project_id/address-book/assign', 'ContactsController', 'assignToProject', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book/contacts/:contacts_id/unassign/confirm', 'ContactsController', 'confirmRemoveFromProject', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book/contacts/:contacts_id/unassign', 'ContactsController', 'removeFromProject', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book/assignment-help', 'ContactsController', 'assignmentHelp', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book/contacts/:contacts_id/edit', 'ContactsController', 'edit', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book/contacts/:contacts_id/delete', 'ContactsController', 'confirm', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book/contacts/delete/:contacts_id', 'ContactsController', 'remove', 'AddressBook');
        $this->route->addRoute('/project/:project_id/task/:task_id/contacts', 'ContactsController', 'task', 'AddressBook');
        $this->route->addRoute('/project/:project_id/task/:task_id/contacts/:contacts_id/link', 'ContactsController', 'addToTask', 'AddressBook');
        $this->route->addRoute('/project/:project_id/task/:task_id/contacts/:contacts_id/delink', 'ContactsController', 'removeFromTask', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book/contacts/:contacts_id/view', 'ContactsController', 'details', 'AddressBook');
        $this->route->addRoute('/address-book', 'ContactsDirectoryController', 'index', 'AddressBook');
        $this->route->addRoute('/address-book/save', 'ContactsDirectoryController', 'save', 'AddressBook');
        $this->route->addRoute('/address-book/contacts/:contacts_id/view', 'ContactsDirectoryController', 'details', 'AddressBook');
        $this->route->addRoute('/address-book/contacts/:contacts_id/edit', 'ContactsDirectoryController', 'edit', 'AddressBook');
        $this->route->addRoute('/address-book/contacts/:contacts_id/update', 'ContactsDirectoryController', 'update', 'AddressBook');
        $this->route->addRoute('/address-book/contacts/:contacts_id/delete', 'ContactsDirectoryController', 'confirm', 'AddressBook');
        $this->route->addRoute('/address-book/contacts/:contacts_id/remove', 'ContactsDirectoryController', 'remove', 'AddressBook');

        // Global contacts are administered centrally; project managers control project and task assignments.
        // Access rules are covered by tests/Integration/GlobalDirectoryTest.php.
        $this->applicationAccessMap->add('ContactsDirectoryController', '*', Role::APP_ADMIN);
        $this->applicationAccessMap->add('ContactsItemsController', '*', Role::APP_ADMIN);
        $this->applicationAccessMap->add('ContactsController', array('edit', 'update', 'confirm', 'remove'), Role::APP_ADMIN);
        $this->projectAccessMap->add('ContactsController', array('save', 'assignToProject', 'confirmRemoveFromProject', 'removeFromProject'), Role::PROJECT_MANAGER);
        $this->projectAccessMap->add('ContactsController', array('addToTask', 'removeFromTask'), Role::PROJECT_MEMBER);

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
                'ContactsItemsModel', 'ContactsTaskModel', 'ContactsModel', 'ContactsProjectModel',
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
        return t('Use the dedicated Address Book to create and manage contacts or organisations in a global directory. Assign contacts to individual projects before linking them to project tasks. Add custom properties to standardise a deeper relationship between tasks and people or places.');
    }

    public function getPluginAuthor()
    {
        return 'aljawaid';
    }

    public function getPluginVersion()
    {
        return '1.4.0';
    }

    public function getCompatibleVersion()
    {
        // Examples:
        // >=1.0.37
        // <1.0.37
        // <=1.0.37
        return '>=1.2.54';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/aljawaid/AddressBook';
    }
}
