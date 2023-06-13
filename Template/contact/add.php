<div class="add-contact-wrapper">
    <fieldset class="add-contact-profile relative">
        <legend class=""><span class="add-contact-icon"></span><?= t('Add New Contact') ?></legend>
        <span class="form-help"><?= t('All fields are optional') ?></span>
        <form method="post" action="<?= $this->url->href('ContactsController', 'save', array('project_id' => $project_id, 'plugin' => 'AddressBook')) ?>" class="add-contact-form" autocomplete="on">
            <?= $this->form->csrf() ?>

            <?php foreach ($items as $key => $value): ?>
                <?= $this->form->label($value['item'], $value['id'] . '_' . strtolower($value['item']), array('class="profile-property-label"')) ?>
                <?= $this->form->text($value['id'] . '_' . strtolower($value['item']), $values, $errors, array('maxlength="100"', 'placeholder="' . $value['item_type'] . '"'), 'property-input') ?>
                <?php if (isset($value['item_help'])): ?>
                    <p class="form-help">
                        <?= $value['item_help'] ?>
                    </p>
                <?php endif ?>
            <?php endforeach ?>

            <div class="form-actions">
                <button type="submit" class="btn btn-add-contact">
                    <span class="add-contact-icon"></span><?= t('Add Contact') ?>
                </button>
            </div>
        </form>
    </fieldset>
</div>
