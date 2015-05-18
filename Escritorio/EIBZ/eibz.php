<?php

	require_once '/var/www/html/qa-include/qa-base.php';

	//require_once QA_INCLUDE_DIR.'qa-app-users.php';
	require_once QA_INCLUDE_DIR.'qa-app-posts.php';

 	

//Lee el fichero en una variable y convierte su contenido a una estructura de datos
$str_datos = file_get_contents("/home/alex/Escritorio/EIBZ/resultadoEIBZ.json");
$datos = json_decode($str_datos,true);

//Cogemos fecha actual y le quitamos los dias desde la ultima actualizacion
$Date=Date('Y/m/d', strtotime("-7 days"));

foreach($datos as $doc){

        $titulo = $doc['results'][0]['izenburua'];
        $contenido = $doc['results'][0]['edukia'];
	$dataPregunta = $doc['results'][0]['data'];

	$split = explode('Erantzuna', $edukia, 2);	

	$pregunta = $split[0];
	$respuesta = $split[1];

	if($dataPregunta != NULL and $dataPregunta > $Date){

	//galdera
	$type= 'Q';	//question
	$parentid= null;	//does not follow another answer
	$title= $titulo;
	$content= $pregunta;
	$format= '';	//plain text
	$categoryid= null;	//assume no category
	$tags= '';
	$userid=  4;

	$postId = qa_post_create($type, $parentid, $title, $content, $format, $categoryid, $tags, $userid);
	
	//erantzuna
	$type= 'A';	//answer
	$parentid= $postId;
	$title= null;
	$content= $respuesta;

	qa_post_create($type, $parentid, $title, $content, $format, $categoryid, $tags, $userid);

	}
}
