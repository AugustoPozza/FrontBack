<?php
require_once("Auth.php");

$login = $_POST['usu'];
$senha = $_POST['sen'];

$auth = new Auth();
$response = $auth->login($login, $senha);

echo $response;
?>
