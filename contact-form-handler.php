<?php
// Simple contact form handler for XAMPP local development.
// Update the recipient email address below before using in production.

$recipient = 'hello@mwakalobo.dev';
$subject = 'New portfolio contact request';
$redirect = 'contact.html?status=success';
$errorRedirect = 'contact.html?status=error';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    $service = trim(filter_input(INPUT_POST, 'service', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $budget = trim(filter_input(INPUT_POST, 'budget', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    if (!$name || !$email || !$message) {
        header('Location: ' . $errorRedirect);
        exit;
    }

    $body = "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Service: $service\n";
    $body .= "Budget: $budget\n\n";
    $body .= "Message:\n$message\n";

    $headers = "From: $name <$email>\r\n" .
               "Reply-To: $email\r\n" .
               "X-Mailer: PHP/" . phpversion();

    if (mail($recipient, $subject, $body, $headers)) {
        header('Location: ' . $redirect);
    } else {
        header('Location: ' . $errorRedirect);
    }
    exit;
}

header('Location: ' . $errorRedirect);
exit;
