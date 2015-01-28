# phplib-inpay

Full API documentation available at:
https://inpay.pl/dokumentacja-api/

Example usage:

```php
require_once("API_Client.php");

$inv = new \InPay\API_Client();
$inv->init(array(
    "apiKey" => "yourapikey"
));

var_dump($inv->invoiceCreate("10"));
```

Paid invoices are issuing callbacks to a callback URL passed to an `init` method.
There is a helper method `callback` checking and returning callback data.
This method should be used in your controller action which handles callback URL
