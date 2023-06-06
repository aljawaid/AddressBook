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

<div class="delete-property-modal">
    <div class="page-header">
        <h2 class=""><span class="property-icon"></span><?= t('Delete Property') ?></h2>
    </div>
    <div class="confirm">
        <p class="confirm-delete">
            <?= t('Do you really want to remove the "%s" property from the contact profile?', $item['item']) ?>
        </p>
        <div class="form-actions">

            <?= $this->url->link(t('Delete'), 'ContactsItemsController', 'remove', array('plugin' => 'AddressBook', 'item_id' => $item['id']), true, 'btn btn-red') ?>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </div>
</div>
