<?php
//print_r($_REQUEST);
require("header.php");
    $sql = sprintf("SELECT * FROM beers ORDER BY name_beer LIMIT 3270, 10");


$requete = $connect->query($sql);
echo $connect->error;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
<ol>
<?php
$resultats = Array();
while( $row = $requete->fetch_object() ) :
	$url = "https://api.untappd.com/v4/search/beer?";
	$options = array(
		"q" => urlencode($row->name_beer),
		"client_id" => "4520C332CE215FA19BD2322EE6DA1285F3F47CCD",
		"client_secret" => "7D86CD24ADDE1DD89E85CBE44F53DCBE17959374");
	$url .= http_build_query($options);
	//print_r($url);
    $api = file_get_contents($url);
	$api = json_decode($api);
	if (isset($api->response->found) && $api->response->found > 0) :
	$apiObject = $api->response->beers->items[0]->beer;
	$id = $row->id_beers;
	$sql = sprintf("UPDATE beers SET ibu = '%s', alcool = '%s', images = '%s' WHERE id_beers = %s",
		$apiObject->beer_ibu,
		$apiObject->beer_abv,
		$apiObject->beer_label,
		$id);
	$connect->query($sql); 
	echo $connect->error;
	echo "<li>".$sql."</li>";
	else : echo "<li>erreur</li>";
	endif;
	//exit;
endwhile;

?>

	
</body>
</html>