<?php

	require_once '/var/www/html/qa-include/qa-base.php';

	//require_once QA_INCLUDE_DIR.'qa-app-users.php';
	require_once QA_INCLUDE_DIR.'qa-app-posts.php';

 	

//Lee el fichero en una variable y convierte su contenido a una estructura de datos
$str_datos = file_get_contents("/home/alex/Escritorio/Ehutsi/resultadoEhutsi.json");
$datos = json_decode($str_datos,true);

$numUltimoPost = file_get_contents('/home/alex/Escritorio/Ehutsi/numUltimoPost.txt', true); //último post de última actualización 

unlink('/home/alex/Escritorio/Ehutsi/numUltimoPost.txt');		//elimina el fichero para que no se encadenen los datos

$num = $numUltimoPost;


foreach($datos as $doc){

        $pregunta = $doc['results'][0]['galdera'];
        $respuesta = $doc['results'][0]['erantzuna'];

	$elementosRespuesta = count($respuesta);

	if ($elementosRespuesta > 1){
		$respuesta = implode(" ", $respuesta);
	}
	

	$numeroPostConSignos = filter_var($pregunta, FILTER_SANITIZE_NUMBER_INT);
	$numeroPost = str_replace(array('+','-'), '', $numeroPostConSignos);


	if((int)$numeroPost > (int)$numUltimoPost){

	//galdera
	$type= 'Q';	//question
	$parentid= null;	//does not follow another answer
	$title= substr($pregunta,0,50)."...";	//primeros 50 caracteres de la pregunta
	$content= $pregunta;
	$format= '';	//plain text
	$categoryid= null;	//assume no category
	$tags= '';
	$userid=  6;

	$postId = qa_post_create($type, $parentid, $title, $content, $format, $categoryid, $tags, $userid);
	
	//erantzuna
	$type= 'A';	//answer
	$parentid= $postId;
	$title= null;
	$content= $respuesta;

	qa_post_create($type, $parentid, $title, $content, $format, $categoryid, $tags, $userid);

	if ($numeroPost > $num){	//guarda el numero del post mas reciente entre los nuevos post
		$num = $numeroPost;
	}

	}
}

$fp = fopen('/home/alex/Escritorio/Ehutsi/numUltimoPost.txt', 'w');		//creación de txt con numero del ultimo post
fwrite($fp, $num);
fclose($fp);
