
<div id="resolver" width='500'>



<?php
/*
require_once(__CA_LIB_DIR__ . "/Configuration.php");
require_once(__CA_LIB_DIR__ . "/Datamodel.php");
require_once(__CA_LIB_DIR__ . "/Db.php");

*/
require_once(__CA_LIB_DIR__."/Search/ObjectRepresentationSearch.php");
require_once(__CA_MODELS_DIR__."/ca_object_representations.php");


function url_exists($url) {
	return curl_init($url) !== false;
}


function is_complete($img_url,$link){

	$resource = imagecreatefromjpeg($img_url);

	if($resource===false) $resource = imagecreatefrompng($img_url);
	if($resource===false){
		//echo "no img $img_url ($link)<br>";
		return false;
	}



	$width = imagesx($resource);
	$height = imagesy($resource);

	$color = imagecolorat($resource, $width-1, $height-1);
	$erronuous=0;

	for($y = 1; $y <= 50; $y++) {
		// pixel color at (x, y)
		$color = imagecolorat($resource, $width-$y, $height-1);
		if($color==8421504)$erronuous++;

	}

	unset($resource);
	return $erronuous/50;
}


echo "<h1>Health Images</h1><br> start: ".date("H:i:s")."<br><br>";



$represenation_search = new ObjectRepresentationSearch();
$representations = $represenation_search->search("*");
set_time_limit(0);

$limit=" LIMIT 0";
if(isset($_GET['start']))$limit=" LIMIT ".$_GET['start'];
if(isset($_GET['limit']))$limit.=",".$_GET['limit'];

$db = new Db();
$feedback="";
$qr_res = $db->query("SELECT representation_id FROM ca_object_representations".$limit);
$representation_ids = $qr_res->getAllFieldValues('representation_id');

$rep_i=0;


//foreach ($representation_ids as $k=>$id){
for($inti=0;$inti<count($representation_ids);$inti++){


	$id = $representation_ids[$inti];
	$representation = new ca_object_representations((int) $id);


	$path_tiny = $representation->getMediaPath('media', 'tiny');
	$representation_link = "<a href='".$this->request->getBaseUrlPath()."/index.php/editor/object_representations/ObjectRepresentationEditor/Edit/representation_id/".$id."'>".$id."</a>";


	//if(url_exists($path_tiny)){
	if(file_exists($path_tiny)){
		$path = $representation->getMediaPath('media', 'medium');
		$result = is_complete($path,$representation_link);

		if($result>0.66){
			$rep_i++;
			echo $representation->get('idno').",".$representation_link.",corrupt<br>";
		}
	}
	else{
		////echo "could not find image for ".$representation_link."<br>";
		if(isset($_GET['show_no_media']))echo $representation->get('idno').",".$representation_link.",no media<br>";
	}


	//flush();
	//ob_flush();
}




echo "<br>finished: ".date("H:i:s").", $rep_i problems<br>";

?>



</div>
