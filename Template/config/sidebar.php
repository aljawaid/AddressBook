<li <?= $this->app->checkMenuSelection('ContactsDirectoryController', 'index') ?>>
    <?= $this->url->link(t('Global Address Book'), 'ContactsDirectoryController', 'index', array('plugin' => 'AddressBook')) ?>
</li>
<li <?= $this->app->checkMenuSelection('ContactsItemsController', 'config') ?>>
    <?= $this->url->link(t('Contact Properties'), 'ContactsItemsController', 'config', array('plugin' => 'AddressBook')) ?>
</li>
