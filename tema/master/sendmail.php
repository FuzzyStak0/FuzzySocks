<?php

require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/class.smtp.php');

$mail = new PHPMailer();

$mail->SMTPDebug = 0;                               // Enable verbose debug output
$mail->isSMTP();
$mail->ContentType = 'text/html';                                      // Set mailer to use SMTP
$mail->Host = 'mail.privatnidoktoricacak.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                                             // Enable SMTP authentication
$mail->Username = 'noreply@privatnidoktoricacak.com';                 // SMTP username
$mail->Password = 'MlU=B0SsNoe9';             // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = '465';                                    // TCP port to connect to
$mail->CharSet = 'utf-8';

$message = "";
$status = "false";

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if( $_POST['dzName'] != '' AND $_POST['dzEmail'] != '' ) {

        $name = $_POST['dzName'];
        $email = $_POST['dzEmail'];
        $subject = $_POST['dzSubject'];
        $phone = $_POST['dzPhone'];
        $messageF = $_POST['dzMessage'];

        $subject = isset($subject) ? $subject : 'New Message | Contact Form';

        $botcheck = "";

        $toemail = 'info@privatnidoktoricacak.com'; // Your Email Address
        $toname = 'template_path'; // Your Name

        if( $botcheck == '' ) {

            $mail->Subject = $subject;

            $mail->SetFrom('noreply@privatnidoktoricacak.com', 'noreply');
            // $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );

            $body = '<html>
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
      <body link="#2268A7" vlink="#2268A7" alink="#2268A7">
    
    <table class=" main contenttable" align="center" style="font-weight: normal;border-collapse: collapse;border: 0;margin-left: auto;margin-right: auto;padding: 0;font-family: Arial, sans-serif;color: #555559;background-color: white;font-size: 16px;line-height: 26px;width: 600px;">
            <tr>
                <td class="border" style="border-collapse: collapse;border: 1px solid #eeeff0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px; ">
                    <table style="width: 100%; font-weight: normal;border-collapse: collapse;border: 0;margin: 0;padding: 0;font-family: Arial, sans-serif;">
                        <tr>
                            <td colspan="4" valign="top" class="image-section" style="border-collapse: collapse;border: 0;margin: 0;padding: 0;-webkit-text-size-adjust: none;color: #555559;font-family: Arial, sans-serif;font-size: 16px;line-height: 26px;background-color: #fff;border-bottom: 4px solid #2268A7; text-align: center">
                                <a href="https://privatnidoktoricacak.com/"><img class="top-image" src="https://privatnidoktoricacak.com/images/logo.png" style="line-height: 1; width: 150px; margin-top: 20px;" alt="Privatni doktori Cacak."></a>
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
                                        <div class="mktEditable" id="main_text">
                                           Ime i Prezime: <strong>' . $name . '</strong> <br><br>
                                           Email: <strong>' . $email . '</strong> <br><br>
                                           Telefon: <strong>' . $phone . '</strong> <br><br>
                                           Tekst Poruke: ' . $messageF . ' <br><br>
                                        </div>
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
                                                                   
                       
                        <tr bgcolor="#fff" style="border-top: 4px solid #2268A7;">
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
      </body>
        </html>';

            $mail->Body = $body;
            $mail->isHTML(true);
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                //include __DIR__.'/successMail.php';
                $status = "true";
            else:
                //include __DIR__.'/errorMail.php';
                $status = "false";
            endif;
        } else {
            //include __DIR__.'/errorMail.php';
            $status = "false";
        }
    } else {
        //include __DIR__.'/errorMail.php';
        $status = "false";
        $message = 'Nisu validna sva polja';
    }
} else {
    //include __DIR__.'/errorMail.php';
    $status = "false";
}

echo json_encode([
    'status' => $status,
    'message' => $message,
]); exit();
?>