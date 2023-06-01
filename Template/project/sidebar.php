<?php if ($this->user->hasProjectAccess('contacts', 'index', $project['id'])): ?>
    <li <?= $this->app->checkMenuSelection('ContactsController', 'project') ?>>
        <?= $this->url->link(t('Address Book'), 'ContactsController', 'project', array('plugin' => 'AddressBook', 'project_id' => $project['id'])) ?>
    </li>
<?php endif ?>
