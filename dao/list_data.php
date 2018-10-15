<?php

include_once "../bd/connection.php";
$sql = "SELECT c.id, note, color, start, end, p.name, p.cpf, p.email, m.username, e.descricao
FROM consultas c join paciente p on c.fk_paciente = p.id
JOIN medico_especializacao me on me.id = c.fk_medico_especializacao
join medico m on m.id = me.fk_medico
join especializacao e on e.id = me.fk_especializacao";

$result_events = $sql;
$resultado_events = mysqli_query($connection, $result_events);

$events = array();

while ($row_events = mysqli_fetch_assoc($resultado_events)) {
    $id = $row_events['id'];
    $note = $row_events['note'];
    $color = $row_events['color'];
    $start = $row_events['start'];
    $end = $row_events['end'];
	$name = $row_events['name'];
	$cpf = $row_events['cpf'];
	$email = $row_events['email'];
	$username = $row_events['username'];
	$descricao = $row_events['descricao'];

	$events[] = array('id' => $id, 'note' => $note, 'color' => $color, 'start' => $start, 'end' => $end, 
	'name' => $name, 'cpf' => $cpf, 'email' => $email, 'username' => $username, 'descricao' => $descricao);
}

echo json_encode($events);
//print_r($datas);

