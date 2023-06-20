<div class="footer-tooltip">
    <div class="ab-page-header">
        <h2 class=""><span class="linked-contact-icon"></span><?= t('Task Contacts') ?></h2>
    </div>
    <?php if (!empty($contacts)): ?>
        <?php $items = $this->ContactsHelper->getItems() ?>
        <table id="TooltipContactsTable" class="table-small table-fixed">
            <thead class="table-head">
                <tr class="table-row">
                    <th class="column-25"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                    <th class="column-25"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                    <th class="column-25"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                    <th class="column-15"></th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php foreach ($contacts as $key => $value): ?>
                    <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                    <tr class="table-row">
                        <td class=""><?= (empty($values[1])) ? "" : $values[1]['contact_item_value'] ?></td>
                        <td class=""><?= (empty($values[2])) ? "" : $values[2]['contact_item_value'] ?></td>
                        <td class=""><?= (empty($values[3])) ? "" : $values[3]['contact_item_value'] ?></td>
                        <td class="">
                            <?php if (!empty($values[4])): ?>
                                <?= $this->modal->medium('', t('View Contact'), 'ContactsController', 'details', array('contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook')) ?>
                            <?php endif ?>
                        </td>
                    </tr>
                </tbody>
            <?php endforeach ?>
        </table>
    <?php endif ?>
</div>
