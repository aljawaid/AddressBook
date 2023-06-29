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
        box-shadow: -1px -1px 0 3px var(--pp-white);
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

<div class="rename-property-modal">
    <div class="ab-page-header">
        <h2 class="">
            <span class="rename-icon"></span><?= t('Edit Property') ?>
        </h2>
    </div>
    <form class="modal-form" method="post" action="<?= $this->url->href('ContactsItemsController', 'update', array('item_id' => $item['id'], 'plugin' => 'AddressBook')) ?>" autocomplete="on">

        <?= $this->form->csrf() ?>
        <?= $this->form->hidden('id', $values) ?>
        <?= $this->form->hidden('position', $values) ?>

        <div class="property-wrapper">
            <span class="property-fields">
                <?= $this->ContactsHelper->selectItem($values, $errors, array('autofocus', 'placeholder="' . $values['item'] . '"')) ?>
            </span>
            <div class="form-group">
                <?= $this->form->label(t('Property Set'), 'property_set') ?>
                <?= $this->form->text('property_set', array(), array(), array('value="' . $values['property_set'] . '"', 'readonly'), 'property-input property-input-disabled') ?>
                <?php if ($values['property_set'] !== 'custom'): ?>
                    <p class="form-help"><?= e('The property set will change to %s', '<i>Custom</i>') ?></p>
                <?php endif ?>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-ab-rename"><?= t('Save Edits') ?></button>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </form>
</div>
