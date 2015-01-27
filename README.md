# phplib-inpay

Full API documentation available at:
https://inpay.pl/dokumentacja-api/

Example usage

require_once("API_Client.php");

$inv = new \InPay\API_Client();
$inv->init(array(
    "apiKey" => "yourapikey"
));
var_dump($inv->invoiceCreate("10"));
