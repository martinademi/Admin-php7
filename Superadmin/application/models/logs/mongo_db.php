<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



$config['mongo_db']['active'] = 'default';
$config['mongo_db']['default']['no_auth'] = false;

// $config['mongo_db']['default']['hostname'] = 'localhost';
// $config['mongo_db']['default']['port'] = '27017';
// $config['mongo_db']['default']['username'] = 'Instacartdblocal';
// $config['mongo_db']['default']['password'] = '3LsGUmRrWaneXL';
// $config['mongo_db']['default']['database'] = 'Instacart';





$config['mongo_db']['default']['hostname'] = '52.70.89.18';
$config['mongo_db']['default']['port'] = '27017';
$config['mongo_db']['default']['username'] = 'loopz';
$config['mongo_db']['default']['password'] = 'KDmTgv5tvMFyCvQK';
$config['mongo_db']['default']['database'] = 'loopz';
$config['mongo_db']['default']['db_debug'] = TRUE;
$config['mongo_db']['default']['return_as'] = 'array';
$config['mongo_db']['default']['write_concerns'] = (int) 1;
$config['mongo_db']['default']['journal'] = TRUE;
$config['mongo_db']['default']['read_preference'] = NULL;
$config['mongo_db']['default']['read_preference_tags'] = NULL;
