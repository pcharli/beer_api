<?php
//print_r($_REQUEST);
require("header.php");
    $sql = sprintf("SELECT * FROM beers ORDER BY id_beers LIMIT 890, 10");


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
	$url = "https://api.qwant.com/api/search/images/?";
	$options = array(
		"q" => "biere+".urlencode($row->name_beer)
		);
	$url .= http_build_query($options);

	$options = array(
    'http'=>array(
      'method'=>"GET",
      'header'=>"Accept-language: en\r\n" .
                "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/5.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad 
    )
  );
  
  $context = stream_context_create($options);
	print_r($url);
    $api = file_get_contents($url, false, $context);
    	//print_r($api);
    if(isset($api) AND $api != NULL) :
		$api = json_decode($api);
		$api = $api->data->result;
	endif;
	//print_r($api);
	
	echo $nbItems = count($api->items);
	if ( $nbItems > 0 ) :
	$sql = "UPDATE beers SET";
	$j = 1;
	for ($i=0; $i < $nbItems; $i++) :
		if ($j != 10) : 
		$sql .= sprintf(" image".$j." = '%s',",$api->items[$i]->media);
	else : $sql .= sprintf(" image".$j." = '%s'",$api->items[$i]->media);
	endif;
	$j++;
	endfor;
	$sql .= " WHERE id_beers = ".$row->id_beers;
	echo $sql;
	
	$connect->query($sql); 
	echo $connect->error;
	//echo "<li>".$sql."</li>";
	else : echo "<li>erreur</li>";
	endif;
	
	//exit;
endwhile;

?>
</body>
</html>