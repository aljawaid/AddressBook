<div class="">
    <div class="page-header">
        <h2 class=""><?= t('Add a new contact') ?></h2>
    </div>
    <form method="post" action="<?= $this->url->href('ContactsController', 'save', array('plugin' => 'AddressBook', 'project_id' => $project_id)) ?>" autocomplete="off">

        <?= $this->form->csrf() ?>
        <?php foreach ($items as $key => $value): ?>
            <?= $this->form->label($value['item'], $value['item']) ?>
            <?= $this->form->text($value['id'] . '_' . $value['item'], $values, $errors, array('maxlength="100"')) ?>
        <?php endforeach ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
        </div>
    </form>
</div>
