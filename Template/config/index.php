<div id="ABConfigPage" class="ab-config-page">
    <div class="ab-page-header">
        <h2 class=""><?= t('Contact Settings') ?></h2>
    </div>
    <form method="post" action="<?= $this->url->href('ContactsItemsController', 'save', array('plugin' => 'AddressBook')) ?>" autocomplete="off">

        <?= $this->form->csrf() ?>

            <div class="input-section">
                <?= $this->form->label(t('Property Name'), 'item', array('class="property-label"')) ?>
                <?= $this->form->text('item', $values, array(), array('autofocus', 'required', 'placeholder="' . t('Social Media Handle') . '"'), 'property-input') ?>
                <p class="form-help"><?= t('Add properties individually') ?></p>
            </div>
            <div class="input-section">
                <?= $this->form->label(t('Property Type'), 'item_type', array('class="property-label"')) ?>
                <?= $this->form->text('item_type', $values, array(), array('required', 'placeholder="' . t('text') . '"'), 'property-input') ?>
                <p class="form-help" title="<?= t('Allowed Types') ?>">
                    <code><?= t('text') ?></code><code><?= t('number') ?></code><code><?= t('address') ?></code><code><?= t('telephone') ?></code><code><?= t('email') ?></code><code><?= t('website') ?></code>
                </p>
            </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
        </div>
    </form>
    <?php if (!empty($items)): ?>
        <fieldset class="">
            <legend><?= t('Contact Profile') ?></legend>
            <table class="stable-striped table-scrolling">
                <thead>
                    <tr class="">
                        <th class="column-15"><?= t('Property') ?></th>
                        <th class="column-15"><?= t('Type') ?></th>
                        <th class="column-5"><?= t('Action') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $end = end($items) ?>
                    <?php foreach ($items as $item): ?>
                        <tr class="">
                            <td class=""><?= $item['item'] ?></td>
                            <td class=""><?= $item['item_type'] ?></td>
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
                                                <a href="<?= $this->url->href('ContactsItemsController', 'movePosition', array('item_id' => $item['id'], 'direction' => 'up', 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-blue" title="<?=t('Move Property') ?>">
                                                    <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        <?php endif ?>
                                        <?php if ($item_id != $end_id): ?>
                                            <li class="property-action-item">
                                                <a href="<?= $this->url->href('ContactsItemsController', 'movePosition', array('item_id' => $item['id'], 'direction' => 'down', 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-blue" title="<?=t('Move Property') ?>">
                                                    <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                        <?php endif ?>
                                    </div>
                                    <div class="action-buttons">
                                        <li class="property-action-item">
                                            <a href="<?= $this->url->href('ContactsItemsController', 'edit', array('item_id' => $item['id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-blue js-modal-medium" title="<?=t('Edit Property') ?>">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?= t('Rename') ?>
                                            </a>
                                        </li>
                                        <li class="property-action-item">
                                            <a href="<?= $this->url->href('ContactsItemsController', 'confirm', array('item_id' => $item['id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-red js-modal-medium" title="<?=t('Delete Property') ?>">
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
