<?php
$connection = mysqli_connect("localhost","root","","altran-completo");

$db_banco ="altran-completo";
$db_user = "root";
$db_pass = "";
$host = 'localhost';

$conexao = @mysqli_connect($host,$db_user,$db_pass,$db_banco);
if (!($conexao)){
    print("<script language=JavaScript>
          alert(\"Não foi possível conectar ao Banco de Dados.\");
          </script>");
	echo $conexao;
    exit;
}
?>
