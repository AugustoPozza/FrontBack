<?php
require_once("Banco.php");

class Auth {
    private $banco;

    public function __construct() {
        $this->banco = new Banco();
    }

    public function login($login, $senha) {
        $sql = "SELECT * FROM usuario WHERE email_login = :login";
        $stm = $this->banco->Executar($sql, ['login' => $login]);
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            $usuario = $result[0];
            if ($usuario['senha'] == $senha) {
                $token = md5(uniqid(mt_rand(), true));
                $idusuario = $usuario['id'];
                $sql = "SELECT * 
                        FROM login_control 
                        WHERE idusuario = :idusuario 
                        AND NOW() BETWEEN criado AND expira 
                        ORDER BY id DESC 
                        LIMIT 1";
                $stm = $this->banco->Executar($sql, ['idusuario' => $idusuario]);
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                if (isset($result[0]['token'])) {
                    $token = $result[0]['token'];
                } else {
                    $sql = "INSERT INTO login_control (idusuario, token, criado, expira) 
                            VALUES (:idusuario, :token, NOW(), DATE_ADD(NOW(), INTERVAL 12 HOUR))";
                    $this->banco->Executar($sql, ['idusuario' => $idusuario, 'token' => $token]);
                }
                return json_encode(["status" => "1", "msg" => "Login efetuado com sucesso!", "token" => $token]);
            }
        }
        return json_encode(["status" => "0", "msg" => "Usuário ou senha inválido"]);
    }
}
?>
