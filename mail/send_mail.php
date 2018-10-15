<?php

require_once('class.phpmailer.php'); //chama a classe de onde você a colocou.

include_once("../bd/connection.php");

$mail = new PHPMailer(); // instancia a classe PHPMailer

$mail->IsSMTP();

$mail->SMTPDebug = false;       // Debugar: 1 = erros e mensagens, 2 = mensagens apenas

//configuração do gmail
$mail->Port = '465'; //porta usada pelo gmail.
$mail->Host = 'smtp.gmail.com'; 
$mail->IsHTML(true); 
$mail->Mailer = 'smtp'; 
$mail->SMTPSecure = 'ssl';

//configuração do usuário do gmail
$mail->SMTPAuth = true; 
$mail->Username = 'agendamentodeconsultas1@gmail.com'; // usuario gmail.   
$mail->Password = 'altran01&'; // senha do email.

$mail->SingleTo = true; 

$mail->SMTPAutoTLS = false;

// configuração do email a ver enviado.
//$mail->From = "Mensagem de email, pode vim por uma variavel."; 
//$mail->FromName = "Nome do remetente."; 

//$mail->addAddress("roberto_junior_sousa@hotmail.com"); // email do destinatario.

//$mail->Subject = "Aqui vai o assunto do email, pode vim atraves de variavel."; 
//$mail->Body = "Aqui vai a mensagem, que tambem pode vim por variavel.";

$mail->SMTPOptions = array(
'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
 )
);

$html = " 
	 <b> Agendamento de Consulta </b> <br/>
	 </b> title <br/> <br/> 
	 
	 Ola Sr(a) nome_mail a sua consulta esta programada para se iniciar: <br/>
     <br/>
	 
     <b>Data:</b> data_mail<br/>
	 <b>Hora:</b> hora_mail<br/>
     <br/>
	 
	 Por favor, chegue 15 minutos antes.<br/>
	 <br/>
	 
	 Obrigado!
   ";
   
	$mail->From = "Agendamento de Consulta";
	
	$sql = "SELECT email, username FROM medico";
	$result = mysqli_query($connection, $sql);
	while ($row = mysqli_fetch_assoc($result)){
		
		$newArray[] = array(			
			'username' => $row["username"], 
			'email' => $row["email"]
		);
	}
	
	foreach($newArray as $email => $username){
	$mail->AddBCC($email, $username);
	}
	
	$mail->Subject = "Agendamente de Consulta."; 
	$mail->Body = $html;


	$mail->Send();
	echo "Mensagem enviada com sucesso</p>\n";

 //if(!$mail->Send())
 //echo "Erro ao enviar Email:" . $mail->ErrorInfo;

?>
