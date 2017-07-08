<?php

//Change host name, database type, database, username, password
require "Database.php";

Database::setUp(array(
    'dsn' => 'mysql:host=localhost;dbname=bookhive;',
    'username' => 'root',
    'password' => ''
));


//Database::setUp(array(
//    'dsn' => 'mysql:host=localhost;dbname=bookhive_main;',
//    'username' => 'bookhive_rcadmin',
//    'password' => '#rcadmin@1234'
//));
