<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




$config['mongo_db']['active'] = 'default';
$config['mongo_db']['default']['no_auth'] = false;
$config['mongo_db']['default']['hostname'] = hostname;
$config['mongo_db']['default']['port'] = port;
$config['mongo_db']['default']['username'] = username;
$config['mongo_db']['default']['password'] = password;
$config['mongo_db']['default']['database'] = database;
$config['mongo_db']['default']['db_debug'] = TRUE;
$config['mongo_db']['default']['return_as'] = 'array';
$config['mongo_db']['default']['write_concerns'] = (int) 1;
$config['mongo_db']['default']['journal'] = TRUE;
$config['mongo_db']['default']['read_preference'] = NULL;
$config['mongo_db']['default']['read_preference_tags'] = NULL;

