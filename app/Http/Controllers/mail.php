<?php
/**
 * PHPMailer simple contact form example.
 * If you want to accept and send uploads in your form, look at the send_file_upload example.
 */

//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require '../vendor/autoload.php';
// require '../vendor/phpmailer/phpmailer/src/Exception.php';
// require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
// require '../vendor/phpmailer/phpmailer/src/SMTP.php';
// $name =  $_REQUEST['name'];
// $email = "olamideadebayo2001@gmail.com";
// $subject=  $_REQUEST['subject'];
// echo  $_REQUEST['message'];

$mail = new PHPMailer(true);
        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'mail.mideinc.com.ng';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'info@mideinc.com.ng';                     // SMTP username
            $mail->Password   = 'olamsyde1';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('info@muip.com', "MUIP FPL");
            $mail->addAddress($User_email);     // Add a recipient
            // $mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@mideinc.com.ng', 'Information');
            // $mail->addCC('olamide@ebis.com.ng');
            // $mail->addBCC('bcc@example.com');

            // Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);
            $loginlink = route('login');                                 // Set email format to HTML
            $mail->Subject = 'Welcome To MUIP FPL';
            $mail->Body    = "Share Your refferal link with others: $ref_link
            <br>Your email($user_email) is the referral code so others can also enter the code manually on the registration page.
            You can login <b><a href='$loginlink'>HERE</a></b> ";
            $mail->AltBody = 'Welcome to MUIP FPL. Your email is your referral code.';

            $mail->send();
            // echo "Message has been sent\n";
            $checks = "Message has been sent\n";
            Log::debug('An informational message.');
            // return $checks;
        } catch (Exception $e) {
            $checks = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            Log::debug($checks);
            // return $checks;
        }


