<?php $contacts = $this->ContactsHelper->getContactsIDs($task['id']); ?>

<?php if (!empty($contacts)): ?>
    <div title="<?= t('Contacts') ?>" class="tooltip" data-href="<?= $this->url->href('ContactsController', 'boardTaskFooter', array('task_id' => $task['id'], 'plugin' => 'AddressBook')) ?>">
        <span class="address-book-icon"></span><?= count($contacts) ?>
    </div>
<?php endif ?>
