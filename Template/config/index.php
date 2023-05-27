<div class="">
    <div class="page-header">
        <h2 class=""><?= t('Contact settings') ?></h2>
    </div>
    <?php if (!empty($items)): ?>
        <table class="stable-striped table-scrolling">
            <thead>
                <tr class="">
                    <th class="column-15"><?= t('Item') ?></th>
                    <th class="column-5"><?= t('Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $end = end($items) ?>
                <?php foreach ($items as $item): ?>
                    <tr class="">
                        <td class=""><?= $item['item'] ?></td>
                        <td class=""><?= $this->render('addressBook:config/menu', array('item_id' => $item['id'], 'start_id' => $items[0]['id'], 'end_id' => $end['id'])) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php endif ?>
    <div class="page-header">
        <h2 class=""><?= t('Add new item') ?></h2>
    </div>
    <form method="post" action="<?= $this->url->href('ContactsItemsController', 'save', array('plugin' => 'AddressBook')) ?>" autocomplete="off">

        <?= $this->form->csrf() ?>

        <?= $this->form->label(t('Item'), 'action_name') ?>
        <?= $this->form->text('item', $values) ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
        </div>
    </form>
