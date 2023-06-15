<style type="text/css">
    /* MODAL SIZE */
    #modal-box {
        width: auto !important;
    }

    #modal-content {
        padding: 10px 15px;
    }

    /* MODAL CLOSE BUTTON */
    #modal-close-button {
        transform: scale(1.5);
        display: inline-block;
        position: absolute;
        right: 6px;
        top: 6px;
        background: var(--pp-red-alt-2);
        padding: 3px 3px 5px 6px;
        border-bottom-left-radius: 3px;
        box-shadow: -1px -1px 0px 3px var(--pp-white);
    }

    #modal-close-button i {
        color: var(--pp-white);
        transition: var(--transition-address-book);
    }

    #modal-close-button:hover i {
        color: var(--pp-grey);
        text-shadow: 0 0 1px var(--pp-white);
    }
</style>

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
