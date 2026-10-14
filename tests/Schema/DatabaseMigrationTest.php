<?php

/**
 * AddressBook database migration integration test.
 *
 * Related files: Schema/Sqlite.php, Schema/Mysql.php and Schema/Postgres.php.
 */

declare(strict_types=1);

$driver = getenv('ADDRESS_BOOK_TEST_DRIVER') ?: 'sqlite';
$dsn = getenv('ADDRESS_BOOK_TEST_DSN') ?: 'sqlite::memory:';
$username = getenv('ADDRESS_BOOK_TEST_USERNAME') ?: null;
$password = getenv('ADDRESS_BOOK_TEST_PASSWORD') ?: null;
$schemaFile = dirname(__DIR__, 2) . '/Schema/' . ucfirst($driver) . '.php';

if (! is_file($schemaFile)) {
    throw new RuntimeException('Unsupported database driver: ' . $driver);
}

$pdo = new PDO($dsn, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if ($driver === 'sqlite') {
    $pdo->exec('PRAGMA foreign_keys = OFF');
    $pdo->exec('CREATE TABLE projects (id INTEGER PRIMARY KEY)');
    $pdo->exec('CREATE TABLE tasks (id INTEGER PRIMARY KEY, project_id INTEGER NOT NULL)');
} elseif ($driver === 'mysql') {
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    $pdo->exec('DROP TABLE IF EXISTS address_book_contacts_project_has_contact, address_book_contacts_task_has_contact, address_book_contacts_contact, address_book_contacts, address_book_contacts_items, tasks, projects');
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    $pdo->exec('CREATE TABLE projects (id INT NOT NULL PRIMARY KEY) ENGINE=InnoDB');
    $pdo->exec('CREATE TABLE tasks (id INT NOT NULL PRIMARY KEY, project_id INT NOT NULL, FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE) ENGINE=InnoDB');
} else {
    $pdo->exec('DROP TABLE IF EXISTS address_book_contacts_project_has_contact, address_book_contacts_task_has_contact, address_book_contacts_contact, address_book_contacts, address_book_contacts_items, tasks, projects CASCADE');
    $pdo->exec('CREATE TABLE projects (id INT NOT NULL PRIMARY KEY)');
    $pdo->exec('CREATE TABLE tasks (id INT NOT NULL PRIMARY KEY, project_id INT NOT NULL REFERENCES projects(id) ON DELETE CASCADE)');
}

require $schemaFile;

$versionOne = '\\Kanboard\\Plugin\\AddressBook\\Schema\\version_1';
$versionTwo = '\\Kanboard\\Plugin\\AddressBook\\Schema\\version_2';
$versionOne($pdo);

$pdo->exec('INSERT INTO projects (id) VALUES (3)');
$pdo->exec('INSERT INTO tasks (id, project_id) VALUES (11, 3)');
$pdo->exec("INSERT INTO address_book_contacts_contact (contacts_id, item_id, contact_item_value, updated_by_user_id, last_updated) VALUES (7, 1, 'Alice', 1, 100)");
$pdo->exec('INSERT INTO address_book_contacts_task_has_contact (task_id, contacts_id) VALUES (11, 7)');

$pdo->exec("INSERT INTO address_book_contacts_contact (contacts_id, item_id, contact_item_value, updated_by_user_id, last_updated) VALUES (7, 1, 'Alice Smith', 2, 200)");

$versionTwo($pdo);

assertSame(1, countRows($pdo, 'address_book_contacts'), 'The contact identity was not migrated.');
assertSame(1, countRows($pdo, 'address_book_contacts_contact'), 'Duplicate legacy values were not normalised.');
assertSame(1, countRows($pdo, 'address_book_contacts_task_has_contact'), 'The task link was not migrated.');
assertSame(1, countRows($pdo, 'address_book_contacts_project_has_contact'), 'The project assignment was not inferred.');

$value = $pdo->query('SELECT contact_item_value FROM address_book_contacts_contact WHERE contacts_id = 7 AND item_id = 1')->fetchColumn();
assertSame('Alice Smith', $value, 'The latest contact value was not preserved.');

$pdo->exec("INSERT INTO address_book_contacts_items (item, item_type, property_set, position) VALUES ('Email', 'email', 'custom', 2)");
$pdo->exec("INSERT INTO address_book_contacts_contact (contacts_id, item_id, contact_item_value, updated_by_user_id, last_updated) VALUES (7, 2, 'alice@example.test', 2, 300)");

assertSame(2, countRows($pdo, 'address_book_contacts_contact'), 'The normalised schema did not allow multiple properties.');
assertConstraintRejectsDuplicate($pdo);

if ($driver === 'sqlite') {
    $pdo->exec('PRAGMA foreign_keys = ON');
    assertSame(0, count($pdo->query('PRAGMA foreign_key_check')->fetchAll()), 'SQLite reported a broken foreign key.');
}

echo 'AddressBook ' . $driver . ' migration test passed.' . PHP_EOL;

function countRows(PDO $pdo, string $table): int
{
    return (int) $pdo->query('SELECT COUNT(*) FROM ' . $table)->fetchColumn();
}

function assertSame($expected, $actual, string $message): void
{
    if ($expected !== $actual) {
        throw new RuntimeException($message . ' Expected ' . var_export($expected, true) . ', got ' . var_export($actual, true) . '.');
    }
}

function assertConstraintRejectsDuplicate(PDO $pdo): void
{
    try {
        $pdo->exec("INSERT INTO address_book_contacts_contact (contacts_id, item_id, contact_item_value, updated_by_user_id, last_updated) VALUES (7, 2, 'duplicate@example.test', 2, 400)");
    } catch (PDOException $exception) {
        return;
    }

    throw new RuntimeException('The unique contact-property constraint accepted a duplicate value.');
}
