<?php
include_once("./bd/connection.php");
session_start();

$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
if($btnCadUsuario){
	$dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
	$erro = false;
	
	$dados_st = array_map('strip_tags', $dados_rc);
	$dados = array_map('trim', $dados_st);
	
	if(!$erro){
		
		$sql = "SELECT id FROM medico where email = '".$_SESSION['email']."' ";
		$query1 = mysqli_query($connection, $sql);
		$row1 = mysqli_fetch_assoc($query1);
		$_SESSION['id'] = $row1['id'];
		
			$result_usuario = "INSERT INTO medico_especializacao (fk_especializacao, fk_medico) VALUES (
						'" .$dados['especialidade']. "',
						'" .$_SESSION['id']. "'
						)";
			$resultado_usario = mysqli_query($connection, $result_usuario);
			
				$result_usuario2 = "INSERT INTO medico_especializacao (fk_especializacao, fk_medico) VALUES (
						'" .$dados['especialidade2']. "',
						'" .$_SESSION['id']. "'
						)";
				$resultado_usario2 = mysqli_query($connection, $result_usuario2);
			
			if(mysqli_insert_id($connection)){
				$_SESSION['msgcad'] = "Especialidade cadastrada com sucesso";
				header("Location: index.php");
			}else{
				$_SESSION['msg'] = "Erro ao cadastrar a especialidade.";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cadastrar Especialidade do Médico</title>
		<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="assets/css/signin.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div class="form-signin">
				<h2>Especialidade do Medico(a) <?php echo $_SESSION['nome']; ?></h2>
				<?php
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}
				?>
				<form method="POST" action="">
					
					<div class="form-group">
                                <div class="form-group">
									<select required="required" name="especialidade" class="form-control" id="especialidade">
										<option value="">1. Especialidade</option>
										<?php
										$result_paciente = "SELECT * FROM especializacao";
										$resultado_paciente = mysqli_query($connection, $result_paciente);
										while ($row_paciente = mysqli_fetch_assoc($resultado_paciente)){ ?>
											<option value="<?php echo $row_paciente['id']; ?>"><?php echo $row_paciente['descricao']; ?>
											</option> <?php
										}
										?>
									</select>
								</div>
                            </div>
					
					<div class="form-group">
                                <div class="form-group">
									<select name="especialidade2" class="form-control" id="especialidade2">
										<option value="">2. Especialidade</option>
										<?php
										$result_paciente = "SELECT * FROM especializacao";
										$resultado_paciente = mysqli_query($connection, $result_paciente);
										while ($row_paciente = mysqli_fetch_assoc($resultado_paciente)){ ?>
											<option value="<?php echo $row_paciente['id']; ?>"><?php echo $row_paciente['descricao']; ?>
											</option> <?php
										}
										?>
									</select>
                                </div>
                            </div>
					
					
					<input type="submit" name="btnCadUsuario" value="Cadastrar" class="btn btn-success"><br><br>
					
				</form>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.min.js">
		</script>
	</body>
</html>