<?php
define('BOT_TOKEN', '287099689:AAHEUsdjtrD2VN1vgWfJnXcq5TfSTrLLbUE');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');
// recupero il contenuto inviato da Telegram
$content = file_get_contents("php://input");
// converto il contenuto da JSON ad array PHP
$update = json_decode($content, true);
// se la richiesta è null interrompo lo script
if(!$update)
{
  exit;
}
//funzione che si occupa di creare l'array da mandare come risposta
function createArray($chatId, $method, $message, $photo) {
	//chatid ci va sempre quello
	$array = array('chat_id' => $chatId);
	
	//il metodo deve essere sempre una stringa passata
	if (!is_string($method)) {
		error_log("Method name must be a string\n");
		return false;
	}else{
		// method è il metodo per l'invio di un messaggio (cfr. API di Telegram)
		$array["method"] = $method;
	}

	if (!$message) {
		$array["message"] = $message;
	} 
	
	if (!$photo) {
		$array["photo"] = $photo;
	} 
	// converto e stampo l'array JSON sulla response
	return json_encode($array );  
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
$method = "sendMessage";
// pulisco il messaggio ricevuto togliendo eventuali spazi prima e dopo il testo
$text = trim($text);
// converto tutti i caratteri alfanumerici del messaggio in minuscolo
$text = strtolower($text);
// mi preparo a restitutire al chiamante la mia risposta che è un oggetto JSON
// imposto l'header della risposta
/*header("Content-Type: application/json");
$response = '';
$photo = "";
// la mia risposta è un array JSON composto da chat_id, text, method
// chat_id mi consente di rispondere allo specifico utente che ha scritto al bot
// text è il testo della risposta

//, "text" => $response
//regual expression per decidere che risposta dare
if (preg_match('/^buongiorno/', $text)) {
	//$response = "Buongiornissimo $firstname!!11!!";	
	$method = "sendPhoto";
	$photo = "image1.jpg";
}elseif(preg_match('/politica/', $text)){
	$response = "E renzi ke faaa????";
}elseif(preg_match('/salvini/', $text)){
	$response = "RUSPA!!";
}else{
	$response = "ELSE";
}

$parameters = array('chat_id' => $chatId, "photo" => "image1.jpg");
// method è il metodo per l'invio di un messaggio (cfr. API di Telegram)
$parameters["method"] = "sendPhoto";
// converto e stampo l'array JSON sulla response
*/
$bot_url    = "https://api.telegram.org/botcinquantenne_bot/";
$url        = $bot_url . "sendPhoto?chat_id=" . $chat_id ;

$post_fields = array('chat_id'   => $chat_id,
    'photo'     => new CURLFile(realpath("/image1.jpg"))
);

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type:multipart/form-data"
));
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); 
$output = curl_exec($ch);

echo json_encode($parameters);