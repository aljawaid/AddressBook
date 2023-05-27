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
            <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
            <?= t('or') ?>
            <?= $this->url->link(t('cancel'), 'ContactsItemsController', 'config', array('plugin' => 'AddressBook'), false, 'close-popover') ?>
        </div>
    </form>
</div>
