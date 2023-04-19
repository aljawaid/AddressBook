<?php if ($this->user->hasProjectAccess('contacts', 'index', $task['project_id'])): ?>
    <li>
        <i class="fa fa-phone fa-fw"></i>
        <?= $this->url->link(t('Contacts'), 'ContactsController', 'task', array('plugin' => 'AddressBook', 'project_id' => $task['project_id'], 'task_id' => $task['id'])) ?>
    </li>
<?php endif ?>
