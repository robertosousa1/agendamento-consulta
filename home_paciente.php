<?php
include_once("./bd/connection.php");
session_start();
$sql = "SELECT * FROM especializacao";
$res = mysqli_query($connection, $sql);
$num = mysqli_num_rows($res);
for ($i = 0; $i < $num; $i++) {
  $dados = mysqli_fetch_array($res);
  $arrespecializacaos[$dados['id']] = $dados['descricao'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<title>Home</title>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<link href='assets/css/fullcalendar.min.css' rel='stylesheet'>
        <link href='assets/css/fullcalendar.print.min.css' rel='stylesheet' media='print'>
        <link href='assets/css/personalizado.css' rel='stylesheet'>
        <script src='assets/js/moment.min.js'></script>
        <script src='assets/js/fullcalendar.min.js'></script>
        <script src='assets/locale/pt-br.js'></script>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
		
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">

                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>
            <a class="navbar-brand" href="#">
				<div class="pull-left">
				<p>Paciente(a) <i><?php echo $_SESSION['nome']; ?></i>!</p>
				</div>
            </a>
        </div>

        <div class="" id="">
            <ul class="">
				<li></i></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </div>
    </div>
</nav>
		
<div class="container" style="margin-top:120px">	

<h2>Agendamento de Consultas </h2>

	<br>
	
	<script>
	
					function buscar_doutor(){
						var especialidade = $('#especialidade').val();
						if(especialidade){
							var url = './dao/ajax_alt_medicos.php?especialidade='+especialidade;
							$.get(url, function(dataReturn) {
								$('#load_doutor').html(dataReturn);
							});
						}
					}

            $(document).ready(function () {

                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay,listWeek'
                    },
                    defaultDate: Date(),
                    navLinks: true, 
                    editable: true,
                    eventLimit: true,
                    eventClick: function (event) {
                        $("#apagar_evento").attr("href", "./dao/proc_apagar_evento.php?id=" + event.id);

                        $('#visualizar #id').text(event.id);
                        $('#visualizar #id').val(event.id);
                        $('#visualizar #descricao').text(event.descricao);
                        $('#visualizar #descricao').val(event.descricao);
						$('#visualizar #username').text(event.username);
                        $('#visualizar #username').val(event.username);
						$('#visualizar #name').text(event.name);
                        $('#visualizar #name').val(event.name);
						$('#visualizar #cpf').text(event.cpf);
                        $('#visualizar #cpf').val(event.cpf);
						$('#visualizar #email').text(event.email);
                        $('#visualizar #email').val(event.email);
                        $('#visualizar #start').text(event.start.format('DD/MM/YYYY HH:mm:ss'));
                        $('#visualizar #start').val(event.start.format('DD/MM/YYYY HH:mm:ss'));
                        $('#visualizar #end').text(event.end.format('DD/MM/YYYY HH:mm:ss'));
                        $('#visualizar #end').val(event.end.format('DD/MM/YYYY HH:mm:ss'));
						$('#visualizar #note').text(event.note);
                        $('#visualizar #note').val(event.note);
                        $('#visualizar #color').val(event.color);
                        $('#visualizar').modal('show');
                        return false;

                    },

                    selectable: true,
                    selectHelper: true,
                    select: function (start, end) {
                        $('#cadastrar #start').val(moment(start).format('DD/MM/YYYY HH:mm:ss'));
                        $('#cadastrar #end').val(moment(end).format('DD/MM/YYYY HH:mm:ss'));
                        $('#cadastrar').modal('show');
                    },

                    events: {
                        url: './dao/list_data_paciente.php',
                        cache: true
                    }
                });

            });

        </script>
		
		<script>
					function buscar_medicos(){
						var especializacao = $('#especializacao').val();
						if(especializacao){
							var url = './dao/ajax_buscar_medicos.php?especializacao='+especializacao;
							$.get(url, function(dataReturn) {
								$('#load_medicos').html(dataReturn);
							});
						}
					}
						
		</script>
		
    </head>
    <body>
        <div class="container"><br>
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <div id='calendar'></div>
        </div>


        <div class="modal fade" id="visualizar" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Dados da Consulta</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="visualizar">
                            <dl class="row">
                                <dt class="col-sm-3">ID da Consulta</dt>
                                <dd id="id" class="col-sm-9"></dd>
								<dt class="col-sm-3">Consulta</dt>
                                <dd id="descricao" class="col-sm-9"></dd>
								<dt class="col-sm-3">Médico(a)</dt>
                                <dd id="username" class="col-sm-9"></dd>
							    <dt class="col-sm-3">Nome do Paciente</dt>
                                <dd id="name" class="col-sm-9"></dd>
								<dt class="col-sm-3">CPF</dt>
                                <dd id="cpf" class="col-sm-9"></dd>
								<dt class="col-sm-3">E-mail</dt>
                                <dd id="email" class="col-sm-9"></dd>
                                <dt class="col-sm-3">Inicio da Consulta</dt>
                                <dd id="start" class="col-sm-9"></dd>
                                <dt class="col-sm-3">Fim da Consulta</dt>
                                <dd id="end" class="col-sm-9"></dd>
								<dt class="col-sm-3">Anotação</dt>
                                <dd id="note" class="col-sm-9"></dd>
                            </dl>
                            <button class="btn btn-canc-vis btn-warning">Editar</button>
                            <a href="" id="apagar_evento" class="btn btn-danger" role="button">Apagar</a>
                        </div>   
                        <div class="form">
                            <form method="POST" action="./dao/proc_edit_evento_paciente.php">
							
							<div class="form-group">
                                <div class="form-group col-md-12">
                                    <label>Consulta</label>
									<select name="especialidade" id="especialidade" class="form-control" onchange="buscar_doutor()">
										<option value=>Selecione</option>
										<?php foreach ($arrespecializacaos as $value => $name) {
											echo "<option value='{$value}'>{$name}</option>";											
											}?>
									</select>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="form-group col-md-12" id="load_doutor">                                
                                    <label>Médico</label>
									<select name="doutor" id="doutor" class="form-control">
										<option>Selecione</option>
									</select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-group col-md-12">
                                    <label>Cor</label>
                                    <select name="color" class="form-control" id="color">
                                        <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                        <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                        <option style="color:#8B4513;" value="#8B4513">Marrom</option>  
                                        <option style="color:#1C1C1C;" value="#1C1C1C">Preto</option>
                                        <option style="color:#436EEE;" value="#436EEE">Azul</option>
                                        <option style="color:#A020F0;" value="#A020F0">Roxo</option>                                            
                                        <option style="color:#228B22;" value="#228B22">Verde</option>
                                        <option style="color:#8B0000;" value="#8B0000">Vermelho</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-md-12">
                                    <label>Data Inicial</label>
                                    <input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-md-12">
                                    <label>Data Final</label>
                                    <input type="text" class="form-control" name="end" id="end" onKeyPress="DataHora(event, this)">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-md-12">
                                    <label>Anotação:</label>
                                    <input type="text" class="form-control" name="note" id="note" placeholder="Detalhes sobre a consulta">
                                </div>
                            </div>
                                <input type="hidden" name="id" id="id">
                                <div class="form-group col-md-12">
                                    <button type="button" class="btn btn-canc-edit btn-primary">Cancelar</button>
                                    <button type="submit" class="btn btn-warning">Salvar Alterações</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cadastrar" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Cadastrar Consulta</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="./dao/proc_cad_evento_paciente.php">
							<div class="form-group">
                                <div class="form-group col-md-12">
                                    <label>Consulta</label>
									<select name="especializacao" id="especializacao" class="form-control" onchange="buscar_medicos()">
										<option value=>Selecione</option>
										<?php foreach ($arrespecializacaos as $value => $name) {
											echo "<option value='{$value}'>{$name}</option>";											
											}?>
									</select>
                                </div>
                            </div>
							
							<div class="form-group">
                                <div class="form-group col-md-12" id="load_medicos">                                
                                    <label>Médico</label>
									<select name="medico" id="medico" class="form-control">
										<option>Selecione</option>
									</select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-group col-md-12">
                                    <label>Cor</label>
                                    <select name="color" class="form-control" id="color">
                                        <option style="color:#FFD700;" value="#FFD700">Amarelo</option>
                                        <option style="color:#FF4500;" value="#FF4500">Laranja</option>
                                        <option style="color:#8B4513;" value="#8B4513">Marrom</option>	
                                        <option style="color:#1C1C1C;" value="#1C1C1C">Preto</option>
                                        <option style="color:#436EEE;" value="#436EEE">Azul</option>
                                        <option style="color:#A020F0;" value="#A020F0">Roxo</option>                                            
                                        <option style="color:#228B22;" value="#228B22">Verde</option>
                                        <option style="color:#8B0000;" value="#8B0000">Vermelho</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-md-12">
                                    <label>Data Inicial</label>
                                    <input type="text" class="form-control" name="start" id="start" onKeyPress="DataHora(event, this)">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-group col-md-12">
                                    <label>Data Final</label>
                                    <input type="text" class="form-control" name="end" id="end" onKeyPress="DataHora(event, this)">
                                </div>
                            </div>
							<div class="form-group">
                                <div class="form-group col-md-12">
                                    <label>Anotação:</label>
                                    <input type="text" class="form-control" name="note" id="note" placeholder="Detalhes sobre a consulta">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="">
                                    <button type="submit" class="btn btn-success">Cadastrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script>
            //Mascara para o campo data e hora
            function DataHora(evento, objeto) {
                var keypress = (window.event) ? event.keyCode : evento.which;
                campo = eval(objeto);
                if (campo.value == '00/00/0000 00:00:00') {
                    campo.value = ""
                }

                caracteres = '0123456789';
                separacao1 = '/';
                separacao2 = ' ';
                separacao3 = ':';
                conjunto1 = 2;
                conjunto2 = 5;
                conjunto3 = 10;
                conjunto4 = 13;
                conjunto5 = 16;
                if ((caracteres.search(String.fromCharCode(keypress)) != -1) && campo.value.length < (19)) {
                    if (campo.value.length == conjunto1)
                        campo.value = campo.value + separacao1;
                    else if (campo.value.length == conjunto2)
                        campo.value = campo.value + separacao1;
                    else if (campo.value.length == conjunto3)
                        campo.value = campo.value + separacao2;
                    else if (campo.value.length == conjunto4)
                        campo.value = campo.value + separacao3;
                    else if (campo.value.length == conjunto5)
                        campo.value = campo.value + separacao3;
                } else {
                    event.returnValue = false;
                }
            }


            $('.btn-canc-vis').on("click", function () {
                $('.form').slideToggle();
                $('.visualizar').slideToggle();
            });
            $('.btn-canc-edit').on("click", function () {
                $('.visualizar').slideToggle();
                $('.form').slideToggle();
            });
        </script>
	<br>


</div> <br><br>

<footer class="footer-1"><br><br>
            <div class="lower">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="small">Copyright &copy; 2018 - Roberto Sousa.</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>		

</body>
</html>