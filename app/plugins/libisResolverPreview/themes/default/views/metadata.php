<?php




$arr_ies = file("app/plugins/libisResolverPreview/themes/default/views/metadata.txt");



foreach ($arr_ies as $k=>$v) {
	$v=trim($v);
	try {
		$metadata = file_get_contents("https://resolver.libis.be/".$v."/metadata");
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}

	$obj = json_decode($metadata);
	if(isset($obj->$v->title)){
		printf("%s;%s<br>",$v,$obj->$v->title);
	}
}
