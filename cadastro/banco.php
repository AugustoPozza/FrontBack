<?php
class Banco {
    private $usuario;
    private $senha;
    private $servidor;
    private $porta;
    private $nome_banco;
    private $pdo;

    public function __construct() {
        $this->usuario = "root";
        $this->senha = "";
        $this->servidor = "localhost";
        $this->porta = "4406";
        $this->nome_banco = "teste2";
        try {
            $this->pdo = new PDO("mysql:host={$this->servidor}:4406;port={$this->porta};dbname={$this->nome_banco}", $this->usuario, $this->senha);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
            exit;
        }
    }

    public function Consultar($sql, $params = []) {
        $stm = $this->Executar($sql, $params);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Executar($sql, $params = []) {
        $stm = $this->pdo->prepare($sql);
        $stm->execute($params);
        return $stm;
    }
}
?>
