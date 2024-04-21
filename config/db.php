// config/db.php
<?php
$servidor = 'academias.mysql.uhserver.com';
$usuario = 'academias';
$senha = 'Wesv@g28';
$banco = 'academias';

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die('Falha na conexão com o Banco de dados: ' . $conexao->connect_error);
}
?>
