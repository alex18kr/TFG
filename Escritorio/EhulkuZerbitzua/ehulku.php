<?php

	require_once '/var/www/html/qa-include/qa-base.php';

	//require_once QA_INCLUDE_DIR.'qa-app-users.php';
	require_once QA_INCLUDE_DIR.'qa-app-posts.php';

 	

//Carga el fichero en una variable y convierte su contenido a una estructura de datos
$str_datos = file_get_contents("/home/alex/Escritorio/EhulkuZerbitzua/resultadoEhulku.json");
$datos = json_decode($str_datos,true);

$numUltimoPost = file_get_contents('/home/alex/Escritorio/EhulkuZerbitzua/numUltimoPost.txt', true); //último post de última actualización 

unlink('/home/alex/Escritorio/EhulkuZerbitzua/numUltimoPost.txt');		//elimina el fichero para que no se encadenen los datos

$num = $numUltimoPost;

//Recorremos los datos
foreach($datos as $doc){

        $pregunta = $doc['results'][0]['galdera'];

	if (array_key_exists('erantzuna', $doc['results'][0])) {		//comprueba que haya respuesta
    	$respuesta = $doc['results'][0]['erantzuna'];
	}
	else {
    	$respuesta = '';
	}

	$url = $doc['pageUrl'];
	
	$split = explode('=', $url, 2);	

	$numeroPost = $split[1];

	if((int)$numeroPost > (int)$numUltimoPost){
	
	//pregunta
	$type= 'Q';	//question
	$parentid= null;	//does not follow another answer
	$title= substr($pregunta,0,50)."...";	//primeros 50 caracteres de la pregunta
	$content= $pregunta;
	$format= '';	//plain text
	$categoryid= null;	//assume no category
	$tags= '';
	$userid=  5;	//ID del usuario

	$postId = qa_post_create($type, $parentid, $title, $content, $format, $categoryid, $tags, $userid);
	
	//respuesta
	$type= 'A';	//answer
	$parentid= $postId;
	$title= null;
	$content= $respuesta;

	qa_post_create($type, $parentid, $title, $content, $format, $categoryid, $tags, $userid);

	//guarda el número del post más reciente entre los nuevos post
	if ($numeroPost > $num){
		$num = $numeroPost;
	}

	}
}

//creación de txt con número del último post
$fp = fopen('/home/alex/Escritorio/EhulkuZerbitzua/numUltimoPost.txt', 'w');		
fwrite($fp, $num);
fclose($fp);
