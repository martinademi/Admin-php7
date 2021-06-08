<?php

/**
 * Description of ConDB
 *
 * @author admin@3embed
 */
//if ($_SESSION['lang'] == 'en') {
//    include '../Models/translations/translations_english.php';
//} else {
//    include '../Models/translations/translations_german.php';
//}
class ConDB {

//put your code here

    private $serverName = "localhost"; //serverName\instanceName
    private $userName = "root";
    private $pass = "f6cac633f5426db71";
    private $database = "Menuse";
    private $mongoDB = "Menuse";
    public $mongo;
    public $conn;
    public $flag_conn;
    public $con;

//    public $mongoDB;

    public function __construct() {
        $con = new Mongo("mongodb://localhost:27017");
        $con = $con->selectDB($this->mongoDB);
        $this->conn = $con->authenticate('Menuseadmin', 'rS6hHx9arsJ');
//        $this->mongo = $con->Menuse; //$this->MongoConnect($this->mongoDB, '104.131.174.235', '27017');
//        $this->conn = $this->mongo->authenticate('Menuseadmin', 'rS6hHx9arsJ');
    
//      print_r( $this->conn);
//         $this->conn = mysql_connect($this->serverName, $this->userName, $this->pass);
//        if ($con) {
//            if (mysql_select_db($this->database, $this->conn)) {
            if ($this->conn) {
//                mysql_query("SET NAMES 'utf8'");
//                mysql_query('SET CHARACTER SET utf8');
                $this->flag_conn = 0;
            } else {
                $this->flag_conn = 1;
                die(print_r(mysql_errors(), true));
            }
//        } else {
//            $this->flag_conn = 1;
//            die(print_r(mysql_error(), true));
//        }
    }

    public function MongoConnect($database, $host, $port) {
//          print_r($database);
//          print_r($host);
         try {
                $con = new Mongo("mongodb://{$host}:{$port}"); // Connect to Mongo Server
                    //select the mongodb database
                    $con = $con->selectDB($database);
               return $con->authenticate('Menuseadmin', 'rS6hHx9arsJ');
         } catch (Exception $ex){
              print_r($ex);
              return $ex;
         }
    }

    public function close($db) {
//            mysql_close($db);
    }

}

?>
