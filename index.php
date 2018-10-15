<?php
include('login.php'); 

	if($_SESSION){
		if($_SESSION['nivel_acesso'] == "Medico") {
			header("Location: home_medico.php");	
		}
		if($_SESSION['nivel_acesso'] == "Atendente") {
			header("Location: home_atendente.php");
		}
		if($_SESSION['nivel_acesso'] == "Paciente") {
			header("Location: home_paciente.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/form-elements.css">
<link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<div class="header">
		<div class="header-main">
		<br><br>
		       <h1>Portal de Acesso</h1>
			<div class="header-bottom">
				<div class="header-right w3agile">
					
					<div class="header-left-bottom agileinfo">
						
					 <form action="#" role="form" method="post">
						<input type="text" name="email" placeholder="E-mail" id="form-email">
					    <input type="password" name="password" placeholder="Senha" id="form-password">
						<br><br>
			       
					  </div>
						<button type="submit" name="submit" class="btn">Entrar</button> <br><br>
					 </form>	
					 
					 <div class="row text-center" style="margin-top: 10px;"> 
						<b>É novo aqui? <a href="cadastrar.php">Clique aqui para se registrar. </a></b>
					</div>
						
				    </div>
				</div>
			  
			</div>
		</div>
</div>

<div class="copyright">
	<b><p>© 2018 | Roberto Sousa. </p><b>
</div>
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
      
</body>
</html>