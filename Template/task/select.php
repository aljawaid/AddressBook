<div class="">
    <div class="page-header">
        <h2 class=""><?= t('Task') . ' #' . $task['id'] . ' : ' . $task['title'] ?></h2>
    </div>
    <div class="page-header">
        <h3 class=""><?= $formtitle ?></h2>
    </div>

    <?php if (empty($contacts)): ?>
        <p class="alert"><?= t('No contacts') ?></p>
    <?php else: ?>
        <?php $items = $this->ContactsHelper->getItems() ?>
        <table class="table-small table-fixed">
            <tr class="">
                <th class="column-25"><?= $items[0]['item'] ?></th>
                <th class="column-25"><?= $items[1]['item'] ?></th>
                <th class="column-25"><?= $items[2]['item'] ?></th>
                <th class="column-15"></th>
            </tr>
            <?php foreach ($contacts as $key => $value): ?>
                <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                <tr class="">
                    <td class=""><?= $values[1]['value'] ?></td>
                    <td class=""><?= $values[2]['value'] ?></td>
                    <td class=""><?= $values[3]['value'] ?></td>
                    <td class="">
                        <?php if (count($values) > 3): ?>
                            <?= $this->modal->medium('', t('additional'), 'ContactsController', 'details', array('plugin' => 'AddressBook','contacts_id' => $value['contacts_id'])) ?>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php endif ?>

    <?php if (isset($addNew) and $addNew): ?>
        <?= $this->render('addressBook:contact/add', array('items' => $items, 'project_id' => $project['id'], 'values' => $values, 'errors' => $errors)) ?>
    <?php endif ?>

    <?php if (isset($selectNew) and $selectNew): ?>
        <div class="page-header">
            <h3 class=""><?= t('Available contacts') ?></h2>
        </div>
        <?php if (empty($contactsNotInTask)): ?>
            <p class="alert"><?= t('No contacts') ?></p>
        <?php else: ?>
            <?php $items = $this->ContactsHelper->getItems() ?>
            <table class="table-small table-fixed">
                <tr class="">
                    <th class="column-25"><?= $items[0]['item'] ?></th>
                    <th class="column-25"><?= $items[1]['item'] ?></th>
                    <th class="column-25"><?= $items[2]['item'] ?></th>
                    <th class="column-15"></th>
                </tr>
                <?php foreach ($contactsNotInTask as $key => $value): ?>
                    <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                    <tr class="">
                        <td class=""><?= $values[1]['value'] ?></td>
                        <td class=""><?= $values[2]['value'] ?></td>
                        <td class=""><?= $values[3]['value'] ?></td>
                        <td class="">
                            <?php if (count($values) > 3): ?>
                                <?= $this->url->link(t('additional'), 'ContactsController', 'details', array('plugin' => 'AddressBook','contacts_id' => $value['contacts_id']), false, 'popover') ?>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        <?php endif ?>
    <?php endif ?>
