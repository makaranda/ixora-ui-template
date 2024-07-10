<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mesage = '';
//Load Composer's autoloader
require 'vendor/autoload.php';

if(isset($_POST['name'],$_POST['email'],$_POST['services'],$_POST['message'],$_POST['g-recaptcha-response'])){
	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

    $secretKey = '6LezbQwqAAAAAFCe3B-DwwG1A1eVwGdh4MGxaslk';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
    $response = file_get_contents($verifyUrl . '?secret=' . $secretKey . '&response=' . $recaptchaResponse);
    $responseData = json_decode($response);

    if ($responseData->success) {
	
        $name = $_POST['name'];
        $email = $_POST['email'];
        $services = $_POST['services'];
        $message = $_POST['message'];
        
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;   
            $mail->SMTPDebug = 0;                   //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'sigiri.globemw.net';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'support@ixoralk.com';                     //SMTP username
            $mail->Password   = 'wQJEHfHxKzOe';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('info@ixoralk.com', 'Ixoralk');
            //$mail->addAddress('makarandapathirana@gmail.com', 'Ixoralk');     //Add a recipient
            $mail->addAddress('makaranda@globemw.net', 'Ixoralk');
            //$mail->addAddress('lahirutm@globemw.net', 'Ixoralk');
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Contact Details from '.$name.'';
            $mail->Body    = '<div style="padding:2%">
                                        <table style="width:100%;background-color:#cccccc52;padding:50px 30px !important;">
                                            <tr>
                                                <td align="center"><img src="https://ixoralk.com/images/main_logo_2.png" style="width:100px"/></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table style="width:100%;background-color:#fff;padding:40px !important;">
                                                        <tr>
                                                            <td>
                                                                <table style="width:80%;">
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <h3 style="margin-bottom:10px;font-weight: 700;color: #133957;font-size: 1.5rem;font-family: math;text-decoration: underline;">Contact Information</h3>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <p style="margin-top:5px;margin-bottom:5px;font-weight:700;color: #133957;font-size: 1.03rem;font-family: math;">Contact Person Name</p>
                                                                            <p style="margin-top:5px;margin-bottom:10px;font-family: math;">'.$name.'</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <p style="margin-top:5px;margin-bottom:5px;font-weight:700;color: #133957;font-size: 1.03rem;font-family: math;">Email Address</p>
                                                                            <p style="margin-top:5px;margin-bottom:10px;font-family: math;">'.$email.'</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <p style="margin-top:5px;margin-bottom:5px;font-weight:700;color: #133957;font-size: 1.03rem;font-family: math;">Service</p>
                                                                            <p style="margin-top:5px;margin-bottom:10px;font-family: math;">'.$services.'</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <p style="margin-top:5px;margin-bottom:5px;font-weight:700;color: #133957;font-size: 1.03rem;font-family: math;">Message</p>
                                                                            <p style="margin-top:5px;margin-bottom:10px;font-family: math;">'.$message.'</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                
                                                                
                                                                <table style="width:100%;margin-top:25px;">
                                                                    <tr>
                                                                        <td>
                                                                            <p style="margin-bottom:6px;font-weight: 700;color: #33343470;font-size: .8rem;font-family: sans-serif;text-align: center;">If you did not receive this email, please check your spam or Junk mail folder.</p>
                                                                            <p style="margin-bottom:10px;font-weight: 700;color: #5c5c5ccf;font-size: .8rem;font-family: sans-serif;text-align: center;">Copyright © 2024 IXORA. All Rights Reserved.</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                
                                        </table>
                                    </div>';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if($mail->send()){
                $mesage = 'success';
            }else{
                $mesage = 'error 1';
            }
            
        } catch (Exception $e) {
            $mesage = 'error 2';
        }
    }else{
        $mesage = 'recaptcha_error';
    }    
}else{
	$mesage = 'error 3';
}

echo $mesage;