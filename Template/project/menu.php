<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon">
        <i class="fa fa-cog fa-fw"></i><i class="fa fa-caret-down"></i>
    </a>
    <ul class="">
        <?php if ($more): ?>
            <li class="">
                <i class="fa fa-book" aria-hidden="true"></i>
                <?= $this->modal->medium('', t('additional'), 'ContactsController', 'details', array('plugin' => 'AddressBook', 'project_id' => $project['id'], 'contacts_id' => $contacts_id)) ?>
            </li>
        <?php endif ?>
        <li class="">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            <?= $this->modal->medium('', t('Edit'), 'ContactsController', 'edit', array('plugin' => 'AddressBook', 'project_id' => $project['id'], 'contacts_id' => $contacts_id)) ?>
        </li>
        <li class="">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
            <?= $this->modal->medium('', t('Remove'), 'ContactsController', 'confirm', array('plugin' => 'AddressBook', 'project_id' => $project['id'], 'contacts_id' => $contacts_id)) ?>
        </li>
    </ul>
</div>
