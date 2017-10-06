<?php
include("header.php");
print_r($_SERVER['REQUEST_METHOD']);
//exit;

//print_r($_PUT);

switch($_SERVER['REQUEST_METHOD']) : 
    case "POST" : 
        $data = $_POST;
    break;
    case "PUT" : 
        parse_str(file_get_contents('php://input'), $datas);
        //print_r($datas);    
        echo sprintf("UPDATE beers SET name_beer = '%s', description='%s', id_breweries = '%s', id_categories = '%s', id_styles = '%s', alcool = '%s', ibu = '%s', srm = '%s', upc = '%s', last_mod = '%s' WHERE id_beers = %s",
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
    break;
    case "DELETE" :
        parse_str(file_get_contents('php://input'), $datas);
        //print_r($datas);
        $sql = sprintf("DELETE FROM beers WHERE id_beers = %s",$datas['id_beers']);
    break;
endswitch;
    echo $sql;
    $connect->query($sql);
    echo $connect->error;
exit;

?>