<div class="relative">
    <div class="ab-page-header">
        <h2 class="">
            <?= t('Linked Contact Information') ?>
        </h2>
    </div>

    <?php if ($this->user->hasProjectAccess('ProjectViewController', 'show', $project['id'])): ?>
        <a href="<?= $this->url->href('ContactsController', 'project', array('project_id' => $project['id'], 'plugin' => 'AddressBook')) ?>" class="btn project-address-book-btn">
            <span class="address-book-icon"></span> <?= t('Project Address Book') ?> <span class="btn-count"><?= count($allProjectContacts) ?></span>
        </a>
    <?php endif ?>

    <section class="linked-contacts-section">
        <h3 class="">
            <span class="linked-contact-icon"></span><?= $formtitle ?><span class="contact-count-badge"><?= count($contacts) ?></span>
        </h3>
        <?php if (empty($contacts)): ?>
            <p class="alert alert-info no-contacts"><?= t('No contacts') ?></p>
        <?php endif ?>
        <p class="ab-info">
            <?= e('This section shows contacts linked to this task %s. Contacts must be added to the Project Address Book for them to be available for linking to a task.', '<strong><i>(#' . $task['id'] . ': ' . $task['title'] . ')</i></strong>') ?>
        </p>
        <?php if (!empty($contacts)): ?>
            <?php $items = $this->ContactsHelper->getItems() ?>
            <table id="LinkedContactsTable" class="linked-contacts-table table-small table-fixed">
                <thead class="table-head">
                    <tr class="table-row">
                        <th class="contacts-table-header column-4 cell-zero"></th>
                        <th class="contacts-table-header column-30"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                        <th class="contacts-table-header column-30"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                        <th class="contacts-table-header column-30"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                        <th class="contacts-table-header column-4 cell-zero"></th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php foreach ($contacts as $key => $value): ?>
                        <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                        <tr class="table-row">
                            <td class="contacts-table-value text-center cell-zero">
                                <!-- Arrow DOWN Button -->
                                <?= $this->url->link('<i class="fa fa-arrow-down" aria-hidden="true"></i>', 'ContactsController', 'removeFromTask', array('contacts_id' => $value['contacts_id'], 'project_id' => $project['id'], 'task_id' => $task['id'], 'plugin' => 'AddressBook'), false, 'btn delink-btn', t('Delink this contact from this task')) ?>
                            </td>
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
                            <td class="contacts-table-value text-center cell-zero">
                                <?php foreach ($values as $array_key => $array_value): ?>
                                    <?php $arrayValueCount = count($values) ?>
                                <?php endforeach ?>
                                <?php if ($arrayValueCount < 4): ?>
                                    <!-- Modal Button -->
                                    <a href="<?= $this->url->href('ContactsController', 'details', array('contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn js-modal-medium view-contact-btn no-info" title="<?= t('View Contact') ?>">
                                        <span class="contact-profile-icon"></span>
                                    </a>
                                <?php else: ?>
                                    <!-- Modal Button -->
                                    <a href="<?= $this->url->href('ContactsController', 'details', array('contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn js-modal-medium view-contact-btn" title="<?= t('View more information for this contact') ?>">
                                        <span class="contact-profile-icon"></span>
                                    </a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </section>
    <hr class="ab-section-divider">
    <section class="available-contacts-section">
        <h3 class="">
            <span class="available-contacts-icon"></span><?= $addformtitle ?><span class="contact-count-badge"><?= count($contactsNotInTask) ?></span>
        </h3>
        <?php if (empty($contactsNotInTask)): ?>
            <p class="alert alert-info no-contacts"><?= t('No contacts found in the Address Book') ?></p>
        <?php endif ?>
        <p class="ab-info">
            <?= e('This section lists all the contacts available for the %s project. Use the arrows to link contacts to this task or add new contacts to the Project Address Book to avail them here. Contacts are removed from this section when they are linked to tasks.', '<strong>' . $project['name'] . '</strong>') ?>
        </p>
        <?php if (!empty($contactsNotInTask)): ?>
            <?php $items = $this->ContactsHelper->getItems() ?>
            <table id="AvailableContactsTable" class="available-contacts-table table-small table-fixed">
                <thead class="table-head">
                    <tr class="table-row">
                        <th class="contacts-table-header column-4 cell-zero"></th>
                        <th class="contacts-table-header column-30"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                        <th class="contacts-table-header column-30"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                        <th class="contacts-table-header column-30"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                        <th class="contacts-table-header column-4 cell-zero"></th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php foreach ($contactsNotInTask as $key => $value): ?>
                        <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                        <tr class="table-row">
                            <td class="contacts-table-value text-center cell-zero">
                                <!-- Arrow UP Button -->
                                <?= $this->url->link('<i class="fa fa-arrow-up" aria-hidden="true"></i>', 'ContactsController', 'addToTask', array('contacts_id' => $value['contacts_id'], 'project_id' => $project['id'], 'task_id' => $task['id'], 'plugin' => 'AddressBook'), false, 'btn link-btn', t('Link this contact to this task')) ?>
                            </td>
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
                            <td class="contacts-table-value text-center cell-zero">
                                <?php foreach ($values as $array_key => $array_value): ?>
                                    <?php $arrayValueCount = count($values) ?>
                                <?php endforeach ?>
                                <?php if ($arrayValueCount < 4): ?>
                                    <!-- Modal Button -->
                                    <a href="<?= $this->url->href('ContactsController', 'details', array('contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn js-modal-medium view-contact-btn no-info" title="<?= t('View Contact') ?>">
                                        <span class="contact-profile-icon"></span>
                                    </a>
                                <?php else: ?>
                                    <!-- Modal Button -->
                                    <a href="<?= $this->url->href('ContactsController', 'details', array('contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn js-modal-medium view-contact-btn" title="<?= t('View more information for this contact') ?>">
                                        <span class="contact-profile-icon"></span>
                                    </a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </section>
</div>
