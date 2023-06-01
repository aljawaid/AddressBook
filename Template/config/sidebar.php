<li <?= $this->app->checkMenuSelection('ContactsItemsController', 'config') ?>>
    <?= $this->url->link(t('Address Book'), 'ContactsItemsController', 'config', array('plugin' => 'AddressBook')) ?>
</li>
