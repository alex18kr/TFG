<?php

	require_once '/var/www/html/qa-include/qa-base.php';

	//require_once QA_INCLUDE_DIR.'qa-app-users.php';
	require_once QA_INCLUDE_DIR.'qa-app-posts.php';

 	

//Carga el fichero en una variable y convierte su contenido a una estructura de datos
$str_datos = file_get_contents("/home/alex/Escritorio/EstiloLiburua/resultadoEstiloLiburua.json");
$datos = json_decode($str_datos,true);

//Cogemos fecha actual y le quitamos los días desde la última actualización
$Date=Date('Y-m-d H:i:s', strtotime("-7 days"));

//Recorremos los datos
foreach($datos as $doc){

        $pregunta = $doc['results'][0]['galdera'];
        $respuesta = $doc['results'][0]['erantzuna'];
	$dataPregunta = $doc['results'][0]['data'];
	
	//Insertamos solo los datos nuevos
	if($dataPregunta > $Date){

	//pregunta
	$type= 'Q';	//question
	$parentid= null;	//does not follow another answer
	$title= substr($pregunta,0,50)."...";	//primeros 50 caracteres de la pregunta
	$content= $pregunta;
	$format= '';	//plain text
	$categoryid= null;	//assume no category
	$tags= '';
	$userid=  3; //ID del usuario

	$postId = qa_post_create($type, $parentid, $title, $content, $format, $categoryid, $tags, $userid);
	
	//respuesta
	$type= 'A';	//answer
	$parentid= $postId;
	$title= null;
	$content= $respuesta;

	qa_post_create($type, $parentid, $title, $content, $format, $categoryid, $tags, $userid);

	}
}
