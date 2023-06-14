<div class="">
    <div class="page-header">
        <h2 class=""><?= t('Contact details') ?></h2>
    </div>

    <?php if (empty($contact)): ?>
        <p class="alert"><?= t('No contacts') ?></p>
    <?php else: ?>
        <table class="table-small table-fixed">
            <tr class="">
                <th class="column-50"><?= t('Key') ?></th>
                <th class="column-50"><?= t('Value') ?></th>
            </tr>
            <?php foreach ($contact as $key => $value): ?>
                <tr class="">
                    <td class=""><?= $value['item'] ?></td>
                    <td class=""><?= $value['contact_item_value'] ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php endif ?>
</div>
