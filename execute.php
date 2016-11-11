<?php

define('BOT_TOKEN', '287099689:AAHEUsdjtrD2VN1vgWfJnXcq5TfSTrLLbUE');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";

try {

    $message = isset($update['message']) ? $update['message'] : "";
    $messageId = isset($message['message_id']) ? $message['message_id'] : "";
    $firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
    $lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
    $username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
    $date = isset($message['date']) ? $message['date'] : "";
    $text = isset($message['text']) ? $message['text'] : "";
    $botUrl = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendPhoto";

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

	if (preg_match('/^buongiorno/', $text) || preg_match('/^buongiornissimo/', $text)) {
        //se $giornodellasettimana e' 1 bisogna mandare foto del lunedi se e' martedi' foto del martedi' ecc...
		/*$path = "settimana/".$giornodellasettimana."/".rand(1, 3).".jpg";

        $output =sendPhotos($path,$chatId,$botUrl );*/

	}elseif(preg_match('/politica/', $text) || preg_match('/renzi/', $text)){
		$response = "E renzi ke faaa????";
	}elseif(preg_match('/salvini/', $text)){
		$response = "RUSPA!!";
	}elseif(preg_match('/falsa/', $text) || preg_match('/bugia/', $text) ){
		$response = "Perzona Farsa!!!1!1";
	}elseif(preg_match('/caffe/', $text) || preg_match('/caffé/', $text) || preg_match('/caffè/', $text) ){
		$response = "Kaffeeeee!!!1!1";
	}elseif(preg_match('/amen/', $text || preg_match('/preghiera/', $text) || preg_match('/santino/', $text))){
		$postFields = array('chat_id' => $chatId, 'photo' => new CURLFile(realpath("immagini/amen/arcangelo.jpg")), 'caption' => "");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
		curl_setopt($ch, CURLOPT_URL, $botUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		// read curl response
		$output = curl_exec($ch);
	}elseif(preg_match('/che fai/', $text) || preg_match('/pulizzia/', $text) || preg_match('/contatti/', $text)){
		$response = "PULIZIA KONTATTTIIIII!!!1!!1!";
	}elseif(preg_match('/condividi/', $text)){
		$response = "copia e incolla sulla tua bacheca!!!!!11!";
	}elseif(preg_match('/immagine/', $text) || preg_match('/foto/', $text)){
		$path = "immagini/".rand(1, 10).".jpg";

		// change image name and path
		$postFields = array('chat_id' => $chatId, 'photo' => new CURLFile(realpath($path)), 'caption' => "");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
		curl_setopt($ch, CURLOPT_URL, $botUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		// read curl response
		$output = curl_exec($ch);
	}
	elseif(preg_match('/cinismo/', $text)){
		$path = "immagini/".rand(1, 13).".jpg";

		// change image name and path
		$postFields = array('chat_id' => $chatId, 'photo' => new CURLFile(realpath($path)), 'caption' => "");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
		curl_setopt($ch, CURLOPT_URL, $botUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		// read curl response
		$output = curl_exec($ch);
	}
	elseif(preg_match('/buonanotte/', $text) || preg_match('/buona notte/', $text)){
		$path = "immagini/buonanotte".rand(1, 2).".jpg";

		// change image name and path
		$postFields = array('chat_id' => $chatId, 'photo' => new CURLFile(realpath($path)), 'caption' => "");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
		curl_setopt($ch, CURLOPT_URL, $botUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		// read curl response
		$output = curl_exec($ch);
	}elseif(preg_match('/info/', $text)){

		$response = "Benvenuti nella sezione info di 50enne_bot!
		Inizia bene la giornata digitando 'buongiorno' o 'buongiornissimo'! 
		
		Ecco l'elenco dei comandi disponibili  :
			- Buongiorno : ricevere il buongiorno dal bot, 
			- Immagine : Ricevere una simpatica immagine, 
			- BuonaNotte per ricevere la buonanotte dal bot.
			
		Il bot e' in espansione per qualsiasi consiglio o immagine che volete aggiungere sara' presto disponibile la sezione suggerimenti!
		
		Stay tuned!";


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
