<section id="main" class="">
    <div class="page-header">
        <h2 class=""><?= t('Remove Item') ?></h2>
    </div>
<pre>

</pre>
    <div class="confirm">
        <p class="alert alert-info">
            <?= t('Do you really want to remove this item: "%s"?', $item['item']) ?>
        </p>
        <div class="form-actions">

            <?= $this->url->link(t('Delete'), 'ContactsItemsController', 'remove', array('plugin' => 'AddressBook', 'item_id' => $item['id']), true, 'btn btn-red') ?>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </div>
</section>
