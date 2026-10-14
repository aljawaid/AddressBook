<div class="confirm">
    <h2><?= t('Remove Contact from Project') ?></h2>
    <p><?= e('Remove %s from the %s project?', '<strong>' . $contact_name . '</strong>', '<strong>' . $project['name'] . '</strong>') ?></p>
    <p class="alert alert-info"><?= t('This also removes the contact from tasks in this project. The global contact and assignments to other projects are not deleted.') ?></p>
    <div class="form-actions">
        <?= $this->url->link(t('Remove from project'), 'ContactsController', 'removeFromProject', array('project_id' => $project['id'], 'contacts_id' => $contacts_id, 'plugin' => 'AddressBook'), true, 'btn btn-red') ?>
        <button class="btn js-modal-close"><?= t('Cancel') ?></button>
    </div>
</div>
