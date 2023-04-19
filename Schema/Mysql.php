<?php

namespace Kanboard\Plugin\AddressBook\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec('CREATE TABLE IF NOT EXISTS contacts_items (
        `id` INT NOT NULL AUTO_INCREMENT,
        `item` VARCHAR(30) NOT NULL,
        `position` INT NOT NULL,
        PRIMARY KEY(id)
    ) ENGINE=InnoDB CHARSET=utf8');

    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts_contact (
        `contacts_id` INT NOT NULL,
        `item_id` INT NOT NULL,
        `value` VARCHAR(60) NOT NULL,
        FOREIGN KEY(item_id) REFERENCES contacts_items(id) ON DELETE CASCADE,
        KEY(contacts_id)
    ) ENGINE=InnoDB CHARSET=utf8");

    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts_task_has_contact (
        `id` INT NOT NULL AUTO_INCREMENT,
        `task_id` INT NOT NULL,
        `contacts_id` INT NOT NULL,
        FOREIGN KEY(contacts_id) REFERENCES contacts_contact(contacts_id) ON DELETE CASCADE,
        FOREIGN KEY(task_id) REFERENCES tasks(id) ON DELETE CASCADE,
        PRIMARY KEY(id)
    ) ENGINE=InnoDB CHARSET=utf8");

    $pdo->exec('INSERT INTO `contacts_items`(`item`, `position`) VALUES ("Name", 1)');
    $pdo->exec('INSERT INTO `contacts_items`(`item`, `position`) VALUES ("Tel.", 2)');
}
