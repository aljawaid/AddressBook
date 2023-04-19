<?php $contacts = $this->ContactsHelper->getContactsIDs($task['id']) ?>

<section class="accordion-section <?= empty($contacts) ? 'accordion-collapsed' : '' ?>">
    <div class="accordion-title">
        <h3><a href="#" class="fa accordion-toggle"></a> <?= t('Contacts') ?></h3>
    </div>
    <div class="accordion-content">
    <?php $items = $this->ContactsHelper->getItems() ?>
    <table class="table-small table-fixed">
    <tr>
        <th class="column-25"><?= (empty($items[0]))?"":$items[0]['item'] ?></th>
        <th class="column-25"><?= (empty($items[1]))?"":$items[1]['item'] ?></th>
        <th class="column-25"><?= (empty($items[2]))?"":$items[2]['item'] ?></th>
        <th class="column-15"></th>
    </tr>
    <?php foreach ($contacts as $key => $value): ?>
    <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
    <tr>
        <td><?= (empty($values[1]))?"":$values[1]['value'] ?></td>
        <td><?= (empty($values[2]))?"":$values[2]['value'] ?></td>
        <td><?= (empty($values[3]))?"":$values[3]['value'] ?></td>
        <td>
            <?php if (!empty($values[4])): ?>
                <?= $this->modal->medium('', t('additional'), 'ContactsController', 'details', array('plugin' => 'AddressBook','contacts_id' => $value['contacts_id'])) ?>
            <?php endif ?>
        </td>
    </tr>
    <?php endforeach ?>
    </table>
    </div>
</section>
