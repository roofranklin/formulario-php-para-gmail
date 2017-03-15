<?php
$Nome		= $_POST["nome"];	// Pega o valor do campo Nome
$Email		= $_POST["email"];	// Pega o valor do campo Email
$Telefone		= $_POST["telefone"];	// Pega o valor do campo Telefone
$Mensagem	= $_POST["mensagem"];// Pega os valores do campo Mensagem

// Variável que junta os valores acima e monta o corpo do email

$Vai = "Nome: $Nome\n\nEmail: $Email\n\nTelefone: $Telefone\n\nMensagem: $Mensagem\n";

// Inclusão da biblioteca que cuida do envio (não esqueça de subir essa pasta em seu servidor)

require_once("phpmailer/class.phpmailer.php");

define('GUSER', 'teste@gmail.com');	// <-- Insira aqui o seu GMail
define('GPWD', '123456');		// <-- Insira aqui a senha do seu GMail

function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	$mail->SMTPSecure = 'ssl';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
	$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->SMTPSecure = 'tls'; // SSL REQUERIDO pelo GMail
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	if(!$mail->Send()) {
		$error = 'Erro no envio: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Mensagem Enviada!';
		return true;
	}
}

// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

 if (smtpmailer('destinatario@gmail.com', 'remetente@gmail.com', 'Nome do Remetente', 'Contato Via Site', $Vai)) {

	Header("location:obrigado.html"); // Redireciona para uma página de obrigado.

}
if (!empty($error)) echo $error;
?>