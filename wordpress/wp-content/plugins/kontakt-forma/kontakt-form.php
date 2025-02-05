<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
/*
Plugin Name: Custom Contact Form
Description: Jednostavni plugin za WordPress koji dodaje kontakt formu s validacijom i stilizacijom.
Version: 1.1
Author: Lucija Barišić
*/


// Dodavanje CSS i JS datoteka
function custom_contact_form_assets()
{
    wp_enqueue_style('custom-contact-form-css', plugin_dir_url(__FILE__) . 'css/style.css');
    wp_enqueue_script('custom-contact-form-js', plugin_dir_url(__FILE__) . 'js/script.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'custom_contact_form_assets');

// Dodavanje kratkog koda za prikaz kontakt forme
function custom_contact_form()
{
    ob_start();

?>
    <div class="contact-form-container">
        <form id="contact-form" method="post">
            <div>
                <label for="name">Ime:</label>
                <input type="text" id="userName" name="userName" title="Ime je obavezno" />
                <div id="nameError" style="color: red;"></div>
            </div>

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" title="Unesite ispravan email" />
                <div id="emailError" style="color: red;"></div>
            </div>

            <div>
                <label for="phone">Broj mobitela:</label>
                <input type="tel" id="phone" name="phone" title="Unesite ispravan broj mobitela" />
                <div id="phoneError" style="color: red;"></div>
            </div>

            <div>
                <label for="message">Poruka:</label>
                <textarea id="message" name="message" title="Poruka je obavezna"></textarea>
                <div id="messageError" style="color: red;"></div>
            </div>
            <div id="form-message" style="color: red;"></div>

            <button type="button" id="posalji-kontakt">Pošalji</button>
        </form>

    </div>
<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = sanitize_text_field($_POST['userName']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $message = sanitize_textarea_field($_POST['message']);

        // Provjera server-side validacije
        if (!empty($name) && !empty($email) && !empty($phone) && !empty($message)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^\+?[0-9]{9,15}$/', $phone)) {
                // Slanje emaila (primjer, postavite svoje postavke)
                $to = get_option('admin_email');
                $subject = "Nova poruka s kontakt forme";
                $body = "Ime: $name\nEmail: $email\nBroj mobitela: $phone\n<div style='color:red;'>Poruka:<br>$message</div>";
                // $headers = ["Content-Type: text/plain; charset=UTF-8"];

                try {
                    $mail = new PHPMailer(true);
                    //Server settings
                    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;  //Enable verbose debug output
                    $mail->isSMTP();      //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';  //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;   //Enable SMTP authentication
                    $mail->Username   = $to;    //SMTP username
                    $mail->Password   = 'fwap detw yxhm fxkd';  //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                    $mail->Port       = 465;  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom($email, 'Mailer');
                    $mail->addAddress('lucija.barisic24@gmail.com', 'Joe User'); //Add a recipient

                    //Content
                    $mail->isHTML(true);    //Set email format to HTML
                    $mail->Subject = $subject;
                    $mail->Body    = $body;
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    if (!$mail->send()) {
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    } else {
                        echo 'Poruka poslana!';
                        echo "<script>window.location.replace('http://localhost/Kuharica_CMS/wordpress/kontakt/');</script>";
                    }
                    // echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Nije moguće poslati poruku. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo '<p style="color:red;">Uneseni podaci nisu ispravni.</p>';
            }
        } else {
            echo '<p style="color:red;">Sva polja su obavezna.</p>';
        }
    }

    return ob_get_clean();
}
add_shortcode('contact_form', 'custom_contact_form');
