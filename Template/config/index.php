<div id="ABConfigPage" class="ab-config-page">
    <div class="ab-page-header">
        <h2 class="">
            <span class="address-book-icon"></span> <?= t('Contact Settings') ?>
        </h2>
    </div>
    <form method="post" action="<?= $this->url->href('ContactsItemsController', 'save', array('plugin' => 'AddressBook')) ?>" autocomplete="on" class="add-property-form">
        <?= $this->form->csrf() ?>
        <fieldset class="ab-new-item">
            <legend class=""><span class="property-icon"></span> <?= t('Add New Property') ?></legend>
            <p class="new-item-intro">
                <?= t('Each contact is associated with a contact profile. A standard contact profile consists of many properties. Add custom properties to adjust the standard contact profile according to your requirements.') ?>
            </p>

            <div class="input-section">
                <?= $this->form->label(t('Property Name'), 'item', array('class="property-label"')) ?>
                <?= $this->form->text('item', $values, array(), array('autofocus', 'required', 'placeholder="' . t('Department') . '"'), 'property-input') ?>
                <p class="form-help"><?= t('Add properties individually') ?></p>
            </div>
            <div class="input-section">
                <?= $this->form->label(t('Property Type'), 'item_type', array('class="property-label"')) ?>
                <?= $this->form->text('item_type', $values, array(), array('required', 'placeholder="' . t('text') . '"'), 'property-input') ?>
                <p class="form-help" title="<?= t('Allowed Types') ?>">
                    <code><?= t('text') ?></code><code><?= t('number') ?></code><code><?= t('address') ?></code><code><?= t('telephone') ?></code><code><?= t('email') ?></code><code><?= t('website') ?></code>
                </p>
            </div>
            <div class="input-section">
                <?= $this->form->label(t('Property Note'), 'item_help', array('class="property-label"')) ?>
                <?= $this->form->text('item_help', $values, array(), array('placeholder="' . t('Specifiy Department Name') . '"'), 'property-input') ?>
                <p class="form-help"><?= t('Add a short descriptive note for users who create contacts') ?></p>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-ab-property"><span class="property-icon"></span> <?= t('Add Property') ?></button>
            </div>
        </fieldset>
    </form>
    <?php if (!empty($items)): ?>
        <fieldset class="ab-contact-profile">
            <legend><span class="contact-profile-icon"></span> <?= t('Contact Profile') ?></legend>
            <p class="contact-profile-intro">
                <?= t('There are currently %s properties which together form a standard contact profile.', count($items)) ?>
            </p>
            <table id="ContactProfileTable" class="contact-profile-table">
                <thead>
                    <tr class="">
                        <th class="column-25"><span class="property-icon"></span> <?= t('Contact Property') ?></th>
                        <th class="column-25"><?= t('Property Note') ?></th>
                        <th class="column-8 text-center"><?= t('Property Type') ?></th>
                        <th class="column-18"><?= t('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $end = end($items) ?>
                    <?php foreach ($items as $item): ?>
                        <tr class="">
                            <td class=""><?= $item['item'] ?></td>
                            <td class="form-help"><?= $item['item_help'] ?></td>
                            <td class="text-center"><?= $item['item_type'] ?></td>
                            <td class="">
                                <?php
                                    $item_id = $item['id'];
                                    $start_id = $items[0]['id'];
                                    $end_id = $end['id'];
                                ?>
                                <ul class="property-action-bar">
                                    <div class="move-buttons">
                                        <?php if ($item_id != $start_id): ?>
                                            <li class="property-action-item">
                                                <a href="<?= $this->url->href('ContactsItemsController', 'movePosition', array('item_id' => $item['id'], 'direction' => 'up', 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-move" title="<?=t('Move Property') ?>">
                                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        <?php endif ?>
                                        <?php if ($item_id != $end_id): ?>
                                            <li class="property-action-item">
                                                <a href="<?= $this->url->href('ContactsItemsController', 'movePosition', array('item_id' => $item['id'], 'direction' => 'down', 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-move" title="<?=t('Move Property') ?>">
                                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        <?php endif ?>
                                    </div>
                                    <div class="action-buttons">
                                        <li class="property-action-item">
                                            <a href="<?= $this->url->href('ContactsItemsController', 'edit', array('item_id' => $item['id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-rename js-modal-medium" title="<?=t('Edit Property') ?>">
                                                <span class="rename-icon"></span> <?= t('Rename') ?>
                                            </a>
                                        </li>
                                        <li class="property-action-item">
                                            <a href="<?= $this->url->href('ContactsItemsController', 'confirm', array('item_id' => $item['id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-delete js-modal-medium" title="<?=t('Delete Property') ?>">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i> <?= t('Delete') ?>
                                            </a>
                                        </li>
                                    </div>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </fieldset>
    <?php endif ?>
</div>
