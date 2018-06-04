<?php

namespace Core;
//use PHPMailer\PHPMailer\PHPMailer;

class Funcoes {

    public function tratarCaracter($valor, $tipo) {
        switch ($tipo) {
            case 1: $rst = utf8_decode($valor);
                break;
            case 2: $rst = htmlentities($valor, ENT_QOUTES, "ISO-8859-1");
                break;
        }
        return $rst;
    }

    public static function dataAtual($tipo) {
        date_default_timezone_set("America/Sao_Paulo");
        switch ($tipo) {
            case 1: $rts = date("Y-m-d");
                break;
            case 2: $rts = date("Y-m-d H:i:s");
                break;
            case 3: $rts = date("d-m-Y H:i:s");
                break;
        }
        return $rts;
    }

    public function formatadata($date, $tipo) {
        date_default_timezone_set("America/Sao_Paulo");
        switch ($tipo) {

            case 1: $rts = $date->format('Y-m-d');
                break;
        }
        return $rts;
    }

    public static function base64($valor, $tipo) {
        switch ($tipo) {
            case 1: $rts = md5($valor);
                break;
            case 2: $rts = base64_encode($valor);
                break;
            case 3: $rts = base64_decode($valor);
                break;
        }
        return $rts;
    }

    public function EnviarEmail($dados) {
       
        try {
                require 'PHPMailer/class.phpmailer.php';
                 $Mailer = new \PHPMailer();
			
			//Define que será usado SMTP
			$Mailer->IsSMTP();
			
			//Enviar e-mail em HTML
			$Mailer->isHTML(true);
			
			//Aceitar carasteres especiais
			$Mailer->Charset = 'UTF-8';
			$Mailer->SMTPDebug = 3;
			//Configurações
			$Mailer->SMTPAuth = true;
			$Mailer->SMTPSecure = 'ssl';
			
			//nome do servidor
			$Mailer->Host = 'smtp.gmail.com';
			//Porta de saida de e-mail 
			$Mailer->Port = 587;
			
			//Dados do e-mail de saida - autenticação
			$Mailer->Username = 'wesllenalves@gmail.com';
			$Mailer->Password = '30459780';
			
			//E-mail remetente (deve ser o mesmo de quem fez a autenticação)
			$Mailer->From = 'wesllenalves@gmail.com';
			
			//Nome do Remetente
			$Mailer->FromName = 'Celke';
			
			//Assunto da mensagem
			$Mailer->Subject = 'Titulo - Recuperar Senha';
			
			//Corpo da Mensagem
			$mensagem = "Olá <br><br>";
			$mensagem .= "Confirme seu e-mail para receber o material! <br> <br>";
			$mensagem .= "<a href=''>Clique aqui para confirmar seu e-mail</a><br> <br>";
			$mensagem .= "Se você recebeu este e-mail por engano, simplesmente o exclua.<br> <br>";
			$mensagem .= "Cesar - Celke";
			
			$Mailer->Body = $mensagem;
			
			//Corpo da mensagem em texto
			$Mailer->AltBody = 'conteudo do E-mail em texto';
			
			//Destinatario 
			$Mailer->AddAddress($dados['email']);
			
			if($Mailer->Send()){
				echo "E-mail enviado com sucesso";
			}else{
				echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
			}
			}catch(Exception $e){
				echo "Erro no envio do e-mail: " . $Mailer->ErrorInfo;
				echo $e->message;
			}
    }

}
