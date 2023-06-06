<?php if ($this->user->hasProjectAccess('ProjectViewController', 'show', $project['id'])): ?>
    <li <?= $this->app->checkMenuSelection('ContactsController', 'project', 'AddressBook') ?>>
        <?= $this->url->link(t('Address Book'), 'ContactsController', 'project', array('project_id' => $project['id'], 'plugin' => 'AddressBook')) ?>
    </li>
<?php endif ?>
