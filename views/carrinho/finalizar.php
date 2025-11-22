<?php
if(!isset($_SESSION["carrinho"])) {
    echo "<script>alert('Carrinho vazio');history.back();</script>";
    
}
if(!isset($_SESSION["cliente"])) {
    echo "<script>alert('Cliente não logado');history.back();</script>";
    
}

$token = "APP_USR-1247558615944064-112120-d1112778cac823b0b4f657f60eca6b2f-800256851";

require 'vendor/autoload.php';

MercadoPago\SDK::setAccessToken($token);

// Crie um objeto de preferência (uso direto de arrays/propriedades como antes)
$preference = new MercadoPago\Preference();

$payer = new MercadoPago\Payer();
$payer->name = $_SESSION["cliente"]["nome"];
$payer->email = $_SESSION["cliente"]["email"];
$preference->payer = $payer;

$itens = array();
foreach ($_SESSION["carrinho"] as $produto) {
    $itens[] = array(
        "title"       => $produto["nome"],
        "quantity"    => (int)$produto["qtde"],
        "currency_id" => "BRL",
        "unit_price"  => (float)$produto["valor"]
    );
}

$preference->items = $itens;

$preference->back_urls = array(
    "success" => "https://www.seusite.com.br/meli/sucesso.php",
    "failure" => "https://www.seusite.com.br/meli/falha.php",
    "pending" => "https://www.seusite.com.br/meli/pendente.php"
);

$preference->notification_url = "https://www.seusite.com.br/meli/notificacao.php";
$preference->auto_return = "approved";

$preference->save();
$msg =  $this->carrinho->salvarPedido($preference->id);
if($msg == 0) {
    echo "<script>alert('Erro ao salvar pedido');history.back();</script>";
    
}

?>

<div class="card">

<div class="card-header text-center">

<img src="images/mercado-pago-logo.png" alt="Mercado pago" width="350px">

</div>

<div class="card-body">

<p class="text-center">


<script src="https://www.mercadopago.com.br/integrations/v1/web-payment-checkout.js"

data-preference-id="<?php echo $preference->id; ?>"

data-button-label="Pagar com Mercado Pago (Boleto, Cartão de Credito ou Débito)">

</script>
</p>
</div>

</div>


