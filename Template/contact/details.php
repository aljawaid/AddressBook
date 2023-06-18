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

<?php foreach ($contact as $key => $value): ?>
    <?php
    $updated = $value['last_updated'];
    $last_updated = $this->dt->datetime($updated);
    $user = $this->model->userModel->getById($value['updated_by_user_id']);
    $edited_by = $user['name'];
    ?>
<?php endforeach ?>

<div class="contact-details-modal">
    <div class="ab-page-header">
        <h2 class="">
            <span class="contact-details-icon"></span><?= t('Contact Details') ?>
        </h2>
    </div>

    <?php if (empty($contact)): ?>
        <p class="alert"><?= t('No contacts') ?></p>
    <?php else: ?>
        <table id="ContactDetailsTable" class="contact-details-table table-small table-fixed">
            <tbody class="table-body">
                <?php foreach ($contact as $key => $value): ?>
                    <tr class="">
                        <td class=""><?= $value['item'] ?></td>
                        <td class=""><?= $value['contact_item_value'] ?></td>
                    </tr>

                <?php endforeach ?>
            </tbody>
            <tfoot class="table-footer">
                <tr class="table-row">
                    <td colspan="2"><?= e('Last updated on %s by %s', '&nbsp;<i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;' . $last_updated, '<i class="fa fa-user" aria-hidden="true"></i>&nbsp;' . $edited_by) ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif ?>
</div>
