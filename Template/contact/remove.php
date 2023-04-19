<section id="main">
    <div class="page-header">
        <h2><?= t('Remove Contact') ?></h2>
    </div>

    <div class="confirm">
        <p class="alert alert-info">
            <?= t('Do you really want to remove this contact: "%s"?', $contact['value']) ?>
        </p>

        <div class="form-actions">
            <?= $this->url->link(t('Yes'), 'ContactsController', 'remove', array('plugin' => 'AddressBook', 'project_id' => $project['id'], 'contacts_id' => $contacts_id), true, 'btn btn-red') ?>
            <?= t('or') ?>
            <?= $this->url->link(t('cancel'), 'ContactsController', 'project', array('plugin' => 'AddressBook', 'project_id' => $project['id']), false, 'close-popover') ?>
        </div>
    </div>
</section>
