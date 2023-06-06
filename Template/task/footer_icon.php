<?php $contacts = $this->ContactsHelper->getContactsIDs($task['id']); ?>
<?php if (!empty($contacts)): ?>
    <span title="<?= t('Contacts') ?>" class="tooltip" data-href="<?= $this->url->href('ContactsController', 'task_footer', array('task_id' => $task['id'], 'plugin' => 'AddressBook')) ?>">
        <span class="address-book-icon"></span>
    </span>
<?php endif ?>
