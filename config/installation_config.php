<?php
//details of database connection, web path, memcache and other installation specific settings

ini_set('display_errors',0);

/**
* Configure as many database connections needed for facile,
* since facile supports simulteneous connection to multiple DB clusters
*/

/* DB1[Primary] - Master DB Connection */
$DSN[0]['w']['host'] = 'localhost';
$DSN[0]['w']['user'] = 'root';
$DSN[0]['w']['password'] = '';
$DSN[0]['w']['db'] = 'db418924494';
/* DB1[Primary] - Slave DB Connection */
$DSN[0]['r']['host'] = 'localhost';
$DSN[0]['r']['user'] = 'root';
$DSN[0]['r']['password'] = '';
$DSN[0]['r']['db'] = 'db418924494';

/* Web URL params */
$web_url = 'http://localhost/gyvcmsdemo/webdocs/';
$web_static_url = 'http://localhost/gyvcmsdemo/webdocs/';


/**
* filesystem path for templates and frames
*/
$path = dirname(__file__) . '/../';

//ini_set('display_errors','On');
//error_reporting(E_ALL);