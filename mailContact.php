<?php
	/**INCLUIMOS LAS LIBRERIAS */
	require_once "extensions/vendor/autoload.php";
	/**TRAEMOS LAS CLASES NECESARIAS */
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
if (!empty($_POST['first_name']) and !empty($_POST['last_name']) and !empty($_POST['email']) and !empty($_POST['message']) ) {
	/**RECIBIMOS LOS DATOS DEL FORM */
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$message = $_POST['message'];

	/**Correo Electrónico de Contacto para el Usuario*/
	date_default_timezone_set("America/Argentina/Buenos_Aires");

	$mail = new PHPMailer;
	$mail->Charset = "UTF-8";
	$mail->isMail();
	$mail->setFrom("contacto@matelab.com.ar", "Mate Lab");
	$mail->addReplyTo("contacto@matelab.com.ar", "Mate Lab");
	$mail->Subject  = "Mate Lab Desarrollamos tecnologia ";
	$mail->addAddress($email);
	$mail->msgHTML('<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">	
						<center>								
							<img style="padding:20px; width:10%" src="http://matelab.com.ar/img/mate.png">
						</center>
						<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">							
							<center>
								<img style="padding:20px; width:15%" src="https://img.icons8.com/nolan/96/000000/email.png">
								<h3 style="font-weight:100; color:#999">Gracias por Contactarte con Mate Lab</h3>
								<hr style="border:1px solid #ccc; width:80%">
                                <h4 style="font-weight:100; color:#999; padding:0 20px">En la brevedad nos prondremos en contactos para </h4>
                                <h5 style="font-weight:100; color:#999; padding:0 20px">Mate Lab Desarrollamos tecnología </h5>
								<br>
								<hr style="border:1px solid #ccc; width:80%">
								<h5 style="font-weight:100; color:#999">Si no completo ningun formularios de contacto, puede ignorar este correo electrónico y eliminarlo.</h5>
							</center>	
						</div>
					</div>');
	$envio = $mail->Send();


	/**MAIL PARA MATELAB */

	$mailMateLab = new PHPMailer;
	$mailMateLab->Charset = "UTF-8";
	$mailMateLab->isMail();
	$mailMateLab->setFrom($email, $first_name);
	$mailMateLab->addReplyTo($email, $first_name);
	$mailMateLab->Subject  = "Contacto";
	$mailMateLab->addAddress('contacto@matelab.com.ar');
	$mailMateLab->msgHTML('<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
						<center>						
							<img style="padding:20px; width:10%" src="http://matelab.com.ar/img/mate.png">
						</center>
						<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">							
							<center>
								<img style="padding:20px; width:15%" src="https://img.icons8.com/nolan/96/000000/email.png">
								<h3 style="font-weight:100; color:#999">La Persona ' . $first_name . ' ' . $last_name . '</h3>
								<hr style="border:1px solid #ccc; width:80%">
                                <h4 style="font-weight:100; color:#999; padding:0 20px">Envio este mensaje: ' . $message . '</h4>
                                <h5 style="font-weight:100; color:#999; padding:0 20px">Mate Lab Desarrollamos tecnología </h5>
								<br>
								<hr style="border:1px solid #ccc; width:80%">
							</center>
						</div>
					</div>');
	$envioMateLab = $mailMateLab->Send();
	/**Comprobamos que los emails fueron eviados correctamente */
	if (!$envio) {
		$error = array('error' => 'No te pudimos enviar el email a tu casilla de contacto, por favor verifica tu email.');
	} else if (!$envioMateLab) {

		$error = array('error' => 'Ocurrió un error inesperado con Mate Lab Por favor recargue la página.');
	}

	if (!empty($error)) {
		$return = $error;
	} else {
		$return = array('success' => 'Los datos fueron enviados Correctamente.');
	}

	// Create JSON 

	echo json_encode($return);
}
