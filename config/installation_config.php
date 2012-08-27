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

/* DB2[Primary] - Master DB Connection */
$DSN[1]['w']['host'] = 'localhost';
$DSN[1]['w']['user'] = 'root';
$DSN[1]['w']['password'] = '';
$DSN[1]['w']['db'] = 'db418924494';
/* DB1[Primary] - Slave DB Connection */
$DSN[1]['r']['host'] = 'localhost';
$DSN[1]['r']['user'] = 'root';
$DSN[1]['r']['password'] = '';
$DSN[1]['r']['db'] = 'db418924494';


/* Web URL params */
$web_url = 'http://localhost/gyvcmsdemo/webdocs/';
$web_static_url = 'http://localhost/gyvcmsdemo/webdocs/';


/**
* filesystem path for templates and frames
*/
$path = dirname(__file__) . '/../';




/**
* memcache server details
*/



/**
* Solr server Details contains the installation details for all solr instances to be used for search, autocomplete and spellsuggest
*/

/* Solr details for autocomplete */
$FACILE['solr'][0]['master'] = 'localhost';
$FACILE['solr'][0]['slave'] = 'localhost';
/* Solr details for spellsuggest */
$FACILE['solr'][0]['master'] = 'localhost';
$FACILE['solr'][0]['slave'] = 'localhost';
/* Solr details for search */
$FACILE['solr'][1]['master'] = 'localhost';
$FACILE['solr'][1]['slave'] = 'localhost';

$FACILE['solr'][0]['master'] = 'iplclips/dev_';

$web_url_ui = 'http://localhost/gyvcmsdemo/webdocs/';



ini_set('display_errors','on');
error_reporting(E_ALL);