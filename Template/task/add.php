<div class="page-header">
    <h2><?= t('Task') . ' #' . $task['id'] . ' : ' . $task['title'] ?></h2>
</div>
<div class="page-header">
    <h3><?= $formtitle ?></h2>
</div>

<?php if (empty($contacts)): ?>
    <p class="alert"><?= t('No contacts') ?></p>
<?php else: ?>
    <?php $items = $this->ContactsHelper->getItems() ?>
    <table class="table-small table-fixed">
    <tr>
        <th class="column-1"></th>
        <th class="column-25"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
        <th class="column-25"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
        <th class="column-25"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
        <th class="column-14"></th>
    </tr>
    <?php foreach ($contacts as $key => $value): ?>
    <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
    <tr>
        <td><?= $this->url->link('<i class="fa  fa-arrow-down" aria-hidden="true"></i>', 'ContactsController', 'removeFromTask', array('contacts_id' => $value['contacts_id'], 'project_id' => $project['id'], 'task_id' => $task['id'], 'plugin' => 'AddressBook'), false, '') ?></td>
        <td><?= (empty($values[1])) ? "" : $values[1]['value'] ?></td>
        <td><?= (empty($values[2])) ? "" : $values[2]['value'] ?></td>
        <td><?= (empty($values[3])) ? "" : $values[3]['value'] ?></td>
        <td>
            <?php if (count($values) > 3): ?>
                <?= $this->modal->medium('', t('additional'), 'ContactsController', 'details', array('plugin' => 'AddressBook','contacts_id' => $value['contacts_id'])) ?>
            <?php endif ?>
        </td>
    </tr>
    <?php endforeach ?>
    </table>
<?php endif ?>

<div class="page-header">
    <h3><?= t('Available contacts') ?></h2>
</div>
<?php if (empty($contactsNotInTask)): ?>
    <p class="alert"><?= t('No contacts') ?></p>
<?php else: ?>
    <table class="table-small table-fixed">
        <tr>
            <th class="column-1"></th>
            <th class="column-25"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
            <th class="column-25"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
            <th class="column-25"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
            <th class="column-14"></th>
        </tr>
        <?php foreach ($contactsNotInTask as $key => $value): ?>
            <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
            <tr>
                <td><?= $this->url->link('<i class="fa  fa-arrow-up" aria-hidden="true"></i>', 'ContactsController', 'addToTask', array('contacts_id' => $value['contacts_id'], 'project_id' => $project['id'], 'task_id' => $task['id'], 'plugin' => 'AddressBook'), false, '') ?></td>
                <td><?= (empty($values[1])) ? "" : $values[1]['value'] ?></td>
                <td><?= (empty($values[2])) ? "" : $values[2]['value'] ?></td>
                <td><?= (empty($values[3])) ? "" : $values[3]['value'] ?></td>
                <td>
                    <?php if (count($values) > 3): ?>
                        <?= $this->modal->medium('', t('additional'), 'ContactsController', 'details', array('plugin' => 'AddressBook','contacts_id' => $value['contacts_id'])) ?>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif ?>
