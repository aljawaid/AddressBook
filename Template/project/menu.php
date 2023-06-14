<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon">
        <i class="fa fa-cog fa-fw"></i><i class="fa fa-caret-down"></i>
    </a>
    <ul class="">
        <?php if ($more): ?>
            <li class="">
                <i class="fa fa-book" aria-hidden="true"></i>
                <?= $this->modal->medium('', t('View Contact'), 'ContactsController', 'details', array('project_id' => $project['id'], 'contacts_id' => $contacts_id, 'plugin' => 'AddressBook')) ?>
            </li>
        <?php endif ?>
        <li class="">
            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            <?= $this->modal->medium('', t('Edit'), 'ContactsController', 'edit', array('project_id' => $project['id'], 'contacts_id' => $contacts_id, 'plugin' => 'AddressBook')) ?>
        </li>
        <li class="">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
            <?= $this->modal->medium('', t('Remove'), 'ContactsController', 'confirm', array('project_id' => $project['id'], 'contacts_id' => $contacts_id, 'plugin' => 'AddressBook')) ?>
        </li>
    </ul>
</div>
