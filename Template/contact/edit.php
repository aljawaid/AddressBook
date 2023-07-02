<?php $fields = count($headings) ?>

<?php if ($fields < 3): ?>
    <style type="text/css">
        /* MODAL SIZE */
        #modal-box {
            width: auto !important;
        }
    </style>
<?php endif ?>

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

<div class="edit-contact-modal">
    <div class="ab-page-header">
        <h2 class=""><span class="contact-settings-icon"></span><?= $title ?></h2>
    </div>
    <form class="modal-form" method="post" action="<?= $this->url->href('ContactsController', 'update', array('project_id' => $project['id'], 'contacts_id' => $contacts_id, 'plugin' => 'AddressBook')) ?>" autocomplete="on">

        <?= $this->form->csrf() ?>

        <div class="form-group contact-id">
            <?= $this->form->label(t('Contact ID'), 'ContactID') ?>
            <!-- Manually build input for Contact ID - exclude `name` attribute to be excluded from form submission -->
            <input id="form-ContactID" type="text" class="property-input property-input-disabled" value="<?= $contacts_id ?>" placeholder="" readonly="readonly">
        </div>

        <?php foreach ($headings as $key => $value): ?>
            <?php
            $trimmedItemName = ucwords(strtolower($value));
            $trimmedItem = str_replace(array(' ', '|', '(', ')', '[', ']', '#', '°'), '', $trimmedItemName);
            $item_type = $this->ContactsHelper->getItemType($key);
            $existing_value = $key . '__' . $trimmedItem;
            $show_existing_value = $this->helper->text->e($values[$existing_value]);
            $number_value_empty_use_title_tag = ($show_existing_value == false) ? '12345' : $this->helper->text->e($values[$existing_value]);
            $decimal2_value_empty_use_title_tag = ($show_existing_value == false) ? '0.01' : $this->helper->text->e($values[$existing_value]);
            $decimal4_value_empty_use_title_tag = ($show_existing_value == false) ? '0.0001' : $this->helper->text->e($values[$existing_value]);
            $telephone_value_empty_use_title_tag = ($show_existing_value == false) ? '+44 (0)1234 567890' : $this->helper->text->e($values[$existing_value]);
            $email_value_empty_use_title_tag = ($show_existing_value == false) ? t('someone@somewhere.com') : $this->helper->text->e($values[$existing_value]);
            $url_value_empty_use_title_tag = ($show_existing_value == false) ? 'https://' : $this->helper->text->e($values[$existing_value]);
            $textarea_value_empty_use_title_tag = ($show_existing_value == false) ? t('Save notes for this contact') : $this->helper->text->e($values[$existing_value]);
            $address_value_empty_use_title_tag = ($show_existing_value == false) ? t('Enter address details for this contact') : $this->helper->text->e($values[$existing_value]);
            $item_help = $this->ContactsHelper->getItemHelp($key);
            ?>

            <div class="form-group form-group-edit">
                <?= $this->form->label($value, $key . '__' . $trimmedItem) ?>
                <?php if ($item_type == 'number'): ?>
                    <?= $this->form->number($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $number_value_empty_use_title_tag . '"', 'title="' . t('Format: 12345') . '"', 'step="1"'), 'property-input property-input-number') ?>
                <?php elseif ($item_type == 'decimal2'): ?>
                        <?= $this->form->input('number', $key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $decimal2_value_empty_use_title_tag . '"', 'title="' . t('Format: 0.01') . '"', 'step="0.01"'), 'property-input property-input-decimal') ?>
                <?php elseif ($item_type == 'decimal4'): ?>
                        <?= $this->form->input('number', $key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $decimal4_value_empty_use_title_tag . '"', 'title="' . t('Format: 0.0001') . '"', 'step="0.0001"'), 'property-input property-input-decimal') ?>
                <?php elseif ($item_type == 'telephone'): ?>
                    <?= $this->form->input('tel', $key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $telephone_value_empty_use_title_tag . '"', 'title="' . t('Format: +44 (0)1234 567890') . '"', 'pattern="^[0-9-+\s()]*$"'), 'property-input property-input-telephone') ?>
                <?php elseif ($item_type == 'email'): ?>
                    <?= $this->form->email($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $email_value_empty_use_title_tag . '"', 'title="' . t('Format: someone@somewhere.com') . '"'), 'property-input') ?>
                <?php elseif ($item_type == 'url'): ?>
                    <?= $this->form->input('url', $key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $url_value_empty_use_title_tag . '"', 'title="' . t('Format: https://') . '"'), 'property-input') ?>
                <?php elseif ($item_type == 'textarea'): ?>
                    <?= $this->form->textarea($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $textarea_value_empty_use_title_tag . '"', 'title="' . t('Save notes for this contact') . '"', 'rows="3"', 'cols="37"', 'wrap="hard"'), 'property-input-note') ?>
                <?php elseif ($item_type == 'address'): ?>
                    <?= $this->form->textarea($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $address_value_empty_use_title_tag . '"', 'title="' . t('Enter address details for this contact') . '"', 'rows="3"', 'cols="37"', 'wrap="hard"'), 'property-input-address') ?>
                <?php else: ?>
                    <?php if ($key == 1): ?>
                        <?= $this->form->text($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $show_existing_value . '"', 'maxlength="50"', 'autofocus', 'required'), 'property-input') ?>
                    <?php else: ?>
                            <?= $this->form->text($key . '__' . $trimmedItem, $values, $errors, array('placeholder="' . $show_existing_value . '"', 'maxlength="50"'), 'property-input') ?>
                    <?php endif ?>
                <?php endif ?>

                <?php if ($item_type == 'telephone'): ?>
                    <p class="form-help">
                        <?= t('All numbers and symbols shown are allowed') ?>
                        <?php if (!empty($item_help)): ?>
                            <?= '- ' . $item_help ?>
                        <?php endif ?>
                    </p>
                <?php elseif ($item_type == 'number'): ?>
                    <p class="form-help">
                        <?= t('Only whole numbers are allowed') ?>
                        <?php if (!empty($item_help)): ?>
                            <?= '- ' . $item_help ?>
                        <?php endif ?>
                    </p>
                <?php elseif ($item_type == 'decimal2'): ?>
                    <p class="form-help">
                        <?= t('Numbers with 2 decimals are allowed') ?>
                        <?php if (!empty($item_help)): ?>
                            <?= '- ' . $item_help ?>
                        <?php endif ?>
                    </p>
                <?php elseif ($item_type == 'decimal4'): ?>
                    <p class="form-help">
                        <?= t('Numbers with 4 decimals are allowed') ?>
                        <?php if (!empty($item_help)): ?>
                            <?= '- ' . $item_help ?>
                        <?php endif ?>
                    </p>
                <?php elseif (!empty($item_help)): ?>
                    <p class="form-help">
                        <?= $item_help ?>
                    </p>
                <?php endif ?>
            </div>
        <?php endforeach ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-ab-rename"><?= t('Save Edits') ?></button>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </form>
</div>
