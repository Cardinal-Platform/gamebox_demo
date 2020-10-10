<?php
// Load config
require_once('config.php');

// Init database
require_once('database.php');

// Init router
require_once('router.php');

// Checker router
require_once('checker.php');

// Router table
Router::GET('/', 'Main/index');
Router::GET('/add', 'Main/add');
Router::POST('/add', 'Main/addAction');
Router::GET('/edit', 'Main/edit');
Router::POST('/edit', 'Main/editAction');
Router::GET('/delete', 'Main/delete');
Router::POST('/delete', 'Main/deleteAction');

// Link start!
new Router();