<?php $projectContacts = $this->model->contactsModel->getAll(); ?>

<style type="text/css">
    li {
        position: relative;
    }
</style>

<?php if ($this->user->hasProjectAccess('ProjectViewController', 'show', $project['id'])): ?>
    <li <?= $this->app->checkMenuSelection('ContactsController', 'project', 'AddressBook') ?>>
        <?= $this->url->link(t('Address Book'), 'ContactsController', 'project', array('project_id' => $project['id'], 'plugin' => 'AddressBook')) ?>
        <span class="ab-count-badge-sidebar"><?= count($projectContacts) ?></span>
    </li>
<?php endif ?>
