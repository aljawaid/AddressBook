<style type="text/css">
    /* MODAL SIZE */
    #modal-box {
        width: auto !important;
        overflow: hidden;
    }

    #modal-content {
        padding: 10px 15px;
    }

    /* MODAL CLOSE BUTTON */
    #modal-close-button {
        transform: scale(1.5);
        display: inline-block;
        position: absolute;
        right: 5px;
        top: 6px;
        background: var(--pp-red-alt-2);
        padding: 3px 3px 5px 6px;
        border-bottom-left-radius: 3px;
        box-shadow: -1px -1px 0 3px var(--pp-white);
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
            <span class="contact-details-icon"></span><?= $title ?>
        </h2>
    </div>

    <?php if (empty($contact)): ?>
        <p class="alert"><?= t('No contacts') ?></p>
    <?php else: ?>
        <table id="ContactDetailsTable" class="contact-details-table table-small table-fixed">
            <tbody class="table-body">
                <tr class="table-row">
                    <th class="contact-table-header column-25"><?= t('Contact ID') ?></th>
                    <td class="contact-table-value column-75"><?= $contact_id ?></td>
                </tr>
                <?php foreach ($contact as $key => $value): ?>
                    <tr class="table-row">
                        <th class="contact-table-header column-25"><?= $value['item'] ?></th>
                        <?php if ($value['item_type'] == 'address'): ?>
                            <td class="contact-table-value column-75">
                                <?= $this->text->markdown($value['contact_item_value']) ?>
                            </td>
                        <?php elseif ($value['item_type'] == 'textarea'): ?>
                            <td class="contact-table-value column-75">
                                <?= $this->text->markdown($value['contact_item_value']) ?>
                            </td>
                        <?php elseif ($value['item_type'] == 'email'): ?>
                            <td class="contact-table-value column-75">
                                <a href="mailto:<?= $value['contact_item_value'] ?>" class="email-display" title="<?= t('Send Email') ?>">
                                    <?= $value['contact_item_value'] ?>
                                </a>
                            </td>
                        <?php elseif ($value['item_type'] == 'url'): ?>
                            <td class="contact-table-value column-75">
                                <a href="<?= $value['contact_item_value'] ?>" class="url-display" title="<?= t('Opens in a new window') ?> &#8663;" target="_blank" rel="noopener noreferrer">
                                    <?= $value['contact_item_value'] ?>
                                </a>
                            </td>
                        <?php elseif ($value['item_type'] == 'telephone'): ?>
                            <td class="contact-table-value column-75">
                                <a href="tel:<?= $value['contact_item_value'] ?>" class="telephone-display">
                                    <?= $value['contact_item_value'] ?>
                                </a>
                            </td>
                        <?php else: ?>
                            <td class="contact-table-value column-75"><?= $value['contact_item_value'] ?></td>
                        <?php endif ?>
                    </tr>

                <?php endforeach ?>
            </tbody>
            <tfoot class="table-footer">
                <tr class="table-row">
                    <td colspan="3"><?= e('Last updated on %s by %s', '<span class="contact-updated-date"><i class="fa fa-calendar" aria-hidden="true"></i>' . $last_updated . '</span>', '<span class="contact-updated-user"><i class="fa fa-user" aria-hidden="true"></i>' . $edited_by . '</span>') ?></td>
                </tr>
            </tfoot>
        </table>
    <?php endif ?>
</div>
