<?php $items = $this->ContactsHelper->getItems() ?>
<div class="">
    <div class="ab-page-header">
        <h2 class=""><span class="contact-profile-icon"></span><?= t('Project Contacts') ?></h2>
    </div>
    <?php if (empty($contacts)): ?>
        <p class="alert alert-info no-contacts"><?= t('No contacts found') ?></p>
    <?php endif ?>
    <p class="ab-info">
        <?= t('This section lists all contacts for the "%s" project. Once you have added contacts here, you can assign any contact to any task within this project.', $project['name']) ?>
    </p>
    <section class="project-contacts-section">
        <?php if (!empty($contacts)): ?>
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
                        <td class="project-contacts-table-value"><?= (empty($values[1])) ? "" : $values[1]['value'] ?></td>
                        <td class="project-contacts-table-value"><?= (empty($values[2])) ? "" : $values[2]['value'] ?></td>
                        <td class="project-contacts-table-value"><?= (empty($values[3])) ? "" : $values[3]['value'] ?></td>
                        <td class="project-contacts-table-value"><?= (empty($values[4])) ? "" : $values[4]['value'] ?></td>
                        <td class="project-contacts-table-value">
                            <?= $this->render('addressBook:project/menu', array('project' => $project, 'more' => !empty($values[5]), 'contacts_id' => $value['contacts_id'])) ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        <?php endif ?>
    </section>
    <?php if (isset($addNew) && $addNew): ?>
        <section class="add-new-contact-section">
            <?= $this->render('addressBook:contact/add', array('items' => $items, 'project_id' => $project['id'], 'values' => $values, 'errors' => $errors)) ?>
        </section>
    <?php endif ?>
</div>
