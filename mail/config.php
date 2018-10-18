<?php

require_once('class.phpmailer.php'); //chama a classe de onde você a colocou.

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
?>
