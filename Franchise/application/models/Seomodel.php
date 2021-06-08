<?php

class Seomodel extends CI_Model {

    function __construct() {

        parent::__construct();
        $this->load->model('Commanmodel');
        $this->load->library('mongo_db');
        //$this->load->library('Mongodb') or die("unable to load");
    }

    function ConnectToDb() {
        $db_Connect = new MongoClient('mongodb://InstacartdbAdmin:WMdoenrkfHDKrmgil@localhost:27017/Instacart') or die("Connection failed");
        $db_Name = $db_Connect->Instacart;

        return $db_Name;
    }

    function getPageData($pageName = '') {
        $where = array("pageName" => $pageName);
        $pageData = $this->mongo_db->get_one("seoStaticPage", $where);
        return $pageData;
    }

    function updatePageData($pageName = '') {
        $keyword = $this->input->post('seoKeyword');
        $setArray = array("seoTitle" => $this->input->post('seoTitle'), "seoDescription" => $this->input->post('seoDescription'), "seoKeyword" => $keyword);
        $this->mongo_db->update("seoStaticPage", $setArray, array('pageName' => $pageName));
        echo json_encode(1);
        return;
    }

    function updateSocialMedia($pageName = '', $social = '') {
        if ($social == "facebook") {
            $keyword = $this->input->post('seoKeyword');
            $setArray = array("seoFacebookImageUrl" => $this->input->post('seoFacebookImageUrl'), "seoFacebookAlt" => $this->input->post('seoFacebookAlt'), "seoFacebookTitle" => $this->input->post('seoTitle'), "seoFacebookDescription" => $this->input->post('seoDescription'), "seoFacebookKeyword" => $keyword);
            $this->mongo_db->update("seoStaticPage", $setArray, array('pageName' => $pageName));
            echo json_encode(1);
            return;
        } else {
            $keyword = $this->input->post('seoKeyword');
            $setArray = array("seoTwitterImageUrl" => $this->input->post('seoTwitterImageUrl'), "seoTwitterAlt" => $this->input->post('seoTwitterAlt'), "seoTwitterTitle" => $this->input->post('seoTitle'), "seoTwitterDescription" => $this->input->post('seoDescription'), "seoTwitterKeyword" => $keyword);
            $this->mongo_db->update("seoStaticPage", $setArray, array('pageName' => $pageName));
            echo json_encode(1);
            return;
        }
    }

    function getStoreSeoData($id = '') {
        $pageData = $this->mongo_db->get_one("ProviderData",array('_id' => new MongoId($id)));
        $sendData = array('ImageUrl' => $pageData['ImageUrl'], 'CoverImageUrl' => $pageData['CoverImageUrl'], 'seoTitle' => $pageData['seoTitle'] ? $pageData['seoTitle'] : " ", 'seoDescription' => $pageData['seoDescription'] ? $pageData['seoDescription'] : " ", 'seoKeyword' => $pageData['seoKeyword'] ? $pageData['seoKeyword'] : array(), 'seoCoverAlt' => $pageData['seoProfileAlt'] ? $pageData['seoProfileAlt'] : " ", 'seoAltBanner' => $pageData['seoCoverAlt'] ? $pageData['seoCoverAlt'] : " ");
        return $sendData;
    }

    function updateSeoStoreData($id = '') {
        $setArray = array('seoCoverAlt' => $this->input->post('seoCoverAlt'), 'seoProfileAlt' => $this->input->post('seoProfileAlt'), "seoTitle" => $this->input->post('seoTitle'), "seoDescription" => $this->input->post('seoDescription'), "seoKeyword" => $this->input->post('seoKeyword'));
        $return = $this->mongo_db->update("ProviderData", $setArray, array('_id' => new MongoId($id)));
        echo json_encode(1);
        return;
    }

    public function sitemapGetData() {
//        $this->load->model('shopadminmodel');
//        $this->shopadminmodel->ItemKeyUpdate();
        $data = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/../xml/sitemap.xml");
        $oXML = new SimpleXMLElement($data);
        $node = $oXML->children();
        return htmlentities($data);
    }

    public function updateSitemap() {
        $xml = $this->input->post('sitemap');
        $path = "https://sitemap.xml";
        $curl = curl_init();
        $fp = fopen($path, "w");
        //w+ will not download any information from the url - file is created but empty.
        //AS IS, downloads first 334KB of file then lands on a blank page
        //and a 500 error when any of these other options are implemented. 
        curl_setopt($curl, CURLOPT_URL, 'https://www.url.com');
        curl_setopt($curl, CURLOPT_FILE, $fp);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        //  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //  curl_setopt($curl, CURLOPT_TIMEOUT,  300);
        //  curl_setopt($curl, CURLOPT_NOPROGRESS, false);
        //  curl_setopt($curl, CURLOPT_RANGE, '0-1000');
        //  $data = array();
        $data = curl_exec($curl);

        fwrite($fp, $data);

        curl_close($curl);
        fclose($fp);
        echo json_encode(1);
        return;
    }

    public function addContentSitemap($url, $urlxml) {
        date_default_timezone_set('UTC');
        header("Content-type: text/html; charset=utf-8");
//       print_r($urlxml); 
        $xml = simplexml_load_file($urlxml);
        $result = $xml->addchild('url');
        $result->addChild("loc", seoLink. $url);
        $result->addChild('lastmod', date("Y-m-d H:m:s"));
        $xml->asXml($urlxml);
    }

    public function removeContentSitemap($url, $xmlfile) {
        date_default_timezone_set('UTC');
        $xmlstr = file_get_contents("$xmlfile");
        $xml = new SimpleXMLElement($xmlstr);
        $count = 0;
        foreach ($xml as $user) {
            if ($user->loc == seoLink. $url) {
                unset($xml->url[$count]);
                break;
            }
            $count++;
        }
        $handle = fopen("$xmlfile", "w");
        fwrite($handle, $xml->asXML());
        fclose($handle);
    }

    public function createXmlFile($fileName = '') {
     
        date_default_timezone_set('UTC');
        $xmlString = '<?xml version="1.0" encoding="UTF-8"?>
                        <urlset 
                            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
                            xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
                            xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" 
                            xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
                            <url>
                                <loc>'.seoLink.'</loc>
                                <lastmod>' . date("Y-m-d H:m:s") . '</lastmod>
                            </url>
                        </urlset>';
        $dom = new DOMDocument;
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlString);
        // $dom->save($_SERVER["DOCUMENT_ROOT"] . "/../xml/" . $fileName . ".xml");
        // $urlxml = $_SERVER["DOCUMENT_ROOT"] . "/../xml/sitemap.xml";

        $dom->save(dirname(__DIR__)."/../../../xml/" . $fileName . ".xml");
        $urlxml = "/var/www/html/Admin/xml/sitemap.xml";

        $xml = simplexml_load_file($urlxml);
        $result = $xml->addchild('sitemap');
        $result->addChild("loc", seoLink. "/xml/" . $fileName . ".xml");
        $result->addChild('lastmod', date("Y-m-d H:m:s"));
        if ($xml->asXml($urlxml)) {
            return "success";
        } else {
            echo $xml->asXml($urlxml);
        }
    }

}

?>
