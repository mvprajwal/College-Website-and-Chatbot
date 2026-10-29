<?php
// Configure these values for your hosting provider before deployment.
mysqli_report(MYSQLI_REPORT_OFF);
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_NAME') ?: 'college_form';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed.');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address = trim($_POST['project'] ?? ''); // Kept to match the existing form field.
$course = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $phone === '' || $course === '') {
    http_response_code(400);
    exit('Please provide your name, phone number, and course.');
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit('Please provide a valid email address.');
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    error_log('College form database connection failed: ' . $conn->connect_error);
    http_response_code(500);
    exit('We could not submit your application right now. Please try again later.');
}
$conn->set_charset('utf8mb4');
$stmt = $conn->prepare('INSERT INTO admissions (name, email, phone, address, course, message) VALUES (?, ?, ?, ?, ?, ?)');
if (!$stmt) {
    error_log('College form statement preparation failed: ' . $conn->error);
    http_response_code(500);
    exit('We could not submit your application right now. Please try again later.');
}
$stmt->bind_param('ssssss', $name, $email, $phone, $address, $course, $message);
if ($stmt->execute()) {
    echo 'Application submitted successfully!';
} else {
    error_log('College form insert failed: ' . $stmt->error);
    http_response_code(500);
    echo 'We could not submit your application right now. Please try again later.';
}
$stmt->close();
$conn->close();
?>
