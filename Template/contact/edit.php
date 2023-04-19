<div class="page-header">
    <h2><?= t('Edit Contact') ?></h2>
</div>
<form method="post" action="<?= $this->url->href('ContactsController', 'update', array('plugin' => 'AddressBook', 'project_id' => $project['id'], 'contacts_id' => $contacts_id)) ?>" autocomplete="off">

    <?= $this->form->csrf() ?>
    <?php foreach ($headings as $key => $value): ?>

    <?= $this->form->label($value, $value) ?>
    <?= $this->form->text($key . '_' . $value, $values, $errors, array('maxlength="100"')) ?>

    <?php endforeach ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
        <?= t('or') ?>
        <?= $this->url->link(t('cancel'), 'ContactsController', 'project', array('plugin' => 'AddressBook', 'project_id' => $project['id']), false, 'close-popover') ?>
    </div>
</form>
