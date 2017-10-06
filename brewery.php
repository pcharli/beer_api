<?php
//print_r($_REQUEST);
require("header.php");

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
return_json(true,$message,$retour)

?>