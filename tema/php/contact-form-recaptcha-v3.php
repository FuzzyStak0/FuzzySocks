<?php

namespace PortoContactForm;

ini_set('allow_url_fopen', true);

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php-mailer/src/PHPMailer.php';
require 'php-mailer/src/SMTP.php';
require 'php-mailer/src/Exception.php';

if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

	// Your Google reCAPTCHA generated Secret Key here
	$secret = '6Lfe08UeAAAAAN6wME4PzSXANB5FP9aq0WuVQgvC';
	
	if( ini_get('allow_url_fopen') ) {
		//reCAPTCHA - Using file_get_contents()
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		$responseData = json_decode($verifyResponse);
	} else if( function_exists('curl_version') ) {
		// reCAPTCHA - Using CURL
		$fields = array(
	        'secret'    =>  $secret,
	        'response'  =>  $_POST['g-recaptcha-response'],
	        'remoteip'  =>  $_SERVER['REMOTE_ADDR']
	    );

	    $verifyResponse = curl_init("https://www.google.com/recaptcha/api/siteverify");
	    curl_setopt($verifyResponse, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($verifyResponse, CURLOPT_TIMEOUT, 15);
	    curl_setopt($verifyResponse, CURLOPT_POSTFIELDS, http_build_query($fields));
	    $responseData = json_decode(curl_exec($verifyResponse));
	    curl_close($verifyResponse);
	} else {
		$arrResult = array ('response'=>'error','errorMessage'=>'You need CURL or file_get_contents() activated in your server. Please contact your host to activate.');
		echo json_encode($arrResult);
		die();
	}

	if($responseData->success) {

		// Step 1 - Enter your email address below.
		$email = 'info@cherryserb.com';

		// If the e-mail is not working, change the debug option to 2 | $debug = 2;
		$debug = 0;

		// If contact form don't have the subject input, change the value of subject here
		$subject = ( isset($_POST['subject']) ) ? $_POST['subject'] : 'Define subject in php/contact-form-recaptcha.php line 62';

		$message = '<html>
		<style>
			@media only screen and (max-width: 600px) {
		.main {
			width: 320px !important;
		}

		.top-image {
			width: 100% !important;
		}
		.inside-footer {
			width: 320px !important;
		}
		table[class="contenttable"] { 
			width: 320px !important;
			text-align: left !important;
		}
		td[class="force-col"] {
			display: block !important;
		}
		 td[class="rm-col"] {
			display: none !important;
		}
		.mt {
			margin-top: 15px !important;
		}
		*[class].width300 {width: 255px !important;}
		*[class].block {display:block !important;}
		*[class].blockcol {display:none !important;}
		.emailButton{
			width: 100% !important;
		}

		.emailButton a {
			display:block !important;
			font-size:18px !important;
		}

	}
		</style>
  <body link="#8C0000" vlink="#8C0000" alink="#8C0000">

<table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
		<tr>
			<td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px; ">
				<table style="width: 100%; font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
					<tr>
						<td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #8C0000; text-align: center">
							<a href="https://cherryserb.com"><img class="top-image" src="https://cherryserb.com/assets/img/logos/logo-header-cherry.png" style="line-height: 1; width: 150px; margin-top: 20px;" alt="Privatni doktori Cacak."></a>
						</td>
					</tr>
					<tr>
						<td valign="top" class="side title" style="border-collapse: collapse;border: 0;margin: 0;padding: 20px;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;vertical-align: top;background-color: white;border-top: none;">
							<table style="font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif; width: 100%;">
								<tr>
									<td class="top-padding" style="border-collapse: collapse;border: 0;margin: 0;padding: 15px 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 21px;">
										<hr size="1" color="#eeeff0">
									</td>
								</tr>
								<tr>
									<td class="text" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;">
									<div class="mktEditable" id="main_text">';

		foreach($_POST as $label => $value) {
			if( $label != 'g-recaptcha-response' ) {
				$label = ucwords($label);

				// Use the commented code below to change label texts. On this example will change "Email" to "Email Address"

				// if( $label == 'Email' ) {               
				// 	$label = 'Email Address';              
				// }

				// Checkboxes
				if( is_array($value) ) {
					// Store new value
					$value = implode(', ', $value);
				}

				$message .= $label.": " . nl2br(htmlspecialchars($value, ENT_QUOTES)) . "<br>";
			}
		}

		$message .= '</div>
		</td>
	</tr>
	<tr>
		<td style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 24px;">
		 &nbsp;<br>
		</td>
	</tr>
</table>
</td>
</tr>
								   

<tr bgcolor="#fff" style="border-top: 4px solid #8C0000;">
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>';

		$mail = new PHPMailer(true);

		try {

			$mail->SMTPDebug = $debug;                                 // Debug Mode

			// Step 2 (Optional) - If you don't receive the email, try to configure the parameters below:

			$mail->IsSMTP();                                         // Set mailer to use SMTP
			$mail->Host = 'mail.cherryserb.com';				       // Specify main and backup server
			$mail->SMTPAuth = true;                                  // Enable SMTP authentication
			$mail->Username = 'noreply@cherryserb.com';                    // SMTP username
			$mail->Password = 'bHt2[G[[${y&';                              // SMTP password
			$mail->SMTPSecure = 'ssl';                               // Enable encryption, 'ssl' also accepted
			$mail->Port = 465;   								       // TCP port to connect to

			$mail->AddAddress($email);	 						       // Add another recipient

			//$mail->AddAddress('person2@domain.com', 'Person 2');     // Add a secondary recipient
			//$mail->AddCC('person3@domain.com', 'Person 3');          // Add a "Cc" address. 
			//$mail->AddBCC('person4@domain.com', 'Person 4');         // Add a "Bcc" address. 

			// From - Name
			$fromName = ( isset($_POST['name']) ) ? $_POST['name'] : 'Website User';
			$mail->SetFrom($email, 'Poruka sa sajta');

			// Repply To
			if( isset($_POST['email']) && !empty($_POST['email']) ) {
				$mail->AddReplyTo($_POST['email'], $fromName);
			}

			$mail->IsHTML(true);                                  // Set email format to HTML

			$mail->CharSet = 'UTF-8';

			$mail->Subject = $subject;
			$mail->Body    = $message;

			$mail->Send();
			$arrResult = array ('response'=>'success');

		} catch (Exception $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->errorMessage());
		} catch (\Exception $e) {
			$arrResult = array ('response'=>'error','errorMessage'=>$e->getMessage());
		}

		if ($debug == 0) {
			echo json_encode($arrResult);
		}

	} else {
		$arrResult = array ('response'=>'error','errorMessage'=>'reCaptcha Error: Verifcation failed (no success). Please contact the website administrator.');
		echo json_encode($arrResult);
	}

} else { 
	$arrResult = array ('response'=>'error','errorMessage'=>'reCaptcha Error: Invalid token. Please contact the website administrator.');
	echo json_encode($arrResult);
}