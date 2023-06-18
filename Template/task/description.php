<?php $contacts = $this->ContactsHelper->getContactsIDs($task['id']) ?>

<details class="accordion-section task-contacts-section" <?= empty($contacts) ? '' : 'open' ?>>
    <summary class="accordion-title"><span class=""><?= t('Task Contacts') ?></span></summary>
    <div class="accordion-content">
        <?php $items = $this->ContactsHelper->getItems() ?>
        <table id="TaskContactsTable" class="table-small table-fixed">
            <tr class="">
                <th class="contacts-table-header column-25"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                <th class="contacts-table-header column-25"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                <th class="contacts-table-header column-25"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                <th class="contacts-table-header column-15"></th>
            </tr>
            <?php foreach ($contacts as $key => $value): ?>
                <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                <tr class="">
                    <td class="contacts-table-value"><?= (empty($values[1])) ? "" : $values[1]['contact_item_value'] ?></td>
                    <td class="contacts-table-value"><?= (empty($values[2])) ? "" : $values[2]['contact_item_value'] ?></td>
                    <td class="contacts-table-value"><?= (empty($values[3])) ? "" : $values[3]['contact_item_value'] ?></td>
                    <td class="contacts-table-value">
                        <?php if (!empty($values[4])): ?>
                            <?= $this->modal->medium('', t('View Contact'), 'ContactsController', 'details', array('contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook')) ?>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</details>
