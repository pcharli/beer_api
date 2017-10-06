<?php 
require("header.php");

if( !empty($_POST['name']) && !empty($_POST['id_categories']) && !empty($_POST['id_styles']) ) :
 
    $sql=sprintf("INSERT INTO beers SET name_beer = '%s', id_breweries = '%s', id_categories = '%s', id_styles = '%s', alcool = '%s', ibu = '%s', srm = '%s', upc = '%s', last_mod = '%s'",
    $_POST['name'],
    $_POST['id_breweries'],
    $_POST['id_categories'],
    $_POST['id_styles'],
    $_POST['alcool'],
    $_POST['ibu'],
    $_POST['srm'],
    $_POST['upc'],
    date("Y-m-d"));
    $query = $connect->query($sql);
    echo $connect->error;
    $last_id = $query->insert_id;
    
    
    return_json(true,"La bière a été ajoutée");
else : 
    return_json(true,"Il manque des infos");
endif;

?>