<?php

namespace Kanboard\Plugin\AddressBook\Schema;

use PDO;

const VERSION = 2;

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
        FOREIGN KEY(task_id) REFERENCES tasks(id) ON DELETE CASCADE
    )');

    /* ADD DEFAULTS FOR CONTACT ITEMS */
    $pdo->exec('INSERT INTO address_book_contacts_items(item, item_type, property_set, position) VALUES ("Name", "text", "default", 1)');
}

function version_2(PDO $pdo)
{
    /* Covered by tests/Schema/DatabaseMigrationTest.php for upgrades and fresh installations. */
    /* Create a stable identity for each contact before rebuilding legacy relationships. */
    $pdo->exec('CREATE TABLE address_book_contacts (
        id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
        created_at INTEGER NOT NULL
    )');
    $pdo->exec('INSERT OR IGNORE INTO address_book_contacts (id, created_at)
        SELECT contacts_id, 0 FROM address_book_contacts_contact
        UNION
        SELECT contacts_id, 0 FROM address_book_contacts_task_has_contact');

    /* Preserve one latest value for each contact property and enforce the normalised relationship. */
    $pdo->exec('CREATE TABLE address_book_contacts_contact_v2 (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        contacts_id INTEGER NOT NULL,
        item_id INT NOT NULL,
        contact_item_value TEXT NOT NULL,
        updated_by_user_id INT NOT NULL,
        last_updated INTEGER NOT NULL,
        FOREIGN KEY(contacts_id) REFERENCES address_book_contacts(id) ON DELETE CASCADE,
        FOREIGN KEY(item_id) REFERENCES address_book_contacts_items(id) ON DELETE CASCADE,
        UNIQUE(contacts_id, item_id)
    )');
    $pdo->exec('INSERT INTO address_book_contacts_contact_v2
        (contacts_id, item_id, contact_item_value, updated_by_user_id, last_updated)
        SELECT source.contacts_id, source.item_id, source.contact_item_value, source.updated_by_user_id, source.last_updated
        FROM address_book_contacts_contact AS source
        WHERE source.id = (
            SELECT duplicate.id
            FROM address_book_contacts_contact AS duplicate
            WHERE duplicate.contacts_id = source.contacts_id AND duplicate.item_id = source.item_id
            ORDER BY duplicate.last_updated DESC, duplicate.id DESC
            LIMIT 1
        )');

    /* Infer project assignments from existing task links without exposing unlinked contacts to every project. */
    $pdo->exec('CREATE TABLE address_book_contacts_project_has_contact (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        project_id INT NOT NULL,
        contacts_id INT NOT NULL,
        FOREIGN KEY(project_id) REFERENCES projects(id) ON DELETE CASCADE,
        FOREIGN KEY(contacts_id) REFERENCES address_book_contacts(id) ON DELETE CASCADE,
        UNIQUE(project_id, contacts_id)
    )');
    $pdo->exec('INSERT OR IGNORE INTO address_book_contacts_project_has_contact (project_id, contacts_id)
        SELECT DISTINCT tasks.project_id, links.contacts_id
        FROM address_book_contacts_task_has_contact AS links
        INNER JOIN tasks ON tasks.id = links.task_id
        INNER JOIN address_book_contacts ON address_book_contacts.id = links.contacts_id');

    /* Rebuild task links against the stable contact identity and remove duplicate legacy links. */
    $pdo->exec('CREATE TABLE address_book_contacts_task_has_contact_v2 (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        task_id INT NOT NULL,
        contacts_id INT NOT NULL,
        FOREIGN KEY(task_id) REFERENCES tasks(id) ON DELETE CASCADE,
        FOREIGN KEY(contacts_id) REFERENCES address_book_contacts(id) ON DELETE CASCADE,
        UNIQUE(task_id, contacts_id)
    )');
    $pdo->exec('INSERT OR IGNORE INTO address_book_contacts_task_has_contact_v2 (task_id, contacts_id)
        SELECT links.task_id, links.contacts_id
        FROM address_book_contacts_task_has_contact AS links
        INNER JOIN tasks ON tasks.id = links.task_id
        INNER JOIN address_book_contacts ON address_book_contacts.id = links.contacts_id');

    $pdo->exec('DROP TABLE address_book_contacts_task_has_contact');
    $pdo->exec('DROP TABLE address_book_contacts_contact');
    $pdo->exec('ALTER TABLE address_book_contacts_contact_v2 RENAME TO address_book_contacts_contact');
    $pdo->exec('ALTER TABLE address_book_contacts_task_has_contact_v2 RENAME TO address_book_contacts_task_has_contact');
}
