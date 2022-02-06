<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $nombre;
    public $email;
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
        
    }

    public function enviarConfirmacion(){

            // Creando el Objeto de email

            $mail = new PHPMailer();

            // Configurar SMTP
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = 'smtp.mailtrap.io';                           //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = '583d9f9c825b70';                       //SMTP username
            $mail->Password   = 'fe32d63c26870e';                       //SMTP password
            $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
            $mail->Port       = 2525;                                   //TCP port to connect to

            // Configurar el contenido del mail
            $mail->addAddress("cuentas@appsalon", "AppSalon.com");
            $mail->addAddress("cuentas@appsalon.com", "AppSalon.com");
            $mail->Subject = 'Confirma tu cuenta';

            // Habilitar HTML
            $mail->isHTML(true);     
            $mail->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en AppSalon, solo debes confirmar tu cuenta precionando el siguiente enlace</p>";
            $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token .  "'>Confirmar Cuenta</a></p>";
            $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
            $contenido .= "</html>";

            $mail->Body = $contenido;

            //Enviar el Email
            $mail->send();
        
    }

    public function enviarInstrucciones(){

        // Creando el Objeto de email

        $mail = new PHPMailer();

        // Configurar SMTP
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.mailtrap.io';                           //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '583d9f9c825b70';                       //SMTP username
        $mail->Password   = 'fe32d63c26870e';                       //SMTP password
        $mail->SMTPSecure = 'tls';                                  //Enable implicit TLS encryption
        $mail->Port       = 2525;                                   //TCP port to connect to

        // Configurar el contenido del mail
        $mail->addAddress("cuentas@appsalon", "AppSalon.com");
        $mail->addAddress("cuentas@appsalon.com", "AppSalon.com");
        $mail->Subject = 'Reestablece tu password';

        // Habilitar HTML
        $mail->isHTML(true);     
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token=" . $this->token .  "'>Reestablecer Password</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el Email
        $mail->send();
    

    }
}