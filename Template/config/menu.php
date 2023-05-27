<div class="">
    <div class="dropdown">
        <a href="#" class="dropdown-menu dropdown-menu-link-icon">
            <i class="fa fa-cog fa-fw"></i><i class="fa fa-caret-down"></i>
        </a>
        <ul class="">
            <li class="">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                <?= $this->modal->medium('', t('Edit'), 'ContactsItemsController', 'edit', array('item_id' => $item_id, 'plugin' => 'AddressBook')) ?>
            </li>
            <li class="">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
                <?= $this->modal->medium('', t('Remove'), 'ContactsItemsController', 'confirm', array('item_id' => $item_id, 'plugin' => 'AddressBook')) ?>
            </li>
            <?php if ($item_id != $start_id): ?>
                <li class="">
                    <i class="fa  fa-arrow-up" aria-hidden="true"></i>
                    <?= $this->url->link(t('Move up'), 'ContactsItemsController', 'movePosition', array('item_id' => $item_id, 'direction' => 'up', 'plugin' => 'AddressBook'), false, '') ?>
                </li>
            <?php endif ?>
            <?php if ($item_id != $end_id): ?>
                <li class="">
                    <i class="fa  fa-arrow-down" aria-hidden="true"></i>
                    <?= $this->url->link(t('Move down'), 'ContactsItemsController', 'movePosition', array('item_id' => $item_id, 'direction' => 'down', 'plugin' => 'AddressBook'), false, '') ?>
                </li>
            <?php endif ?>
        </ul>
    </div>
</div>
