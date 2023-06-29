<!-- REMOVE THIS SECTION -->
<!-- ------------------- -->
<!-- TEMPLATE FILE FOR LOCAL TRANSLATIONS - KEEP FILENAME IN LOWERCASE AS translations.php UNDER LANGUAGE CODE -->
<!-- EXAMPLE FILE: /Locale/en_GB/translations.php -->
<!-- EXAMPLE FILE: /Locale/en_US/translations.php -->
<!-- EXAMPLE FILE: /Locale/fr_FR/translations.php -->
<!-- EXAMPLE FILE: /Locale/de_DE/translations.php -->
<!-- ------------------- -->
<!-- REMOVE THIS SECTION -->
<?php

return array(
    //
    // GENERAL
    //
    'Use the dedicated Address Book to create and manage contacts or organisations in projects and tasks. Add custom properties to standardise a deeper relationship between tasks and people or places. Contacts can be linked exclusively to tasks in a project. Users can sort their contact properties to show the first 3 properties (e.g. name, number and email) for quick reference from the task summary and the project board view.' => '',
    //
    // Controller/ContactsController.php
    //
    'Your contact has been created successfully' => '',
    'Unable to create your contact' => '',
    'Contacts' => '',
    'Edit Contact' => '',
    'Your contact has been updated successfully' => '',
    'Unable to update contact' => '',
    'Delete Contact' => '',
    'Contact removed successfully' => '',
    'Unable to remove this contact' => '',
    'Task Contacts' => '',
    'Linked Contacts' => '',
    'Available Contacts' => '',
    //
    // Controller/ContactsItemsController.php
    //
    'Address Book Settings' => '',
    'Contact Property Updated' => '',
    'Unable to Update Contact Property' => '',
    'Delete Contact Property' => '',
    'Contact Property Deleted Successfully' => '',
    'Unable to Delete Contact Property' => '',
    'Contact Property Saved' => '',
    'Unable to Save Contact Property' => '',
    'Delete Property Set' => '',
    'Property Set Deleted' => '',
    'Unable to Delete Property Set' => '',
    'Personal Property Set Added' => '',
    'Unable to Add Property Set' => '',
    'Business Property Set Added' => '',
    'Company Property Set Added' => '',
    'People Property Set Added' => '',
    'Team Property Set Added' => '',
    //
    // Helper/ContactsHelper.php
    //
    'Property Name' => '',
    'Property Note' => '',
    'Maximum 100 characters only' => '',
    'Add a short descriptive note for this property to help users when creating contacts' => '',
    //
    // Template/config/edit.php
    //
    'Edit Property' => '',
    'Save Edits' => '',
    'Cancel' => '',
    //
    // Template/config/index.php
    //
    'Contact Settings' => '',
    'Add New Property' => '',
    'Each contact is associated with a contact profile. A standard contact profile consists of many properties. Add custom properties to adjust the standard contact profile according to your requirements or choose from one of the sets below.' => '',
    'Department' => '',
    'Add properties individually' => '',
    'Property Type' => '',
    'Property Set' => '',
    '--- Select Type ---' => '',
    'Address' => '',
    'Email' => '',
    'Long Text' => '',
    'Number' => '',
    'Number (Decimal 2)' => '',
    'Number (Decimal 4)' => '',
    'Telephone' => '',
    'Text' => '',
    'URL' => '',
    'Use "Text" for general usage' => '',
    'Specifiy Department Name' => '',
    'Add Property' => '',
    'Contact Profile' => '',
    'There are currently %s properties which together build a standard contact profile.' => '',
    'Contact Property' => '',
    'Actions' => '',
    'Move Property' => '',
    'Edit' => '',
    'The first property can never be deleted' => '',
    'Delete Property' => '',
    'Delete' => '',
    //
    // Template/config/property-sets.php
    //
    'Property Sets' => '',
    'Individual properties can always be added, renamed or removed. Properties created manually will belong to the %s set.' => '',
    'Custom' => '',
    'Add Set' => '',
    'Delete Set' => '',
    'Personal' => '',
    'Mobile' => '',
    'Relationship' => '',
    'Note' => '',
    'Business' => '',
    'Website' => '',
    'Company' => '',
    'Extension' => '',
    'Contact Name' => '',
    'People' => '',
    'Title' => '',
    'Team' => '',
    'Business Address' => '',
    'Company Address' => '',
    //
    // Template/config/remove-set.php
    //
    'Do you really want to remove the %s property set from the contact profile?' => '',
    'All properties with matching names to this set will be deleted regardless of whether they contain any data' => '',
    //
    // Template/config/sidebar.php
    //
    'Address Book' => '',
    //
    // Template/contact/add.php
    //
    'Add New Contact' => '',
    'All fields are optional. Blank forms will not be created.' => '',
    'someone@somewhere.com' => '',
    'Save notes for this contact' => '',
    'Enter address details for this contact' => '',
    'All numbers and symbols shown are allowed' => '',
    'Only whole numbers are allowed' => '',
    'Numbers with 2 decimals are allowed' => '',
    'Numbers with 4 decimals are allowed' => '',
    'Add Contact' => '',
    //
    // Template/contact/details.php
    //
    'Contact Details' => '',
    'Contact ID' => '',
    'No contacts' => '',
    'Last updated on %s by %s' => '',
    //
    // Template/contact/edit.php
    //
    'Format: 12345' => '',
    'Format: 0.01' => '',
    'Format: 0.0001' => '',
    'Format: +44 (0)1234 567890' => '',
    'Format: someone@somewhere.com' => '',
    'Format: https://' => '',
    //
    // Template/contact/remove.php
    //
    'Do you really want to delete %s as a contact in the Address Book?' => '',
    //
    // Template/project/contacts.php
    //
    'Project Contacts' => '',
    'No contacts found' => '',
    'Add contacts here to link them to any tasks within this project.' => '',
    'You currently have %s contacts in the %s project. Contacts shown here can be linked to any tasks within this project.' => '',
    'View more information for this contact' => '',
    'View Contact' => '',
    //
    // Template/task/footer-tooltip.php
    //
    'Link Contacts' => '',
    //
    // Template/task/link-contacts.php
    //
    'Linked Contact Information' => '',
    'Project Address Book' => '',
    'This section shows contacts linked to this task %s. Contacts must be added to the Project Address Book for them to be available for linking to a task.' => '',
    'Delink this contact from this task' => '',
    'No contacts found in the Address Book' => '',
    'This section lists all the contacts available for the %s project. Use the arrows to link contacts to this task or add new contacts to the Project Address Book to avail them here. Contacts are removed from this section when they are linked to tasks.' => '',
    'Link this contact to this task' => '',
    //
    // Validator/ContactsValidator.php
    //
    'The name of the property is required' => '',
    'The maximum length is %d characters' => '',
);
