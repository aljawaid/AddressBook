<div class="relative">
    <div class="ab-page-header">
        <h2 class="">
            <?= t('Task N°') . ' ' . $task['id'] . ': ' . $task['title'] . ': ' . t('Contact Information') ?>
        </h2>
    </div>

    <?php if ($this->user->hasProjectAccess('ProjectViewController', 'show', $project['id'])): ?>
        <a href="<?= $this->url->href('ContactsController', 'project', array('project_id' => $project['id'], 'plugin' => 'AddressBook')) ?>" class="btn project-address-book-btn">
            <span class="address-book-icon"></span> <?= t('Project Address Book') ?> <span class="btn-count"><?= count($allProjectContacts) ?></span>
        </a>
    <?php endif ?>

    <section class="linked-contacts-section">
        <h3 class=""><span class="linked-contact-icon"></span><?= $formtitle ?></h3>
        <?php if (empty($contacts)): ?>
            <p class="alert alert-info no-contacts"><?= t('No contacts') ?></p>
        <?php endif ?>
        <p class="ab-info">
            <?= e('This section shows contacts linked to this task %s. Contacts must be added to the Project Address Book for them to be available for linking to a task.', '<strong><i>(#' . $task['id'] . ': ' . $task['title'] . ')</i></strong>') ?>
        </p>
        <?php if (!empty($contacts)): ?>
            <?php $items = $this->ContactsHelper->getItems() ?>
            <table id="LinkedContactsTable" class="linked-contacts-table table-small table-fixed">
                <tr class="">
                    <th class="column-1"></th>
                    <th class="column-25"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                    <th class="column-25"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                    <th class="column-25"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                    <th class="column-14"></th>
                </tr>
                <?php foreach ($contacts as $key => $value): ?>
                    <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                    <tr class="">
                        <td class="">
                            <?= $this->url->link('<i class="fa fa-arrow-down" aria-hidden="true"></i>', 'ContactsController', 'removeFromTask', array('contacts_id' => $value['contacts_id'], 'project_id' => $project['id'], 'task_id' => $task['id'], 'plugin' => 'AddressBook'), false, 'delink-btn', t('Delink this contact from this task')) ?>
                        </td>
                        <td class=""><?= (empty($values[1])) ? "" : $values[1]['contact_item_value'] ?></td>
                        <td class=""><?= (empty($values[2])) ? "" : $values[2]['contact_item_value'] ?></td>
                        <td class=""><?= (empty($values[3])) ? "" : $values[3]['contact_item_value'] ?></td>
                        <td class="">
                            <?php if (count($values) > 3): ?>
                                <?= $this->modal->medium('', t('View Contact'), 'ContactsController', 'details', array('contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook')) ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        <?php endif ?>
    </section>

    <section class="available-contacts-section">
        <h3 class=""><span class="available-contact-icon"></span><?= $addformtitle ?></h3>
        <?php if (empty($contactsNotInTask)): ?>
            <p class="alert alert-info no-contacts"><?= t('No contacts found in the Address Book') ?></p>
        <?php endif ?>
        <p class="ab-info">
            <?= e('This section lists all the contacts available for the %s project. Use the arrows to link contacts to this task or add new contacts to the Project Address Book to avail them here.', '<strong>' . $project['name'] . '</strong>') ?>
        </p>
        <?php if (!empty($contactsNotInTask)): ?>
            <?php $items = $this->ContactsHelper->getItems() ?>
            <table id="AvailableContactsTable" class="available-contacts-table table-small table-fixed">
                <tr class="">
                    <th class="column-1"></th>
                    <th class="column-25"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                    <th class="column-25"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                    <th class="column-25"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                    <th class="column-14"></th>
                </tr>
                <?php foreach ($contactsNotInTask as $key => $value): ?>
                    <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                    <tr class="">
                        <td class="">
                            <?= $this->url->link('<i class="fa fa-arrow-up" aria-hidden="true"></i>', 'ContactsController', 'addToTask', array('contacts_id' => $value['contacts_id'], 'project_id' => $project['id'], 'task_id' => $task['id'], 'plugin' => 'AddressBook'), false, 'link-btn', t('Link this contact to this task')) ?>
                        </td>
                        <td class=""><?= (empty($values[1])) ? "" : $values[1]['contact_item_value'] ?></td>
                        <td class=""><?= (empty($values[2])) ? "" : $values[2]['contact_item_value'] ?></td>
                        <td class=""><?= (empty($values[3])) ? "" : $values[3]['contact_item_value'] ?></td>
                        <td class="">
                            <?php if (count($values) > 3): ?>
                                <?= $this->modal->medium('', t('View Contact'), 'ContactsController', 'details', array('contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook')) ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        <?php endif ?>
    </section>
</div>
