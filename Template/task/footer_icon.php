<?php
$contacts = $this->ContactsHelper->getContactsIDs($task['id']);
?>
<?php if (!empty($contacts)): ?>
    <span title="<?= t('Contacts') ?>" class="tooltip" data-href="<?= $this->url->href('ContactsController', 'task_footer', array('plugin' => 'AddressBook', 'task_id' => $task['id'])) ?>">
        <i class="fa fa-phone fa-fw"></i>
    </span>
<?php endif ?>
