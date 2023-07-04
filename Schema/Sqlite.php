<?php

namespace Kanboard\Plugin\AddressBook\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    /* CREATE DYNAMIC ITEMS FOR ONE GENERAL CONTACT - ITEM TYPE WILL BE VALIDATED IN FRONTEND */
    $pdo->exec('CREATE TABLE IF NOT EXISTS address_book_contacts_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
        item VARCHAR(30) NOT NULL,
        item_help TEXT,
        item_type TEXT NOT NULL,
        property_set TEXT,
        position INT NOT NULL
    )');

    /* SAVE VALUES OF DYNAMIC ITEMS FOR THE CONTACT */
    $pdo->exec('CREATE TABLE IF NOT EXISTS address_book_contacts_contact (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        contacts_id INTEGER NOT NULL,
        item_id INT NOT NULL,
        contact_item_value TEXT NOT NULL,
        updated_by_user_id INT NOT NULL,
        last_updated INTEGER NOT NULL,
        FOREIGN KEY(item_id) REFERENCES address_book_contacts_items(id) ON DELETE CASCADE
    )');

    /* CREATE LINKS TO TASKS WITH CONTACTS */
    $pdo->exec('CREATE TABLE IF NOT EXISTS address_book_contacts_task_has_contact (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        task_id INT NOT NULL,
        contacts_id INT NOT NULL,
        FOREIGN KEY(contacts_id) REFERENCES address_book_contacts_contact(id) ON DELETE CASCADE,
        FOREIGN KEY(task_id) REFERENCES tasks(id) ON DELETE CASCADE
    )');

    /* ADD DEFAULTS FOR CONTACT ITEMS */
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, property_set, position) VALUES ("Name", "text", "default", 1)');
}
