<?php

namespace Kanboard\Plugin\AddressBook\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    /* CREATE DYNAMIC ITEMS FOR ONE GENERAL CONTACT - ITEM TYPE WILL BE VALIDATED IN FRONTEND */
    $pdo->exec('CREATE TABLE IF NOT EXISTS address_book_contacts_items (
        id INT NOT NULL AUTO_INCREMENT,
        item VARCHAR(30) NOT NULL,
        item_type TEXT NOT NULL,
        position INT NOT NULL,
        PRIMARY KEY(id)
    )');

    /* SAVE VALUES OF DYNAMIC ITEMS FOR THE CONTACT */
    $pdo->exec('CREATE TABLE IF NOT EXISTS address_book_contacts_contact (
        contacts_id INT NOT NULL,
        item_id INT NOT NULL,
        contact_item_value TEXT NOT NULL,
        contact_status TEXT NOT NULL,
        updated_by_user_id INT NOT NULL,
        last_updated INTEGER NOT NULL,
        FOREIGN KEY(item_id) REFERENCES address_book_contacts_items(id) ON DELETE CASCADE,
        KEY(contacts_id)
    )');

    /* CREATE LINKS TO TASKS WITH CONTACTS */
    $pdo->exec('CREATE TABLE IF NOT EXISTS address_book_contacts_task_has_contact (
        id INT NOT NULL AUTO_INCREMENT,
        task_id INT NOT NULL,
        contacts_id INT NOT NULL,
        FOREIGN KEY(contacts_id) REFERENCES address_book_contacts_contact(contacts_id) ON DELETE CASCADE,
        FOREIGN KEY(task_id) REFERENCES tasks(id) ON DELETE CASCADE,
        PRIMARY KEY(id)
    )');

    /* ADD DEFAULTS FOR CONTACT ITEMS */
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, position) VALUES ("Name", "text", 1)');
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, position) VALUES ("Organisation", "text", 2)');
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, position) VALUES ("Address", "address", 3)');
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, position) VALUES ("Telephone", "telephone", 4)');
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, position) VALUES ("Mobile", "telephone", 5)');
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, position) VALUES ("Email", "email", 6)');
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, position) VALUES ("Website", "website", 7)');
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, position) VALUES ("Reference", "text", 8)');
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, position) VALUES ("Note", "text", 9)');
}