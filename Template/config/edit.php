<div class="">
<style type="text/css">
    /* MODAL SIZE */
    #modal-box {
        width: auto !important;
    }

    #modal-content {
        padding: 10px 15px;
    }

    /* MODAL CLOSE BUTTON */
    #modal-close-button {
        transform: scale(1.5);
        display: inline-block;
        position: absolute;
        right: 6px;
        top: 6px;
        background: var(--pp-red-alt-2);
        padding: 3px 3px 5px 6px;
        border-bottom-left-radius: 3px;
        box-shadow: -1px -1px 0px 3px var(--pp-white);
    }

    #modal-close-button i {
        color: var(--pp-white);
        transition: var(--transition-address-book);
    }

    #modal-close-button:hover i {
        color: var(--pp-grey);
        text-shadow: 0 0 1px var(--pp-white);
    }
</style>

    <div class="page-header">
        <h2 class=""><?= t('Edit item') ?></h2>
    </div>
    <form class="popover-form" method="post" action="<?= $this->url->href('ContactsItemsController', 'update', array('item_id' => $item['id'], 'plugin' => 'AddressBook')) ?>" autocomplete="off">

        <?= $this->form->csrf() ?>
        <?= $this->form->hidden('id', $values) ?>
        <?= $this->form->hidden('position', $values) ?>

        <div class="property-wrapper">
            <span class="property-icon"></span>
            <span class="property-fields">
                <?= $this->ContactsHelper->selectItem($values, $errors, array('autofocus', 'placeholder="' . $values['item'] . '"')) ?>
            </span>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-ab-rename"><?= t('Save') ?></button>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </form>
</div>
