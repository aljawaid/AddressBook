<div class="">
    <div class="page-header">
        <h2 class=""><?= t('Task Contacts') ?></h2>
    </div>

    <?php if (empty($contacts)): ?>
        <p class="alert"><?= t('No contacts') ?></p>
    <?php else: ?>
        <?php $items = $this->ContactsHelper->getItems() ?>
        <table class="table-small table-fixed">
            <tr class="">
                <th class="column-25"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                <th class="column-25"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                <th class="column-25"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                <th class="column-15"></th>
            </tr>
            <?php foreach ($contacts as $key => $value): ?>
                <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                <tr class="">
                    <td class=""><?= (empty($values[1])) ? "" : $values[1]['contact_item_value'] ?></td>
                    <td class=""><?= (empty($values[2])) ? "" : $values[2]['contact_item_value'] ?></td>
                    <td class=""><?= (empty($values[3])) ? "" : $values[3]['contact_item_value'] ?></td>
                    <td class="">
                        <?php if (!empty($values[4])): ?>
                            <?= $this->modal->medium('', t('View Contact'), 'ContactsController', 'details', array('contacts_id' => $value['contacts_id'], 'plugin' => 'AddressBook')) ?>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php endif ?>
