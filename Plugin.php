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

        // JS - Asset Hook
        //  - Keep filename lowercase
        $this->hook->on('template:layout:js', array('template' => 'plugins/AddressBook/Assets/js/address-book.js'));

        // Views - Template Hook
        //  - Override name should start lowercase e.g. pluginNameExampleCamelCase
        $this->template->hook->attach('template:config:sidebar', 'addressBook:config/sidebar');
        $this->template->hook->attach('template:project:sidebar', 'addressBook:project/sidebar');
        $this->template->hook->attach('template:task:sidebar:information', 'addressBook:task/sidebar');
        $this->template->hook->attach('template:board:task:footer', 'addressBook:task/footer_icon');
        $this->template->hook->attach('template:task:show:before-description', 'addressBook:task/description');
        //$this->template->hook->attach('template:user:sidebar:information', 'metadata:user/sidebar'); doesnt exist

        // Extra Page - Routes
        //  - Example: $this->route->addRoute('/my/custom/route', 'MyController', 'show', 'PluginNameExampleStudlyCaps');
        $this->route->addRoute('/settings/address-book', 'ContactsItemsController', 'config', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property/:item_id/move/:direction', 'ContactsItemsController', 'movePosition', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property/:item_id/rename', 'ContactsItemsController', 'edit', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property/:item_id/delete', 'ContactsItemsController', 'confirm', 'AddressBook');
        $this->route->addRoute('/settings/address-book/property/delete/:item_id', 'ContactsItemsController', 'remove', 'AddressBook');
        $this->route->addRoute('/project/:project_id/address-book', 'ContactsController', 'project', 'AddressBook');
        $this->route->addRoute('/project/:project_id/task/:task_id/contacts', 'ContactsController', 'task', 'AddressBook');

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
        return t('Use the dedicated Address Book to create and manage contacts associating them with projects and tasks. Add custom properties per contact to log a relationship between tasks and people or organisations. Each task can have contacts assigned through a list exclusive to the project. Users can sort their contact properties to show the first 3 properties (e.g. name, number and email) so they can easily have a quick reference to contact information from the task summary.');
    }

    public function getPluginAuthor()
    {
        return 'aljawaid';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
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
