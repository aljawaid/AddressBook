<?php $contacts = $this->ContactsHelper->getContactsIDs($task['id']); ?>

<?php if (!empty($contacts)): ?>
    <!-- Leave title tag empty for js rendering -->
    <span title="" class="footer-icon tooltip" data-href="<?= $this->url->href('ContactsController', 'boardTaskFooter', array('task_id' => $task['id'], 'plugin' => 'AddressBook')) ?>">
        <span class="address-book-icon"></span><?= count($contacts) ?>
    </span>
<?php endif ?>
