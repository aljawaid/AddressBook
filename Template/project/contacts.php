<?php $items = $this->ContactsHelper->getItems() ?>
<div class="relative">
    <div class="ab-page-header">
        <h2 class=""><span class="contact-profile-icon"></span><?= t('Project Contacts') ?></h2>
    </div>

    <?php if ($this->user->hasAccess('UserListController', 'show')): ?>
        <a href="<?= $this->url->href('ContactsItemsController', 'config', array('plugin' => 'AddressBook')) ?>" class="btn address-book-btn">
            <span class="address-book-icon"></span> <?= t('Address Book Settings') ?>
        </a>
    <?php endif ?>

    <?php if (empty($contacts)): ?>
        <p class="alert alert-info no-contacts"><?= t('No contacts found') ?></p>
    <?php endif ?>
    <p class="ab-info">
        <?= e('This section lists all contacts for the %s project. Once you have added contacts here, you can link any contact to any task within this project.', '<strong>' . $project['name'] . '</strong>') ?>
    </p>
    <?php if (!empty($contacts)): ?>
        <section class="project-contacts-section">
            <table class="project-contacts-table table-small table-fixed">
                <tr class="">
                    <th class="project-contacts-table-item column-20"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                    <th class="project-contacts-table-item column-20"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                    <th class="project-contacts-table-item column-20"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                    <th class="project-contacts-table-item column-20"><?= (empty($items[3])) ? "" : $items[3]['item'] ?></th>
                    <th class="project-contacts-table-item column-20"><?= t('Action') ?></th>
                </tr>
                <?php foreach ($contacts as $key => $value): ?>
                    <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                    <tr class="">
                        <td class="project-contacts-table-value"><?= (empty($values[1])) ? "" : $values[1]['contact_item_value'] ?></td>
                        <td class="project-contacts-table-value"><?= (empty($values[2])) ? "" : $values[2]['contact_item_value'] ?></td>
                        <td class="project-contacts-table-value"><?= (empty($values[3])) ? "" : $values[3]['contact_item_value'] ?></td>
                        <td class="project-contacts-table-value"><?= (empty($values[4])) ? "" : $values[4]['contact_item_value'] ?></td>
                        <td class="project-contacts-table-value">
                            <?= $this->render('addressBook:project/menu', array('project' => $project, 'more' => !empty($values[5]), 'contacts_id' => $value['contacts_id'])) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </section>
    <?php endif ?>
    <?php if (isset($addNew) && $addNew): ?>
        <section class="add-new-contact-section">
            <?= $this->render('addressBook:contact/add', array('items' => $items, 'project_id' => $project['id'], 'values' => $values, 'errors' => $errors)) ?>
        </section>
    <?php endif ?>
</div>
