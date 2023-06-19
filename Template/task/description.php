<?php $contacts = $this->ContactsHelper->getContactsIDs($task['id']) ?>

<details class="accordion-section task-contacts-section" <?= empty($contacts) ? '' : 'open' ?>>
    <!-- Keep summary code intact -->
    <summary class="accordion-title"><span class="summary-wrapper"><span class="accordion-title-text"><?= t('Task Contacts') ?></span><span class="btn-count"><?= count($contacts) ?></span></span>
    </summary>
    <div class="accordion-content">
        <?php $items = $this->ContactsHelper->getItems() ?>
        <table id="TaskContactsTable" class="table-small table-fixed">
            <thead class="table-head">
                <tr class="table-row">
                    <th class="contacts-table-header column-25"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                    <th class="contacts-table-header column-25"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                    <th class="contacts-table-header column-25"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                    <th class="contacts-table-header column-24"><?= (empty($items[3])) ? "" : $items[3]['item'] ?></th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php foreach ($contacts as $key => $value): ?>
                    <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                    <tr class="table-row">
                        <td class="contacts-table-value"><?= (empty($values[1])) ? "" : $values[1]['contact_item_value'] ?></td>
                        <td class="contacts-table-value"><?= (empty($values[2])) ? "" : $values[2]['contact_item_value'] ?></td>
                        <td class="contacts-table-value"><?= (empty($values[3])) ? "" : $values[3]['contact_item_value'] ?></td>
                        <td class="contacts-table-value"><?= (empty($values[4])) ? "" : $values[4]['contact_item_value'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</details>
