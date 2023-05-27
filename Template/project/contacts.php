<?php $items = $this->ContactsHelper->getItems() ?>
<div class="">
    <div class="page-header">
        <h2 class=""><?= t('Contacts') ?></h2>
    </div>
    <?php if (empty($contacts)): ?>
        <p class="alert"><?= t('No contacts') ?></p>
    <?php else: ?>
        <table class="table-small table-fixed">
            <tr class="">
                <th class="column-20"><?= (empty($items[0])) ? "" : $items[0]['item'] ?></th>
                <th class="column-20"><?= (empty($items[1])) ? "" : $items[1]['item'] ?></th>
                <th class="column-20"><?= (empty($items[2])) ? "" : $items[2]['item'] ?></th>
                <th class="column-20"><?= (empty($items[3])) ? "" : $items[3]['item'] ?></th>
                <th class="column-20"><?= t('Action') ?></th>
            </tr>
            <?php foreach ($contacts as $key => $value): ?>
                <?php $values = $this->ContactsHelper->getContactByID($value['contacts_id']) ?>
                <tr class="">
                    <td class=""><?= (empty($values[1])) ? "" : $values[1]['value'] ?></td>
                    <td class=""><?= (empty($values[2])) ? "" : $values[2]['value'] ?></td>
                    <td class=""><?= (empty($values[3])) ? "" : $values[3]['value'] ?></td>
                    <td class=""><?= (empty($values[4])) ? "" : $values[4]['value'] ?></td>
                    <td class=""><?= $this->render('addressBook:project/menu', array('project' => $project, 'more' => !empty($values[5]), 'contacts_id' => $value['contacts_id'])) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php endif ?>

    <?php if (isset($addNew) and $addNew): ?>
        <?= $this->render('addressBook:contact/add', array('items' => $items, 'project_id' => $project['id'], 'values' => $values, 'errors' => $errors)) ?>
    <?php endif ?>
</div>
