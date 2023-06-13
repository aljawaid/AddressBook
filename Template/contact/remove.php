<div class="">
    <div class="page-header">
        <h2 class=""><?= t('Remove Contact') ?></h2>
    </div>
    <div class="confirm">
        <p class="confirm-delete">
            <?= e('Do you really want to remove %s as a contact in the Address Book?', '<strong>' . $contact['value'] . '</strong>') ?>
        </p>

        <div class="form-actions">
            <?= $this->url->link(t('Delete'), 'ContactsController', 'remove', array('project_id' => $project['id'], 'contacts_id' => $contacts_id, 'plugin' => 'AddressBook'), true, 'btn btn-red') ?>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </div>
</div>
