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

<div class="edit-contact-modal">
    <div class="ab-page-header">
        <h2 class=""><span class="rename-icon"></span><?= t('Edit Contact') ?></h2>
    </div>
    <form method="post" action="<?= $this->url->href('ContactsController', 'update', array('plugin' => 'AddressBook', 'project_id' => $project['id'], 'contacts_id' => $contacts_id)) ?>" autocomplete="off">

        <?= $this->form->csrf() ?>
        <?php foreach ($headings as $key => $value): ?>
            <?= $this->form->label($value, $value) ?>
            <?= $this->form->text($key . '_' . $value, $values, $errors, array('maxlength="100"')) ?>
        <?php endforeach ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </form>
</div>
