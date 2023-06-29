<div id="ABConfigPage" class="ab-config-page">
    <div class="ab-page-header">
        <h2 class="config-title">
            <span class="address-book-icon"></span> <?= t('Contact Settings') ?>
        </h2>
    </div>
    <fieldset class="ab-new-item">
        <legend class=""><span class="property-icon"></span> <?= t('Add New Property') ?></legend>
        <p class="new-item-intro">
            <?= t('Each contact is associated with a contact profile. A standard contact profile consists of many properties. Add custom properties to adjust the standard contact profile according to your requirements or choose from one of the sets below.') ?>
        </p>
        <form id="AddPropertyForm" method="post" action="<?= $this->url->href('ContactsItemsController', 'save', array('plugin' => 'AddressBook')) ?>" autocomplete="on" class="add-property-form">
            <?= $this->form->csrf() ?>
            <div class="input-section">
                <?= $this->form->label(t('Property Name'), 'item', array('class="property-label"')) ?>
                <?= $this->form->text('item', $values, array(), array('autofocus', 'required', 'placeholder="' . t('Department') . '"'), 'property-input') ?>
                <p class="form-help"><?= t('Add properties individually') ?></p>
            </div>
            <div class="input-section">
                <?= $this->form->label(t('Property Type'), 'item_type', array('class="property-label"')) ?>
                <select id="form-item_type" class="property-input-select" name="item_type" required>
                    <option value="" selected disabled hidden><?= t('--- Select Type ---') ?></option>
                    <option value="address"><?= t('Address') ?></option>
                    <option value="email"><?= t('Email') ?></option>
                    <option value="textarea"><?= t('Long Text') ?></option>
                    <option value="number"><?= t('Number') ?></option>
                    <option value="decimal2"><?= t('Number (Decimal 2)') ?></option>
                    <option value="decimal4"><?= t('Number (Decimal 4)') ?></option>
                    <option value="telephone"><?= t('Telephone') ?></option>
                    <option value="text"><?= t('Text') ?></option>
                    <option value="url"><?= t('URL') ?></option>
                </select>
                <span class="form-required">*</span>
                <p class="form-help"><?= t('Use "Text" for general usage') ?></p>
            </div>
            <div class="input-section">
                <?= $this->form->label(t('Property Note'), 'item_help', array('class="property-label"')) ?>
                <?= $this->form->text('item_help', $values, array(), array('title="' . t('Maximum 100 characters only') . '"', 'maxlength="100"', 'placeholder="' . t('Specifiy Department Name') . '"'), 'property-input') ?>
                <p class="form-help"><?= t('Add a short descriptive note for this property to help users when creating contacts') ?></p>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-ab-property"><span class="property-icon"></span> <?= t('Add Property') ?></button>
            </div>
        </form>
        <?= $this->render('addressBook:config/property-sets') ?>
    </fieldset>
    <?php if (!empty($items)): ?>
        <fieldset class="ab-contact-profile">
            <legend><span class="contact-profile-icon"></span> <?= t('Contact Profile') ?></legend>
            <p class="contact-profile-intro">
                <?php if (count($items) == 1): ?>
                    <?= t('There is currently only 1 property which builds a standard contact profile.') ?>
                <?php else: ?>
                    <?= t('There are currently %s properties which together build a standard contact profile.', count($items)) ?>
                <?php endif ?>
            </p>
            <table id="ContactProfileTable" class="contact-profile-table">
                <thead class="table-head">
                    <tr class="table-row">
                        <th class=""><?= t('Contact Property') ?></th>
                        <th class="column-10 property-note-column"><?= t('Property Note') ?></th>
                        <th class="column-8 text-center"><?= t('Property Type') ?></th>
                        <th class="column-8 text-center"><?= t('Property Set') ?></th>
                        <th class="column-25"><?= t('Actions') ?></th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php $end = end($items) ?>
                    <?php foreach ($items as $item): ?>
                        <tr class="table-row">
                            <td class=""><?= $item['item'] ?></td>
                            <td class="form-help"><?= $item['item_help'] ?></td>
                            <td class="text-center"><?= $item['item_type'] ?></td>
                            <td class="text-center"><?= $item['property_set'] ?></td>
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
                                                <!-- Arrow UP Button-->
                                                <a href="<?= $this->url->href('ContactsItemsController', 'movePosition', array('item_id' => $item['id'], 'direction' => 'up', 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-move" title="<?=t('Move Property') ?>">
                                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        <?php endif ?>
                                        <?php if ($item_id != $end_id): ?>
                                            <li class="property-action-item">
                                                <!-- Arrow DOWN Button -->
                                                <a href="<?= $this->url->href('ContactsItemsController', 'movePosition', array('item_id' => $item['id'], 'direction' => 'down', 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-move" title="<?=t('Move Property') ?>">
                                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        <?php endif ?>
                                    </div>
                                    <div class="action-buttons">
                                        <li class="property-action-item">
                                            <!-- Modal Button -->
                                            <a href="<?= $this->url->href('ContactsItemsController', 'edit', array('item_id' => $item['id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-rename js-modal-medium" title="<?=t('Edit Property') ?>">
                                                <span class="rename-icon"></span> <?= t('Edit') ?>
                                            </a>
                                        </li>
                                        <li class="property-action-item">
                                            <?php if ($item_id == 1): ?>
                                                <!-- Modal Button -->
                                                <span class="btn-disabled-wrapper" title="<?= t('The first property can never be deleted') ?>">
                                                    <a href="<?= $this->url->href('ContactsItemsController', 'confirm', array('item_id' => $item['id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-delete js-modal-medium btn-disabled" title="<?=t('Delete Property') ?>">
                                                        <i class="fa fa-trash-o" aria-hidden="true"></i> <?= t('Delete') ?>
                                                    </a>
                                                </span>
                                            <?php else: ?>
                                                <!-- Modal Button -->
                                                <a href="<?= $this->url->href('ContactsItemsController', 'confirm', array('item_id' => $item['id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-delete js-modal-medium" title="<?=t('Delete Property') ?>">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> <?= t('Delete') ?>
                                                </a>
                                            <?php endif ?>
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
