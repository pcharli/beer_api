<?php 
 if (!isset($_GET["alt"]) OR $_GET['alt'] != 'xml') : 
    header("Content-Type: application/json");
else :
    header("Content-type: text/xml");
endif;


@$connect = new mysqli('localhost','root', '', 'beers_api');
//var_dump($connect);
if($connect->connect_errno == 0) :
    $connect->set_charset("utf8");
else :

    return_json(false,"Connexion failed");
    exit;
endif;

function array2xml($array, $xml = false){
    
        if($xml === false){
            $xml = new SimpleXMLElement('<result/>');
        }
    
        foreach($array as $key => $value){
            //var_dump($key);
            if (is_numeric($key)) {
                $key = 'item_'.$key;
            }
            if(is_array($value)){
                array2xml($value, $xml->addChild($key));
            } 
            else {
                $xml->addChild($key, $value);
            }
        }
    
        return $xml->asXML();
    }

function return_json($success,$msg,$results=NULL) {
    $retour['success'] = $success;
    $retour["message"] = $msg;
    $retour['feed'] = $results;
    if (!isset($_GET["alt"]) OR $_GET['alt'] != 'xml') : 
    echo json_encode($retour, true);
    else :
        
        $array = json_decode(str_replace('&','&amp;',json_encode($retour)), true);
        //print_r($array);
        $xml = array2xml($array['feed']['feed'], false);
        echo $xml;
    endif;
}

