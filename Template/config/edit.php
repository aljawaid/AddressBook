<div class="">
    <div class="page-header">
        <h2 class=""><?= t('Edit item') ?></h2>
    </div>
    <form class="popover-form" method="post" action="<?= $this->url->href('ContactsItemsController', 'update', array('item_id' => $item['id'], 'plugin' => 'AddressBook')) ?>" autocomplete="off">

        <?= $this->form->csrf() ?>
        <?= $this->form->hidden('id', $values) ?>
        <?= $this->form->hidden('position', $values) ?>
        <?= $this->ContactsHelper->selectItem($values, $errors, array('autofocus')) ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-ab-rename"><?= t('Save') ?></button>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </form>
</div>
