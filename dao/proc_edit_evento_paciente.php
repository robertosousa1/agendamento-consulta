<?php
session_start();

//Incluir conexao com BD
include_once("../bd/connection.php");

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$especialidade = filter_input(INPUT_POST, 'especialidade', FILTER_SANITIZE_STRING);
$doutor = filter_input(INPUT_POST, 'doutor', FILTER_SANITIZE_STRING);
$note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
$color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);

$query1 = "SELECT id FROM medico_especializacao where fk_medico = '".$doutor."' and fk_especializacao = '".$especialidade."' ";
$aux_medico_especializacao = mysqli_query($connection, $query1);
$row1 = mysqli_fetch_assoc($aux_medico_especializacao);
$id_medico_especializacao = $row1['id'];

if(!empty($id) && !empty($especialidade) && !empty($doutor) && !empty($color) && !empty($start) && !empty($end)){
	//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
	$data = explode(" ", $start);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$start_sem_barra = $data_sem_barra . " " . $hora;
	
	$data = explode(" ", $end);
	list($date, $hora) = $data;
	$data_sem_barra = array_reverse(explode("/", $date));
	$data_sem_barra = implode("-", $data_sem_barra);
	$end_sem_barra = $data_sem_barra . " " . $hora;
	
	$crivo = "SELECT id from consultas 
	WHERE start >= '$start_sem_barra' 
	AND end <= '$end_sem_barra'
	AND fk_medico_especializacao = '$id_medico_especializacao'";
	
	$result = mysqli_query($connection, $crivo);
	if(mysqli_num_rows($result) == 0){
		
	$sql = "UPDATE consultas SET note='$note', color='$color', start='$start_sem_barra', end='$end_sem_barra', fk_medico_especializacao='$id_medico_especializacao' WHERE id='$id'"; 
	$result_events = $sql;
	$resultado_events = mysqli_query($connection, $result_events);
	
	//Verificar se alterou no banco de dados através "mysqli_affected_rows"
	if(mysqli_affected_rows($connection)){		
		
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Consulta alterada com sucesso.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		include_once("../mail/send.php");
		header("Location: ../index.php");
 
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao editar a consulta <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: ../index.php");
	}
		
	} else {
		
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Médico(a) selecionado(a) indisponível nessa data/horário.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: ../index.php");
		
	}
	
}else{
	$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao editar a consulta<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	header("Location: ../index.php");
}