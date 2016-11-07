<?php

define('BOT_TOKEN', '287099689:AAHEUsdjtrD2VN1vgWfJnXcq5TfSTrLLbUE');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
try {
		

	// recupero il contenuto inviato da Telegram
	$content = file_get_contents("php://input");
	// converto il contenuto da JSON ad array PHP
	$update = json_decode($content, true);
	// se la richiesta è null interrompo lo script
	if(!$update)
	{
	  exit;
	}
	// assegno alle seguenti variabili il contenuto ricevuto da Telegram
	$message = isset($update['message']) ? $update['message'] : "";
	$messageId = isset($message['message_id']) ? $message['message_id'] : "";
	$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
	$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
	$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
	$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
	$date = isset($message['date']) ? $message['date'] : "";
	$text = isset($message['text']) ? $message['text'] : "";
	$botUrl = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendPhoto";
	$giornodellasettimana = date("l");
	// pulisco il messaggio ricevuto togliendo eventuali spazi prima e dopo il testo
	$text = trim($text);
	// converto tutti i caratteri alfanumerici del messaggio in minuscolo
	$text = strtolower($text);
	// mi preparo a restitutire al chiamante la mia risposta che è un oggetto JSON
	// imposto l'header della risposta
	header("Content-Type: application/json");
	$response = '';
	//regual expression per decidere che risposta dare

	if (preg_match('/^buongiorno/', $text)) {
		
		$path = "settimana/".$giornodellasettimana."/".rand(0, 1).".jpg";
		
		// change image name and path
		$postFields = array('chat_id' => $chatId, 'photo' => new CURLFile(realpath($path)), 'caption' => "");
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
		curl_setopt($ch, CURLOPT_URL, $botUrl); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		// read curl response
		$output = curl_exec($ch);

		//se $giornodellasettimana e' 1 bisogna mandare foto del lunedi se e' martedi' foto del martedi' ecc...
	}elseif(preg_match('/politica/', $text)){
		$response = "E renzi ke faaa????";
	}elseif(preg_match('/salvini/', $text)){
		$response = "RUSPA!!";
	}elseif(preg_match('/falsa/', $text) or preg_match('/bugia/', $text) ){
		$response = "Perzona Farsa!!!1!1";
	}elseif(preg_match('/caffe/', $text)){
		$response = "Kaffeeeee!!!1!1";		
		$response = "settimana/".$giornodellasettimana."/".rand(0, 1).".jpg";
	}elseif(preg_match('/amen/', $text)){
		$postFields = array('chat_id' => $chatId, 'photo' => new CURLFile(realpath("arcangelo.jpg")), 'caption' => $response);
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
		curl_setopt($ch, CURLOPT_URL, $botUrl); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		// read curl response
		$output = curl_exec($ch);
	}else{
		//$response = "ELSE";
	}


	// la mia risposta è un array JSON composto da chat_id, text, method
	// chat_id mi consente di rispondere allo specifico utente che ha scritto al bot
	// text è il testo della risposta
	$parameters = array('chat_id' => $chatId, "text" => $response);
	// method è il metodo per l'invio di un messaggio (cfr. API di Telegram)
	$parameters["method"] = "sendMessage";
	// converto e stampo l'array JSON sulla response
	echo json_encode($parameters);
	
	



	
}catch(Exception $e){
	
	$parameters = array('chat_id' => $chatId, "text" => $e->getMessage());
	// method è il metodo per l'invio di un messaggio (cfr. API di Telegram)
	$parameters["method"] = "sendMessage";
	
	echo json_encode($parameters);
}
