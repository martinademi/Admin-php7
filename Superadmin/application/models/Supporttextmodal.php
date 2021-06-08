<?php
if (!defined("BASEPATH"))
  exit("Direct access to this page is not allowed");

class Supporttextmodal extends CI_Model {

  public function __construct() {
    parent::__construct();
    $this->load->database();
     $this->load->library('mongo_db');
  }
  
  function viewDescription($id ='',$subid ='')
  {
      $result = $this->mongo_db->get_where('support_txt',array('_id'=>new MongoDB\BSON\ObjectID($id)));
      if(!empty($result['sub_cat']))
      {
         $res = $this->mongo_db->get_where('support_txt',array('sub_cat.id'=> new MongoDB\BSON\ObjectID($subid))); 
      }
      else
      {
         $res = $result;
      }
      
      return $res;
  }

  
}
?>
