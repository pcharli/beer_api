<?php
//print_r($_REQUEST);
require("header.php");

 if (!empty($_GET['id_styles'])) : 
    $sql = sprintf("SELECT * FROM styles LEFT JOIN beers ON beers.id_styles = styles.id_styles WHERE styles.id_styles = %s",
        $_GET['id_styles']);
$message = "Beer of style ".$_GET['id_styles'];
else : 
    $sql = sprintf("SELECT * FROM styles ORDER BY style");
$message = "Styles list";
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