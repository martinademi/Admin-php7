<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * CodeIgniter MongoDB Active Record Library
 *
 * A library to interface with the NoSQL database MongoDB. For more information see http://www.mongodb.org
 *
 * @package CodeIgniter
 * @author Intekhab Rizvi | www.intekhab.in | me@intekhab.in
 * @copyright Copyright (c) 2014, Intekhab Rizvi.
 * @license http://www.opensource.org/licenses/mit-license.php
 * @link http://intekhab.in
 * @version Version 1.0
 * Thanks to Alex Bilbie (http://alexbilbie.com) for help.
 */
require 'vendor/autoload.php'; // include Composer's autoloader

Class Mongo_db_php7 {

    private $CI;
    private $config = array();
    private $param = array();
    private $activate;
    private $connect;
    private $db;
    private $hostname;
    private $port;
    private $database;
    private $username;
    private $password;
    private $debug;
    private $write_concerns;
    private $journal;
    private $selects = array();
    private $updates = array();
    private $wheres = array();
    private $limit = 999999;
    private $offset = 0;
    private $sorts = array();
    private $return_as = 'array';
    public $benchmark = array();

    /**
     * --------------------------------------------------------------------------------
     * Class Constructor
     * --------------------------------------------------------------------------------
     *
     * Automatically check if the Mongo PECL extension has been installed/enabled.
     * Get Access to all CodeIgniter available resources.
     * Load mongodb config file from application/config folder.
     * Prepare the connection variables and establish a connection to the MongoDB.
     * Try to connect on MongoDB server.
     */
    function __construct() {
        $username = 'Dayrunner';
        $password = 'ShmdeUGtdbwg5esN';
        $client = new MongoDB\Client("mongodb://Dayrunner:ShmdeUGtdbwg5esN@localhost:27017/Dayrunner");
        $this->db = $client->Dayrunner;
      
        }
    

    
    
    
    
    public function DbOperations($action,$collection,$data=array(),$condition=array())
    {
        switch ($action) {
                         
        case "insert":
        $this->db->$collection->insertOne($data);
        break;
    
        
        case "retrieve":
        $document = $this->db->$collection->find();
        return $document;
        break;
        
        case "update":
        $update_result = $this->db->$collection->updateMany($data,['$set' => $condition]);
        break;
        
        case "delete":
        $delete_result = $this->db->$collection->deleteOne($data);
        break;
    
        case "get":
        $document = $this->db->$collection->findOne($data);
        return $document;
        break;
        } 
        
    }
    

}
