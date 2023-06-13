<div class="add-contact-wrapper">
    <fieldset class="add-contact-profile relative">
        <legend class=""><span class="add-contact-icon"></span><?= t('Add New Contact') ?></legend>
        <span class="form-help"><?= t('All fields are optional') ?></span>
        <form method="post" action="<?= $this->url->href('ContactsController', 'save', array('project_id' => $project_id, 'plugin' => 'AddressBook')) ?>" class="add-contact-form" autocomplete="on">
            <?= $this->form->csrf() ?>

            <?php foreach ($items as $key => $value): ?>
                <?php if (isset($value['item_help'])): ?>
                    <p class="form-help">
                        <?= $value['item_help'] ?>
                    </p>
                <?php endif ?>
                <?php
                $trimmedItemName = ucwords(strtolower($value['item']));
                $trimmedItem = str_replace(array(' ', '|', '(', ')', '[', ']'), '', $trimmedItemName);
                ?>

                <?= $this->form->label($value['item'], $value['id'] . '-' . $trimmedItem, array('class="profile-property-label"')) ?>

                <div class="input-wrapper">
                    <?php if ($value['item_type'] == 'number'): ?>
                        <?= $this->form->number($value['id'] . '-' . $trimmedItem, $values, $errors, array('placeholder="12345"', 'step="1"'), 'property-input property-input-number') ?>
                    <?php elseif ($value['item_type'] == 'decimal2'): ?>
                        <?= $this->form->input('number', $value['id'] . '-' . $trimmedItem, $values, $errors, array('placeholder="0.01"', 'step="0.01"'), 'property-input property-input-decimal') ?>
                    <?php elseif ($value['item_type'] == 'decimal4'): ?>
                        <?= $this->form->input('number', $value['id'] . '-' . $trimmedItem, $values, $errors, array('placeholder="0.0001"', 'step="0.0001"'), 'property-input property-input-decimal') ?>
                    <?php elseif ($value['item_type'] == 'telephone'): ?>
                        <?= $this->form->input('tel', $value['id'] . '-' . $trimmedItem, $values, $errors, array('placeholder="+44 (0)1234 567890"', 'pattern="^[0-9-+\s()]*$"'), 'property-input property-input-telephone') ?>
                    <?php elseif ($value['item_type'] == 'email'): ?>
                        <?= $this->form->email($value['id'] . '-' . $trimmedItem, $values, $errors, array('placeholder="someone@somewhere.com"'), 'property-input') ?>
                    <?php elseif ($value['item_type'] == 'url'): ?>
                        <?= $this->form->input('url', $value['id'] . '-' . $trimmedItem, $values, $errors, array('placeholder="https://"'), 'property-input') ?>
                    <?php elseif ($value['item_type'] == 'textarea'): ?>
                        <?= $this->form->textarea($value['id'] . '-' . $trimmedItem, $values, $errors, array('placeholder="' . t('Save notes for this contact') . '"', 'rows="3"', 'cols="37"'), 'property-input-note') ?>
                    <?php elseif ($value['item_type'] == 'address'): ?>
                        <?= $this->form->textarea($value['id'] . '-' . $trimmedItem, $values, $errors, array('placeholder="' . t('Enter address details for this contact') . '"', 'rows="3"', 'cols="37"'), 'property-input-address') ?>
                    <?php else: ?>
                        <?= $this->form->text($value['id'] . '-' . $trimmedItem, $values, $errors, array('maxlength="30"'), 'property-input') ?>
                    <?php endif ?>

                </div>
            <?php endforeach ?>

            <div class="form-actions">
                <button type="submit" class="btn btn-add-contact">
                    <span class="add-contact-icon"></span><?= t('Add Contact') ?>
                </button>
            </div>
        </form>
    </fieldset>
</div>
