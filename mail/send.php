<?php 

require_once('config.php');

include_once("../bd/connection.php");

$sql = "SELECT email, username FROM atendente";
$result = mysqli_query($connection, $sql);
while ($row = mysqli_fetch_array($result)){   
     $mail->addAddress($row['email'], $row['username']);
}

if(isset($id)){
$query1 = "select start, e.descricao, m.username from consultas c join medico_especializacao  me on c.fk_medico_especializacao - me.fk_especializacao join especializacao e on e.id = me.fk_especializacao join medico m on me.fk_medico = m.id where c.id = $id ";
} else {
$query1 = "select start, e.descricao, m.username from consultas c join medico_especializacao  me on c.fk_medico_especializacao - me.fk_especializacao join especializacao e on e.id = me.fk_especializacao join medico m on me.fk_medico = m.id order by c.id DESC LIMIT 1 ";
}
$resultado = mysqli_query($connection, $query1);
$row1 = mysqli_fetch_assoc($resultado);
$data = $row1['start'];
$descricao = $row1['descricao'];
$username = $row1['username'];
	
	
	$html = " 
	 <b> Nova consulta marcada: </b> <br/>
	 
	 </b> $descricao <br/>
	 </b> $username <br/> <br/> 
	 
     <b>$data</b><br/>
	 
   ";
   
	$mail->From = "Agendamento de Consulta";
	$mail->Subject = "Lembrente."; 
	$mail->Body = $html;

 if(!$mail->Send()){
	echo "Erro ao enviar Email:" . $mail->ErrorInfo;
 } else {
	echo "Mensagem enviada com sucesso</p>\n";
 }
?>