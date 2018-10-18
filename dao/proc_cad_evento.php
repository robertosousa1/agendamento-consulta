<?php
session_start();

include_once("../bd/connection.php");

$especializacao = filter_input(INPUT_POST, 'especializacao', FILTER_SANITIZE_STRING);
$medico = filter_input(INPUT_POST, 'medico', FILTER_SANITIZE_STRING);
$note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING);
$paciente = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$color = filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING);
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING);

$query1 = "SELECT id FROM medico_especializacao where fk_medico = '".$medico."' and fk_especializacao = '".$especializacao."' ";
$aux_medico_especializacao = mysqli_query($connection, $query1);
$row1 = mysqli_fetch_assoc($aux_medico_especializacao);
$id_medico_especializacao = $row1['id'];

if(!empty($especializacao) && !empty($medico) && !empty($paciente) && !empty($color) && !empty($start) && !empty($end)){
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
		
		$result_eventos = "INSERT INTO consultas (note, color, start, end, fk_paciente, fk_medico_especializacao) VALUES ('$note', '$color', '$start_sem_barra', '$end_sem_barra', '$paciente', '$id_medico_especializacao')";
		$resultado_eventos = mysqli_query($connection, $result_eventos);
		
		if(mysqli_insert_id($connection)){
		$_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Consulta cadastrada com sucesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		include_once("../mail/send.php");
		header("Location: ../index.php");
		
		}else{
			$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao cadastrar a consulta<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			header("Location: ../index.php");
		}	
		
	} else {
		
		$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Médico(a) selecionado(a) indisponível nessa data/horário.<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
		header("Location: ../index.php");
		
	}
	
}else{
	$_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao cadastrar a consulta<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
	header("Location: ../index.php");
}