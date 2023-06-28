<?php $linkedContacts = $this->model->contactsTaskModel->getLinked($task['id']); ?>

<style type="text/css">
    li {
        position: relative;
    }
</style>

<?php if ($this->user->hasProjectAccess('contacts', 'index', $task['project_id'])): ?>
    <li <?= $this->app->checkMenuSelection('ContactsController', 'task') ?>>
        <span class="address-book-icon"></span>
        <?= $this->url->link(t('Contacts'), 'ContactsController', 'task', array('project_id' => $task['project_id'], 'task_id' => $task['id'], 'plugin' => 'AddressBook')) ?>
        <span class="ab-count-badge-sidebar linked-badge"><?= count($linkedContacts) ?></span>
    </li>
<?php endif ?>
