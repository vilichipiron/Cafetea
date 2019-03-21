<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

class MailManager {
    private $mail = "";
    public function __construct() {
        //Prepara los parámetros básicos para mandar el email
        $this->mail = new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = "ssl";
        $this->mail->Host = "smtp.gmail.com";
        $this->mail->Port = "465";
        $this->mail->isHTML();
        $this->mail->Username = "cafeteashop@gmail.com";
        $this->mail->Password = "vespino2018";
        $this->mail->setFrom("cafeteashop@gmail.com");
    }
    
    public function confirmacionRegistro($emailDestino, $nombreDestino) {
        $this->mail->Subject = "Registro en Cafetea";
        $this->mail->Body = "<p style='font-size: 18px;'> 
                                Enhorabuena <b>".$nombreDestino.",</b> te has registrado en Cafetea!.<br /> Ahora puedes hacer pedidos :) </p>";
        $this->mail->AddAddress($emailDestino);
        $this->mail->Send();
        return true;
    }
    
    public function correoContacto($nombre, $email, $asunto, $mensaje, $numeroPedido) {
        $this->mail->Subject = $asunto."-Mensaje de contacto";
        $this->mail->Body = "<p style='font-size: 18px;'><b>Número de pedido:</b> ".$numeroPedido."<br /> <b>Asunto:</b> ".$asunto."<br /><b>Nombre:</b> ".$nombre."<br /><b>Email:</b> ".$email."<br /><br /><b>Mensaje:</b> ".$mensaje."</p>";
        $this->mail->AddAddress("cafeteasupp@gmail.com");
        $this->mail->Send();
        return true;
    }
}
?>