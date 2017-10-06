<?php
//print_r($_REQUEST);
require("header.php");

 if (!empty($_GET['id_categories'])) : 
 	if(!empty($_GET['start'])) :
 		$sql = sprintf("SELECT * FROM categories LEFT JOIN beers ON beers.id_categories = categories.id_categories WHERE categories.id_categories = %s LIMIT %s, 10",
        $_GET['id_categories'],
        $_GET['start']);
 	else :
    	$sql = sprintf("SELECT * FROM categories LEFT JOIN beers ON beers.id_categories = categories.id_categories WHERE categories.id_categories = %s",
        $_GET['id_categories']);
	endif;
	$message = "Beers of category ".$_GET['id_categories'];
else : 
    $sql = sprintf("SELECT * FROM categories ORDER BY categorie");
$message = "Categories list";
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
return_json(true,$message,$retour)

?>