<?php
// Enable CORS and set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain");

// Your receiving email address
$to = "blakshmisrividhya@gmail.com";

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Get and sanitize input
  $name    = strip_tags(trim($_POST["name"]));
  $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $message = trim($_POST["message"]);

  // Check for required fields
  if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Please fill in all fields correctly.";
    exit;
  }

  // Email subject
  $subject = "New message from portfolio contact form";

  // Compose message
  $email_content = "Name: $name\n";
  $email_content .= "Email: $email\n\n";
  $email_content .= "Message:\n$message\n";

  // Email headers
  $headers = "From: $name <$email>";

  // Try to send
  if (mail($to, $subject, $email_content, $headers)) {
    http_response_code(200);
    echo "Thank you! Your message has been sent.";
  } else {
    http_response_code(500);
    echo "Oops! Message could not be sent.";
  }
} else {
  http_response_code(403);
  echo "Invalid request method.";
}
?>
