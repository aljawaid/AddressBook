<?php if ($this->user->hasProjectAccess('contacts', 'index', $task['project_id'])): ?>
    <li class="">
        <i class="fa fa-phone fa-fw"></i>
        <?= $this->url->link(t('Contacts'), 'ContactsController', 'task', array('project_id' => $task['project_id'], 'task_id' => $task['id'], 'plugin' => 'AddressBook')) ?>
    </li>
<?php endif ?>
