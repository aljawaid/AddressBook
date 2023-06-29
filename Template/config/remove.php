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

<div class="delete-property-modal">
    <div class="ab-page-header">
        <h2 class=""><span class="property-icon"></span><?= $title ?></h2>
    </div>
    <div class="confirm">
        <p class="confirm-delete">
            <?= e('Do you really want to remove the %s property from the contact profile?', '<strong>' . $item['item'] . '</strong>') ?>
        </p>
        <p class="alert property-warning">
            <?= t('All properties with matching names to this set will be deleted regardless of whether they contain any data') ?>
        </p>
        <div class="form-actions">
            <?= $this->url->link(t('Delete Property'), 'ContactsItemsController', 'remove', array('item_id' => $item['id'], 'plugin' => 'AddressBook'), true, 'btn btn-ab-delete') ?>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </div>
</div>
