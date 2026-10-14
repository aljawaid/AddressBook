<?php $items = $this->ContactsHelper->getItems() ?>
<div class="relative">
    <div class="ab-page-header">
        <h2 class=""><span class="project-contacts-icon"></span><?= t('Project Contacts') ?></h2>
    </div>

    <?php if ($this->user->hasAccess('ContactsDirectoryController', 'index')): ?>
        <a href="<?= $this->url->href('ContactsDirectoryController', 'index', array('plugin' => 'AddressBook')) ?>" class="btn address-book-btn">
            <span class="address-book-icon"></span> <?= t('Global Address Book') ?>
        </a>
    <?php endif ?>

    <?php if (empty($contacts)): ?>
        <p class="alert alert-info no-contacts"><?= t('No contacts found') ?></p>
        <p class="ab-info"><?= t('Add contacts here to link them to any tasks within this project.') ?></p>
    <?php endif ?>
    <p class="ab-info">
        <?= e('You currently have %s contacts in the %s project. Contacts shown here can be linked to any tasks within this project.', '<span class="ab-count-badge">' . count($contacts) . '</span>', '<strong>' . $project['name'] . '</strong>') ?>
        <?= $this->app->tooltipLink('<i class="fa fa-info-circle" aria-hidden="true"></i>', $this->url->href('ContactsController', 'assignmentHelp', array('project_id' => $project['id'], 'plugin' => 'AddressBook'))) ?>
    </p>
    <?php if (!empty($contacts)): ?>
        <section class="project-contacts-section">
            <table id="ProjectContactsTable" class="project-contacts-table table-small table-fixed">
                <thead class="table-head">
                    <tr class="table-row">
                        <th class="contacts-table-header column-20"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                        <th class="contacts-table-header column-20"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                        <th class="contacts-table-header column-20"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                        <th class="contacts-table-header column-20"><?= (empty($items[3])) ? "" : $items[3]['item'] ?></th>
                        <th class="contacts-table-header column-21"><?= t('Actions') ?></th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php foreach ($contacts as $key => $value): ?>
                        <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                        <tr class="table-row">
                            <td class="contacts-table-value">
                                <?php foreach ($values as $array_key => $array_value): ?>
                                    <?php if (current($values[$array_key]) && ($values[$array_key]['position'] == 1)): ?>
                                        <span title="<?= $values[$array_key]['contact_item_value'] ?>"><?= $values[$array_key]['contact_item_value'] ?></span>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </td>
                            <td class="contacts-table-value">
                                <?php foreach ($values as $array_key => $array_value): ?>
                                    <?php if (current($values[$array_key]) && ($values[$array_key]['position'] == 2)): ?>
                                        <span title="<?= $values[$array_key]['contact_item_value'] ?>"><?= $values[$array_key]['contact_item_value'] ?></span>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </td>
                            <td class="contacts-table-value">
                                <?php foreach ($values as $array_key => $array_value): ?>
                                    <?php if (current($values[$array_key]) && ($values[$array_key]['position'] == 3)): ?>
                                        <span title="<?= $values[$array_key]['contact_item_value'] ?>"><?= $values[$array_key]['contact_item_value'] ?></span>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </td>
                            <td class="contacts-table-value">
                                <?php foreach ($values as $array_key => $array_value): ?>
                                    <?php if (current($values[$array_key]) && ($values[$array_key]['position'] == 4)): ?>
                                        <span title="<?= $values[$array_key]['contact_item_value'] ?>"><?= $values[$array_key]['contact_item_value'] ?></span>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </td>
                            <td class="contacts-table-value">
                                <ul class="contacts-action-btns">
                                    <li class="">
                                        <?php foreach ($values as $array_key => $array_value): ?>
                                            <?php $arrayValueCount = count($values) ?>
                                        <?php endforeach ?>
                                        <?php if ($arrayValueCount < 4): ?>
                                            <!-- Modal Button -->
                                                <a href="<?= $this->url->href('ContactsController', 'details', array('project_id' => $project['id'], 'contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn js-modal-medium view-contact-btn no-info" title="<?= t('View Contact') ?>">
                                                    <span class="contact-profile-icon"></span>
                                                </a>
                                        <?php else: ?>
                                            <!-- Modal Button -->
                                            <a href="<?= $this->url->href('ContactsController', 'details', array('project_id' => $project['id'], 'contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn js-modal-medium view-contact-btn" title="<?= t('View more information for this contact') ?>">
                                                <span class="contact-profile-icon"></span>
                                            </a>
                                        <?php endif ?>
                                    </li>
                                    <?php if ($this->user->hasAccess('ContactsDirectoryController', 'edit')): ?>
                                        <li>
                                            <a href="<?= $this->url->href('ContactsDirectoryController', 'edit', array('contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-rename js-modal-large" title="<?= t('Edit Contact') ?>">
                                                <span class="contact-settings-icon"></span>
                                                <span class="edit-text"><?= t('Edit') ?></span>
                                            </a>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($this->user->hasProjectAccess('ContactsController', 'removeFromProject', $project['id'])): ?>
                                        <li>
                                            <?= $this->url->link(t('Remove from project'), 'ContactsController', 'confirmRemoveFromProject', array('project_id' => $project['id'], 'contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook'), false, 'btn btn-ab-delete js-modal-medium', t('Remove this contact from the project without deleting it')) ?>
                                        </li>
                                    <?php endif ?>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </section>
    <?php endif ?>
    <hr class="ab-section-divider">
    <?php if ($this->user->hasProjectAccess('ContactsController', 'assignToProject', $project['id']) && ! empty($availableContacts)): ?>
        <section class="assign-contact-section">
            <h3><?= t('Assign Existing Contact') ?></h3>
            <form method="post" action="<?= $this->url->href('ContactsController', 'assignToProject', array('project_id' => $project['id'], 'plugin' => 'AddressBook')) ?>">
                <?= $this->form->csrf() ?>
                <label for="form-contacts_id"><?= t('Global Contact') ?></label>
                <select id="form-contacts_id" name="contacts_id" required>
                    <?php foreach ($availableContacts as $availableContact): ?>
                        <option value="<?= (int) $availableContact['contacts_id'] ?>"><?= $this->text->e($availableContact['contact_item_value']) ?></option>
                    <?php endforeach ?>
                </select>
                <button type="submit" class="btn"><?= t('Assign to Project') ?></button>
            </form>
        </section>
        <hr class="ab-section-divider">
    <?php endif ?>
    <?php if (isset($addNew) && $addNew && $this->user->hasProjectAccess('ContactsController', 'save', $project['id'])): ?>
        <section class="add-new-contact-section">
            <?= $this->render('addressBook:contact/add', array('items' => $items, 'project_id' => $project['id'], 'values' => $values, 'errors' => $errors)) ?>
        </section>
    <?php endif ?>
</div>
