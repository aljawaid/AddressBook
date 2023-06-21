<hr class="property-set-divider">
<div class="property-set-wrapper">
    <h4 class=""><?= t('Property Sets') ?></h4>
    <p class=""><?= t('Individual properties can always be added, renamed or removed. Any existing properties which are used for contacts in tasks and projects will also be deleted if the property names match.') ?></p>

    <section class="property-set-section">
        <a href="<?= $this->url->href('ContactsItemsController', 'insertSetPersonal', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move add-property-set" title="<?= t('Add Set') ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <a href="<?= $this->url->href('ContactsItemsController', 'removeSetPersonal', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move remove-property-set" title="<?= t('Remove Set') ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
        <div class="property-set-name"><?= t('Personal') ?></div>
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
        <div class="property-set-name"><?= t('Business') ?></div>
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
        <div class="property-set-name"><?= t('Company') ?></div>
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
        <div class="property-set-name"><?= t('People') ?></div>
        <ul class="property-set-items">
            <li class=""><?= t('Title') ?></li>
            <li class=""><?= t('Telephone') ?></li>
            <li class=""><?= t('Mobile') ?></li>
        </ul>
    </section>
    <section class="property-set-section">
        <a href="<?= $this->url->href('ContactsItemsController', 'insertSetTeam', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move add-property-set" title="<?= t('Add Set') ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <a href="<?= $this->url->href('ContactsItemsController', 'removeSetTeam', array('plugin' => 'AddressBook')) ?>" class="btn btn-ab-move remove-property-set" title="<?= t('Remove Set') ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
        <div class="property-set-name"><?= t('Team') ?></div>
        <ul class="property-set-items">
            <li class=""><?= t('Title') ?></li>
            <li class=""><?= t('Telephone') ?></li>
            <li class=""><?= t('Mobile') ?></li>
            <li class=""><?= t('Email') ?></li>
            <li class=""><?= t('Note') ?></li>
        </ul>
    </section>
</div>
