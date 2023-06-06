<?php if ($this->user->hasProjectAccess('contacts', 'index', $task['project_id'])): ?>
    <li class="">
        <span class="address-book-icon"></span>
        <?= $this->url->link(t('Contacts'), 'ContactsController', 'task', array('project_id' => $task['project_id'], 'task_id' => $task['id'], 'plugin' => 'AddressBook')) ?>
    </li>
<?php endif ?>
