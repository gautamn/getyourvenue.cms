<?php
//details of database connection, web path, memcache and other installation specific settings

ini_set('display_errors',0);

/**
* Configure as many database connections needed for facile,
* since facile supports simulteneous connection to multiple DB clusters
*/

/* DB1[Primary] - Master DB Connection */
$DSN[0]['w']['host'] = 'db428851191.db.1and1.com';
$DSN[0]['w']['user'] = 'dbo428851191';
$DSN[0]['w']['password'] = 'password';
$DSN[0]['w']['db'] = 'db428851191';
/* DB1[Primary] - Slave DB Connection */
$DSN[0]['r']['host'] = 'db428851191.db.1and1.com';
$DSN[0]['r']['user'] = 'dbo428851191';
$DSN[0]['r']['password'] = 'password';
$DSN[0]['r']['db'] = 'db428851191';

/* Web URL params */
$web_url = 'http://cms.getyourvenue.com/webdocs/';
$web_static_url = 'http://cms.getyourvenue.com/';
$web_url_ui = 'http://getyourvenue.com/';

/**
* filesystem path for templates and frames
*/
$path = dirname(__file__) . '/../';

ini_set('display_errors','On');
error_reporting(E_ALL);