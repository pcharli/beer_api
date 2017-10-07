<?php
//print_r($_REQUEST);
require("header.php");

switch($_SERVER['REQUEST_METHOD']) : 

    case "POST" : 
    	if (isset($_GET['id_breweries']) AND !isset($_POST['id_breweries'])) :
    		$_POST['id_breweries'] = $_GET['id_breweries'];
    	endif; 
        $datas = $_POST;
        $sql = sprintf("INSERT INTO breweries SET name_brewery = '%s', address='%s', city = '%s', state = '%s', country = '%s', gps = '%s', web = '%s'",
        addslashes($datas['name_brewery']),
        addslashes($datas['address']),
        addslashes($datas['city']),
        addslashes($datas['state']),
        $datas['country'],
        $datas['gps'],
        $datas['web']
    );
    $connect->query($sql);
    $the_id = $connect->insert_id;
    $message = ($connect->error != '') ? $connect->error : array("action" => "Brewery insert", "insert_id" => $the_id);
    return_json(true,$message,"");
    break;

    case "PUT" : 
        parse_str(file_get_contents('php://input'), $datas);
        //print_r($datas);  
        if (isset($_GET['id_breweries']) AND !isset($datas['id_breweries'])) :
    		$datas['id_breweries'] = $_GET['id_breweries'];
    	endif;   
       $sql = sprintf("UPDATE breweries SET name_brewery = '%s', address='%s', city = '%s', state = '%s', country = '%s', gps = '%s', web = '%s' WHERE id_breweries = %s",
        addslashes($datas['name_brewery']),
        addslashes($datas['address']),
        addslashes($datas['city']),
        addslashes($datas['state']),
        $datas['country'],
        $datas['gps'],
        $datas['web'],
        $datas['id_breweries']
    );
    $connect->query($sql);
    $the_id = $datas['id_breweries'];
    $message = ($connect->error != '') ? $connect->error : array("action" => "Brewery update", "edit_id" => $the_id);
    return_json(true,$message,"");
    break;

    case "DELETE" :
        parse_str(file_get_contents('php://input'), $datas);
        //print_r($datas);
        if (isset($_GET['id_breweries']) AND !isset($datas['id_breweries'])) :
    		$datas['id_breweries'] = $_GET['id_breweries'];
    	endif;
        $sql = $sql = sprintf("DELETE FROM breweries WHERE id_breweries = %s",$datas['id_breweries']);
    $connect->query($sql);
    $the_id = $datas['id_breweries'];
    $message = ($connect->error != '') ? $connect->error : array("action" => "Brewery delete", "delete_id" => $the_id);
    return_json(true,$message,"");
    break;

    default :

 if (!empty($_GET['id_breweries'])) : 
    $sql = sprintf("SELECT * FROM breweries LEFT JOIN beers ON beers.id_breweries = breweries.id_breweries WHERE breweries.id_breweries = %s",
        $_GET['id_breweries']);
	$message = "Beers of brewery ".$_GET['id_breweries'];
else : 
    $sql = sprintf("SELECT * FROM breweries ORDER BY name_brewery");
	$message = "Breweries list";
endif;

$requete = $connect->query($sql);
echo $connect->error;

$resultats = Array();
while( $row = $requete->fetch_object() ) :
    $resultats[] = $row;
endwhile;
    $retour['nb'] = count($resultats);
$retour['feed'] = $resultats;
//print_r($resultats);
return_json(true,$message,$retour);

endswitch;
?>