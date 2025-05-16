<?php
header('Content-Type: application/json');
$termo = $_GET['termo'] ?? '';
$offset = $_GET['offset'] ?? 0;

if (strlen(trim($termo)) < 3) {
    echo json_encode(["erro" => "Digite pelo menos 3 caracteres."]);
    exit;
}

$url = "https://compras.dados.gov.br/licitacoes/v1/licitacoes.json?objeto=" . urlencode($termo) . "&modalidade=5&offset=" . intval($offset);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
$response = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$erro = curl_error($ch);
curl_close($ch);

if (!$response || $http !== 200 || strpos($response, '{') !== 0) {
    echo json_encode(["erro" => "Erro ao acessar a API", "http" => $http, "curl" => $erro]);
    exit;
}

echo $response;
?>
