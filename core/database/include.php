<?php

//Change host name, database type, database, username, password
require "Database.php";

Database::setUp(array(
	'dsn' => 'mysql:host=localhost;dbname=bookhive_v0.9;',
	'username' => 'root',
	'password' => 'sogoni1608'

    ));


//Database::setUp(array(
//    'dsn' => 'mysql:host=localhost;dbname=bookhive_main;',
//    'username' => 'bookhive_rcadmin',
//    'password' => '#rcadmin@1234'
//));