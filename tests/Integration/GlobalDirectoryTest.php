<?php

/**
 * AddressBook global directory integration test.
 *
 * Related files: Plugin.php, Controller/ContactsController.php,
 * Controller/ContactsDirectoryController.php, Model/ContactsProjectModel.php
 * and Model/ContactsTaskModel.php.
 */

declare(strict_types=1);

$kanboardRoot = dirname(__DIR__, 4);

define('PLUGINS_DIR', $kanboardRoot . '/plugins');
define('DB_FILENAME', $kanboardRoot . '/data/addressbook-directory-test.sqlite');

require $kanboardRoot . '/app/common.php';

$container['pluginLoader']->getPlugins();

$project_id = $container['projectModel']->create(array('name' => 'AddressBook directory test'));
$contact_id = $container['contactsModel']->create(array('1_Name' => 'Alice Example'));

assertTrue($project_id > 0, 'The test project could not be created.');
assertTrue($contact_id > 0, 'The global contact could not be created.');
assertTrue($container['contactsProjectModel']->assignToProject($contact_id, $project_id), 'The contact could not be assigned to the project.');

$assigned = $container['contactsProjectModel']->getAllByProjectId($project_id);
assertSame(1, count($assigned), 'The project did not return its assigned contact.');
assertSame($contact_id, (int) $assigned[0]['contacts_id'], 'The project returned the wrong contact.');

$task_id = $container['taskCreationModel']->create(array(
    'project_id' => $project_id,
    'title' => 'Contact assignment test',
));

assertTrue($task_id > 0, 'The test task could not be created.');
assertTrue($container['contactsTaskModel']->addToTask($contact_id, $task_id), 'The assigned contact could not be linked to a task.');
assertTrue($container['contactsProjectModel']->removeFromProject($contact_id, $project_id), 'The contact could not be removed from the project.');
assertSame(0, count($container['contactsTaskModel']->getByTaskId($task_id)), 'Removing the project assignment left a task link behind.');
assertTrue($container['contactsModel']->exists($contact_id), 'Removing the project assignment deleted the global contact.');

assertTrue($container['applicationAuthorization']->isAllowed('ContactsDirectoryController', 'index', Kanboard\Core\Security\Role::APP_ADMIN), 'Administrators cannot access the global directory.');
assertFalse($container['applicationAuthorization']->isAllowed('ContactsDirectoryController', 'index', Kanboard\Core\Security\Role::APP_USER), 'Regular users can administer the global directory.');
assertTrue($container['projectAuthorization']->isAllowed('ContactsController', 'assignToProject', Kanboard\Core\Security\Role::PROJECT_MANAGER), 'Project managers cannot assign contacts.');
assertFalse($container['projectAuthorization']->isAllowed('ContactsController', 'assignToProject', Kanboard\Core\Security\Role::PROJECT_MEMBER), 'Project members can assign contacts.');
assertTrue($container['projectAuthorization']->isAllowed('ContactsController', 'addToTask', Kanboard\Core\Security\Role::PROJECT_MEMBER), 'Project members cannot link contacts to tasks.');
assertFalse($container['projectAuthorization']->isAllowed('ContactsController', 'addToTask', Kanboard\Core\Security\Role::PROJECT_VIEWER), 'Project viewers can link contacts to tasks.');

echo 'AddressBook global directory integration test passed.' . PHP_EOL;

function assertTrue(bool $actual, string $message): void
{
    if (! $actual) {
        throw new RuntimeException($message);
    }
}

function assertFalse(bool $actual, string $message): void
{
    assertTrue(! $actual, $message);
}

function assertSame($expected, $actual, string $message): void
{
    if ($expected !== $actual) {
        throw new RuntimeException($message . ' Expected ' . var_export($expected, true) . ', got ' . var_export($actual, true) . '.');
    }
}
