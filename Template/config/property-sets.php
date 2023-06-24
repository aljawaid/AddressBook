<hr class="property-set-divider">
<div class="property-set-wrapper">
    <h4 class=""><span class="property-sets-icon"></span><?= t('Property Sets') ?></h4>
    <p class=""><?= e('Individual properties can always be added, renamed or removed. %sAny existing properties which are used for contacts in tasks and projects will also be deleted if the property names match.%s', '<strong>', '</strong>') ?></p>

    <section class="property-set-section">
        <a href="<?= $this->url->href('ContactsItemsController', 'insertSetPersonal', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move add-property-set" title="<?= t('Add Set') ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <a href="<?= $this->url->href('ContactsItemsController', 'confirmRemoveSet', array('set' => 'personal', 'plugin' => 'AddressBook'), false, '', false) ?>" class="btn btn-ab-move remove-property-set js-modal-medium" title="<?= t('Remove Set') ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
        <div class="property-set-name"><span class="property-sets-icon"></span><?= t('Personal') ?></div>
        <ul class="property-set-items">
            <li class=""><?= t('Address') ?></li>
            <li class=""><?= t('Telephone') ?></li>
            <li class=""><?= t('Mobile') ?></li>
            <li class=""><?= t('Email') ?></li>
            <li class=""><?= t('Relationship') ?></li>
            <li class=""><?= t('Note') ?></li>
        </ul>
    </section>
    <section class="property-set-section">
        <a href="<?= $this->url->href('ContactsItemsController', 'insertSetBusiness', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move add-property-set" title="<?= t('Add Set') ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <a href="<?= $this->url->href('ContactsItemsController', 'removeSetBusiness', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move remove-property-set" title="<?= t('Remove Set') ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
        <div class="property-set-name"><span class="property-sets-icon"></span><?= t('Business') ?></div>
        <ul class="property-set-items">
            <li class=""><?= t('Address') ?></li>
            <li class=""><?= t('Telephone') ?></li>
            <li class=""><?= t('Mobile') ?></li>
            <li class=""><?= t('Email') ?></li>
            <li class=""><?= t('Website') ?></li>
            <li class=""><?= t('Note') ?></li>
        </ul>
    </section>
    <section class="property-set-section">
        <a href="<?= $this->url->href('ContactsItemsController', 'insertSetCompany', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move add-property-set" title="<?= t('Add Set') ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <a href="<?= $this->url->href('ContactsItemsController', 'removeSetCompany', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move remove-property-set" title="<?= t('Remove Set') ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
        <div class="property-set-name"><span class="property-sets-icon"></span><?= t('Company') ?></div>
        <ul class="property-set-items">
            <li class=""><?= t('Department') ?></li>
            <li class=""><?= t('Address') ?></li>
            <li class=""><?= t('Telephone') ?></li>
            <li class=""><?= t('Extension') ?></li>
            <li class=""><?= t('Contact Name') ?></li>
            <li class=""><?= t('Mobile') ?></li>
            <li class=""><?= t('Email') ?></li>
            <li class=""><?= t('Website') ?></li>
            <li class=""><?= t('Note') ?></li>
        </ul>
    </section>
    <section class="property-set-section">
        <a href="<?= $this->url->href('ContactsItemsController', 'insertSetPeople', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move add-property-set" title="<?= t('Add Set') ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <a href="<?= $this->url->href('ContactsItemsController', 'removeSetPeople', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move remove-property-set" title="<?= t('Remove Set') ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
        <div class="property-set-name"><span class="property-sets-icon"></span><?= t('People') ?></div>
        <ul class="property-set-items">
            <li class=""><?= t('Title') ?></li>
            <li class=""><?= t('Telephone') ?></li>
            <li class=""><?= t('Mobile') ?></li>
        </ul>
    </section>
    <section class="property-set-section">
        <a href="<?= $this->url->href('ContactsItemsController', 'insertSetTeam', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move add-property-set" title="<?= t('Add Set') ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <a href="<?= $this->url->href('ContactsItemsController', 'removeSetTeam', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move remove-property-set" title="<?= t('Remove Set') ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
        <div class="property-set-name"><span class="property-sets-icon"></span><?= t('Team') ?></div>
        <ul class="property-set-items">
            <li class=""><?= t('Title') ?></li>
            <li class=""><?= t('Telephone') ?></li>
            <li class=""><?= t('Mobile') ?></li>
            <li class=""><?= t('Email') ?></li>
            <li class=""><?= t('Note') ?></li>
        </ul>
    </section>
</div>
