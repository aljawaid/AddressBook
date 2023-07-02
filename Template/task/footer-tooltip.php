<div class="footer-tooltip">
    <div class="ab-page-header relative">
        <h3 class=""><span class="linked-contact-icon"></span><?= t('Task Contacts') ?></h3>
        <a href="<?= $this->url->href('ContactsController', 'task', array('project_id' => $project_id, 'task_id' => $task_id, 'plugin' => 'AddressBook'), false, '', false) ?>" class="task-contacts-summary-btn">
            <span class="address-book-icon"></span> <?= t('Link Contacts') ?>
        </a>
    </div>
    <?php if (!empty($contacts)): ?>
        <?php $items = $this->ContactsHelper->getItems() ?>
        <table id="TooltipContactsTable" class="table-small table-fixed">
            <thead class="table-head">
                <tr class="table-row">
                    <th class="contacts-table-header column-25"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                    <th class="contacts-table-header column-25"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                    <th class="contacts-table-header column-25"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                    <th class="contacts-table-header column-25"><?= (empty($items[3])) ? "" : $items[3]['item'] ?></th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php foreach ($contacts as $key => $value): ?>
                    <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                    <tr class="table-row">
                        <td class="contacts-table-value" title="">
                            <?php foreach ($values as $array_key => $array_value): ?>
                                <?php if (current($values[$array_key]) && ($values[$array_key]['position'] == 1)): ?>
                                    <?= $values[$array_key]['contact_item_value'] ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>
                        <td class="contacts-table-value" title="">
                            <?php foreach ($values as $array_key => $array_value): ?>
                                <?php if (current($values[$array_key]) && ($values[$array_key]['position'] == 2)): ?>
                                    <?= $values[$array_key]['contact_item_value'] ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>
                        <td class="contacts-table-value" title="">
                            <?php foreach ($values as $array_key => $array_value): ?>
                                <?php if (current($values[$array_key]) && ($values[$array_key]['position'] == 3)): ?>
                                    <?= $values[$array_key]['contact_item_value'] ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>
                        <td class="contacts-table-value" title="">
                            <?php foreach ($values as $array_key => $array_value): ?>
                                <?php if (current($values[$array_key]) && ($values[$array_key]['position'] == 4)): ?>
                                    <?= $values[$array_key]['contact_item_value'] ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
</div>
