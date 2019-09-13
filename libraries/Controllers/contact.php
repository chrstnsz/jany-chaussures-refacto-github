<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('../autoload.php');
// Load Composer's autoloader
require('../../vendor/autoload.php');

// hidden input pour eviter les spams bot
if (!empty($_POST['website'])){
    \Http::redirect('index.php');
};

if (!empty($_POST)) {

    $errors = array();

    if (empty($_POST['lastname']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['lastname']) || empty($_POST['firstname']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['firstname']) || empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || empty($_POST['content'])) {
        $errors['champs'] = "Renseignez les champs correctement.";
    }

    if (isset($_POST['society']) && !empty($_POST['society']) && preg_match('/^[a-zA-Z0-9_]+$/', $_POST['society'])) {
        $society = $_POST['society'];
    } else {
        $society = '';
    }

    if (empty($errors)) {
        $lastName = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $message = $_POST['content'];

        $mail = new PHPmailer();
        $mail->CharSet = "utf-8";
        $mail->SMTPDebug = 1;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'SMTP.office365.com';                   // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = '';                                     // SMTP username
        $mail->Password   = '';                                     // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;

        $mail->setFrom(''); // Personnaliser l'envoyeur
        $mail->addAddress(''); // Ajouter le destinataire

        $mail->isHTML(true); // Paramétrer le format des emails en HTML ou non

        $mail->Subject  = 'Contact';
        $mail->Body     = '<b>Vous avez un nouveau message !</b></br>'
            . 'Nom: ' . $lastName . '</br>'
            . 'Prénom: ' . $firstname . '</br>'
            . 'Société: ' . $society . '</br>'
            . 'Email: ' . $email . '</br>'
            . 'Message: ' . $message . '</br>';

        if (!$mail->send()) {
            $_SESSION['flash']['success'] = "Une erreur est survenue. Veuillez réessayer plus tard";
            echo 'Mailer error: ' . $mail->ErrorInfo;
        } else {
            $_SESSION['flash']['success'] = "Message bien envoyé !";
        }
    }
}

\Renderer::render('contact', compact(
    'errors'
));