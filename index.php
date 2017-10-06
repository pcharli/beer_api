<?php
//print_r($_REQUEST);
require("header.php");

switch($_SERVER['REQUEST_METHOD']) : 

    case "POST" : 
        $datas = $_POST;
        echo $sql = sprintf("INSERT INTO beers SET name_beer = '%s', description='%s', id_breweries = '%s', id_categories = '%s', id_styles = '%s', alcool = '%s', ibu = '%s', srm = '%s', upc = '%s', last_mod = '%s'",
        addslashes($datas['name_beer']),
        addslashes($datas['description']),
        $datas['id_breweries'],
        $datas['id_categories'],
        $datas['id_styles'],
        $datas['alcool'],
        $datas['ibu'],
        $datas['srm'],
        $datas['upc'],
        date("Y-m-d")
    );
    $connect->query($sql);
    $the_id = $connect->insert_id;
    $message = ($connect->error != '') ? $connect->error : array("action" => "Beer insert", "insert_id" => $the_id);
    return_json(true,$message,"");
    break;

    case "PUT" : 
        parse_str(file_get_contents('php://input'), $datas);
        //print_r($datas);    
        echo $sql = sprintf("UPDATE beers SET name_beer = '%s', description='%s', id_breweries = '%s', id_categories = '%s', id_styles = '%s', alcool = '%s', ibu = '%s', srm = '%s', upc = '%s', last_mod = '%s' WHERE id_beers = %s",
        addslashes($datas['name_beer']),
        addslashes($datas['description']),
        $datas['id_breweries'],
        $datas['id_categories'],
        $datas['id_styles'],
        $datas['alcool'],
        $datas['ibu'],
        $datas['srm'],
        $datas['upc'],
        date("Y-m-d"),
        $datas['id_beers']
    );
    $connect->query($sql);
    $the_id = $datas['id_beers'];
    $message = ($connect->error != '') ? $connect->error : array("action" => "Beer update", "edit_id" => $the_id);
    return_json(true,$message,"");
    break;

    case "DELETE" :
        parse_str(file_get_contents('php://input'), $datas);
        //print_r($datas);
        $sql = $sql = sprintf("DELETE FROM beers WHERE id_beers = %s",$datas['id_beers']);
    $connect->query($sql);
    $the_id = $datas['id_beers'];
    $message = ($connect->error != '') ? $connect->error : array("action" => "Beer delete", "delete_id" => $the_id);
    return_json(true,$message,"");
    break;

    default :

	 if (!empty($_GET['id_beers'])) : 
	    $sql = sprintf("SELECT * FROM beers WHERE id_beers = %s",
	        $_GET['id_beers']);
		$message = "Beer infos";
	else : 
	    if(!empty($_GET['start'])) :
	    	$sql = sprintf("SELECT * FROM beers ORDER BY name_beer LIMIT %s, 10", $_GET['start']);
	    else : 
	    	$sql = sprintf("SELECT * FROM beers ORDER BY name_beer");
		endif;
		$message = "Beers list";
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