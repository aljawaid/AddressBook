<style type="text/css">
    /* MODAL SIZE */
    /* #modal-box {
        width: auto !important;
    }*/

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
        <h2 class=""><span class="contact-settings-icon"></span><?= t('Edit Contact') ?></h2>
    </div>
    <form class="modal-form" method="post" action="<?= $this->url->href('ContactsController', 'update', array('project_id' => $project['id'], 'contacts_id' => $contacts_id, 'plugin' => 'AddressBook')) ?>" autocomplete="on">

        <?= $this->form->csrf() ?>

        <div class="form-group">
            <?= $this->form->label(t('Contact ID'), $contacts_id . '__' . 'ContactID') ?>
            <?= $this->form->text($contacts_id . '__' . 'ContactID', array(), array(), array('value="' . $contacts_id . '"', 'readonly'), 'property-input property-input-disabled') ?>
        </div>
        <?php foreach ($headings as $key => $value): ?>

            <?php
            $trimmedItemName = ucwords(strtolower($value));
            $trimmedItem = str_replace(array(' ', '|', '(', ')', '[', ']'), '', $trimmedItemName);
            $item_type = $this->ContactsHelper->getItemType($key);
            ?>

            <div class="form-group">
                <?= $this->form->label($value, $key . '__' . $trimmedItem) ?>
                <?php if ($item_type == 'number'): ?>
                    <?= $this->form->number($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $value . '"', 'title="' . t('Format: 12345') . '"', 'step="1"'), 'property-input property-input-number') ?>
                <?php elseif ($item_type == 'decimal2'): ?>
                        <?= $this->form->input('number', $key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $value . '"', 'title="' . t('Format: 0.01') . '"', 'step="0.01"'), 'property-input property-input-decimal') ?>
                <?php elseif ($item_type == 'decimal4'): ?>
                        <?= $this->form->input('number', $key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $value . '"', 'title="' . t('Format: 0.0001') . '"', 'step="0.0001"'), 'property-input property-input-decimal') ?>
                <?php elseif ($item_type == 'telephone'): ?>
                    <?= $this->form->input('tel', $key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $value . '"', 'title="' . t('Format: +44 (0)1234 567890') .'"', 'pattern="^[0-9-+\s()]*$"'), 'property-input property-input-telephone') ?>
                <?php elseif ($item_type == 'email'): ?>
                    <?= $this->form->email($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $value . '"', 'title="' . t('Format: someone@somewhere.com') . '"'), 'property-input') ?>
                <?php elseif ($item_type == 'url'): ?>
                    <?= $this->form->input('url', $key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $value . '"', 'title="' . t('Format: https://') . '"'), 'property-input') ?>
                <?php elseif ($item_type == 'textarea'): ?>
                    <?= $this->form->textarea($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $value . '"', 'title="' . t('Save notes for this contact') . '"', 'rows="3"', 'cols="37"', 'wrap="hard"'), 'property-input-note') ?>
                <?php elseif ($item_type == 'address'): ?>
                    <?= $this->form->textarea($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $value . '"', 'title="' . t('Enter address details for this contact') . '"', 'rows="3"', 'cols="37"', 'wrap="hard"'), 'property-input-address') ?>
                <?php else: ?>
                    <?php if ($key == 1): ?>
                        <?= $this->form->text($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $value . '"', 'maxlength="50"', 'autofocus', 'required'), 'property-input') ?>
                    <?php else: ?>
                            <?= $this->form->text($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $value . '"', 'maxlength="50"'), 'property-input') ?>
                    <?php endif ?>
                <?php endif ?>
            </div>
        <?php endforeach ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-blue"><?= t('Save Edits') ?></button>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </form>
</div>
