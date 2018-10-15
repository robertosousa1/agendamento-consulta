<?php
include_once("./bd/connection.php");
$btnCadUsuario = filter_input(INPUT_POST, 'btnCadUsuario', FILTER_SANITIZE_STRING);
if($btnCadUsuario){
	$dados_rc = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
	$erro = false;
	
	$dados_st = array_map('strip_tags', $dados_rc);
	$dados = array_map('trim', $dados_st);
	
	if(in_array('',$dados)){
		$erro = true;
		$_SESSION['msg'] = "Necessário preencher todos os campos";
	}elseif((strlen($dados['senha'])) < 6){
		$erro = true;
		$_SESSION['msg'] = "A senha deve ter no minímo 6 caracteres";
	}elseif(stristr($dados['senha'], "'")) {
		$erro = true;
		$_SESSION['msg'] = "Caracter ( ' ) utilizado na senha é inválido";
	}else{
		
		if($dados['nivel_acesso'] == 1){
			$result_usuario = "SELECT id FROM medico WHERE email='". $dados['email'] ."'";	
		} 
		if ($dados['nivel_acesso'] == 2){
			$result_usuario = "SELECT id FROM atendente WHERE email='". $dados['email'] ."'";	
		}
		if ($dados['nivel_acesso'] == 3){
			$result_usuario = "SELECT id FROM paciente WHERE email='". $dados['email'] ."'";	
		}
		$resultado_usuario = mysqli_query($connection, $result_usuario);
		if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
			$erro = true;
			$_SESSION['msg'] = "Este e-mail já está sendo utilizado";
		}
		
	}
	
	
	//var_dump($dados);
	if(!$erro){
		//var_dump($dados);
		$dados['senha'] = sha1($dados['senha']);
		
		if($dados['nivel_acesso'] == 1){
		
			$result_usuario = "INSERT INTO medico (username, password, email, cpf, fk_tipo_usuario) VALUES (
						'" .$dados['nome']. "',
						'" .$dados['senha']. "',
						'" .$dados['email']. "',
						'" .$dados['cpf']. "',
						'" .$dados['nivel_acesso']. "'
						)";
			$resultado_usario = mysqli_query($connection, $result_usuario);
			if(mysqli_insert_id($connection)){
				session_start();
				$_SESSION['nome'] = $dados['nome']; 
				$_SESSION['email'] = $dados['email'];
				$_SESSION['senha'] = $dados['senha'];
				$_SESSION['nivel_acesso'] = $dados['nivel_acesso'];
				$_SESSION['msgcad'] = "Médico cadastrado com sucesso";
				header("Location: especialidade.php");
			}else{
				$_SESSION['msg'] = "Erro ao cadastrar o médico";
			}
		}
		if($dados['nivel_acesso'] == 2){
			
			$result_usuario = "INSERT INTO atendente (username, password, email, cpf, fk_tipo_usuario) VALUES (
						'" .$dados['nome']. "',
						'" .$dados['senha']. "',
						'" .$dados['email']. "',
						'" .$dados['cpf']. "',
						'" .$dados['nivel_acesso']. "'
						)";
						
			$resultado_usario = mysqli_query($connection, $result_usuario);
			if(mysqli_insert_id($connection)){
				session_start();
				$_SESSION['nome'] = $dados['nome']; 
				$_SESSION['email'] = $dados['email'];
				$_SESSION['senha'] = $dados['senha'];
				$_SESSION['nivel_acesso'] = $dados['nivel_acesso'];
				$_SESSION['msgcad'] = "Atendente cadastrado com sucesso";
				header("Location: index.php");
			}else{
				$_SESSION['msg'] = "Erro ao cadastrar o atendente";
			}
			
		}
		if($dados['nivel_acesso'] == 3){

			$result_usuario = "INSERT INTO paciente (name, password, email, cpf, fk_tipo_usuario) VALUES (
						'" .$dados['nome']. "',
						'" .$dados['senha']. "',
						'" .$dados['email']. "',
						'" .$dados['cpf']. "',
						'" .$dados['nivel_acesso']. "'
						)";		
						
			$resultado_usario = mysqli_query($connection, $result_usuario);
			if(mysqli_insert_id($connection)){
				session_start();
				$_SESSION['nome'] = $dados['nome']; 
				$_SESSION['email'] = $dados['email'];
				$_SESSION['senha'] = $dados['senha'];
				$_SESSION['nivel_acesso'] = $dados['nivel_acesso'];
				$_SESSION['msgcad'] = "Paciente cadastrado com sucesso";
				header("Location: index.php");
			}else{
				$_SESSION['msg'] = "Erro ao cadastrar o Paciente";
			}
			
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
		<title>Cadastrar</title>
		<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="assets/css/signin.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<div class="form-signin">
				<h2>Cadastrar Usuário</h2>
				<?php
					if(isset($_SESSION['msg'])){
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}
				?>
				<form method="POST" action="">
	
					<input type="text" required="required" name="nome" placeholder="Digite o nome completo" class="form-control"><br>
					
					<input type="text" required="required" name="email" placeholder="Digite o seu e-mail" title="Informe um e-mail válido" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"><br>
					
					<input type="password" required="required" name="senha" pattern=".{6,15}" title="A senha deve ter de 6 a 15 caracteres" placeholder="Digite a senha" class="form-control"><br>				
					
					<input type="text" required="required" name="cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Digite o CPF no formato 000.000.000-00" placeholder="Digite o cpf" class="form-control"><br>
					
					<div class="form-group">
                                <div class="form-group">
									<select required="required" name="nivel_acesso" class="form-control" id="nivel_acesso">
										<option value="">Nível de acesso</option>
										<?php
										$result_paciente = "SELECT * FROM tipo_usuario";
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
					
					<div class="row text-center" style="margin-top: 20px;"> 
						<b>Lembrou? <a href="index.php">Clique aqui</a> para logar</b>
					</div>
				</form>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.min.js">
		</script>
	</body>
</html>