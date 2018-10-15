<?php
include_once("../bd/connection.php");
$especializacao = $_GET['especialidade'];

$sql = "SELECT m.username, m.id FROM medico_especializacao me 
JOIN especializacao e on me.fk_especializacao = e.id
JOIN medico m on me.fk_medico = m.id
WHERE e.id = $especializacao";

$res = mysqli_query($connection,$sql);
$num = mysqli_num_rows($res);
for ($i = 0; $i < $num; $i++) {
  $dados = mysqli_fetch_array($res);
  $arrmedicos[$dados['id']] = utf8_encode($dados['username']);
}
?>

<label>Medico</label>
<select name="doutor" id="doutor" class="form-control">
  <?php foreach($arrmedicos as $value => $nome){
    echo "<option value='{$value}'>{$nome}</option>";
  }
?>
</select>