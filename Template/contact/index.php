<div class="relative">
    <div class="ab-page-header">
        <h2><span class="address-book-icon"></span><?= t('Global Address Book') ?></h2>
    </div>

    <p class="ab-info">
        <i class="fa fa-info-circle" aria-hidden="true"></i>
        <?= t('Contacts are stored once in the global directory. Project managers can assign them to individual projects without creating duplicate records.') ?>
    </p>

    <?php if (empty($contacts)): ?>
        <p class="alert alert-info no-contacts"><?= t('No contacts found') ?></p>
    <?php else: ?>
        <table class="table-small table-fixed">
            <thead>
                <tr>
                    <th><?= t('Contact') ?></th>
                    <th><?= t('Assigned Projects') ?></th>
                    <th><?= t('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <td><?= $this->text->e($contact['contact_item_value']) ?></td>
                        <td>
                            <?php if (empty($assignments[$contact['contacts_id']])): ?>
                                <em><?= t('Not assigned') ?></em>
                            <?php else: ?>
                                <?= $this->text->e(implode(', ', array_column($assignments[$contact['contacts_id']], 'name'))) ?>
                            <?php endif ?>
                        </td>
                        <td>
                            <?= $this->url->link(t('View Contact'), 'ContactsDirectoryController', 'details', array('contacts_id' => $contact['contacts_id'], 'plugin' => 'AddressBook'), false, 'btn js-modal-medium') ?>
                            <?= $this->url->link(t('Edit'), 'ContactsDirectoryController', 'edit', array('contacts_id' => $contact['contacts_id'], 'plugin' => 'AddressBook'), false, 'btn js-modal-large') ?>
                            <?= $this->url->link(t('Delete'), 'ContactsDirectoryController', 'confirm', array('contacts_id' => $contact['contacts_id'], 'plugin' => 'AddressBook'), false, 'btn btn-red js-modal-medium') ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>

    <hr class="ab-section-divider">

    <?= $this->render('addressBook:contact/add', array(
        'items' => $items,
        'values' => $values,
        'errors' => $errors,
        'form_controller' => 'ContactsDirectoryController',
        'form_action' => 'save',
        'form_params' => array('plugin' => 'AddressBook'),
    )) ?>
</div>
