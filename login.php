<?php
session_start();

$error=''; 

include "./bd/connection.php";
if(isset($_POST['submit'])){
	
	$email	    = $_POST['email'];
	$password	= $_POST['password'];
	
	$password_sha1 = sha1($password);

	$sql_medico = "SELECT descricao, a.id, a.username, email, password FROM medico a join tipo_usuario b on a.fk_tipo_usuario = b.id where email = '".$email."' AND password = '".$password_sha1."' ";
	$query1 = mysqli_query($connection, $sql_medico);
	if(mysqli_num_rows($query1) == 0){
		$error = "E-mail ou senha inválido";
	} else {
		$row1 = mysqli_fetch_assoc($query1);
		$_SESSION['nivel_acesso'] = $row1['descricao'];
		$_SESSION['id'] = $row1['id']; 
		$_SESSION['nome'] = $row1['username'];
		$_SESSION['email'] = $row1['email'];
		$_SESSION['senha'] = $row1['password'];
	}
	
	$sql_paciente = "SELECT descricao, a.id, a.name, email, password FROM paciente a join tipo_usuario b on a.fk_tipo_usuario = b.id where email = '".$email."' AND password = '".$password_sha1."' ";
	$query1 = mysqli_query($connection, $sql_paciente);
	if(mysqli_num_rows($query1) == 0){
		$error = "E-mail ou senha inválido";
	} else {
		$row1 = mysqli_fetch_assoc($query1);
		$_SESSION['nivel_acesso'] = $row1['descricao'];
		$_SESSION['id'] = $row1['id']; 
		$_SESSION['nome'] = $row1['name'];
		$_SESSION['email'] = $row1['email'];
		$_SESSION['senha'] = $row1['password'];
	}
	
	$sql_atendente = "SELECT descricao, a.id, a.username, email, password FROM atendente a join tipo_usuario b on a.fk_tipo_usuario = b.id where email = '".$email."' AND password = '".$password_sha1."' ";
	$query1 = mysqli_query($connection, $sql_atendente);
	if(mysqli_num_rows($query1) == 0){
		$error = "E-mail ou senha inválido";
	} else {
		$row1 = mysqli_fetch_assoc($query1);
		$_SESSION['nivel_acesso'] = $row1['descricao'];
		$_SESSION['id'] = $row1['id']; 
		$_SESSION['nome'] = $row1['username'];
		$_SESSION['email'] = $row1['email'];
		$_SESSION['senha'] = $row1['password'];
	}
}
	
?>