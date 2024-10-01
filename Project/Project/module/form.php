<?php

require_once '../system/access.php';

$facility = $_POST['facility'];
$start = $_POST['start'];
$end = $_POST['end'];
$purpose = $_POST['purpose'];
$email = $_POST['email'];
$persons = intval($_POST['persons']);
$consent = isset($_POST['consent']) ? 1 : 0;
$booking_id = uniqid();
date_default_timezone_set('UTC');
$current_time = date('Y-m-d H:i:s'); 
$new_time = date('Y-m-d H:i:s', strtotime($current_time . ' +2 hours')); 

$facility_id = null;
if ($facility == 'hriste') {
    $facility_id = '4b3403665fea7';
} elseif ($facility == 'sokolovna') {
    $facility_id = 'ax4179dh56trd';
}

$stmt_check = $conn->prepare("SELECT COUNT(*) FROM booking WHERE facility_id = ? AND ((date_start < ? AND date_end > ?) OR (date_start < ? AND date_end > ?) OR (date_start >= ? AND date_end <= ?))");
if ($stmt_check === false) {
    die("Příprava selhala: " . $conn->error);
}

$stmt_check->bind_param("sssssss", $facility_id, $end, $start, $start, $end, $start, $end);
$stmt_check->execute();
$stmt_check->bind_result($count);
$stmt_check->fetch();
$stmt_check->close();

if ($count > 0) {
    die("Zvolený termín je již zarezervován.");
}

$stmt1 = $conn->prepare("INSERT INTO booking (id, facility_id, date_start, date_end, state) VALUES (?, ?, ?, ?, ?)");
if ($stmt1 === false) {
    die("Příprava selhala: " . $conn->error);
}

$state = 1;
$stmt1->bind_param("ssssi", $booking_id, $facility_id, $start, $end, $state);

if ($stmt1->execute() === true) {
    echo "";
} else {
    echo "Chyba: " . $stmt1->error;
}

$booking_log_id = uniqid();

$stmt2 = $conn->prepare("INSERT INTO booking_log (id, booking_id, time, event, value) VALUES (?, ?, ?, ?, ?)");
if ($stmt2 === false) {
    die("Příprava selhala: " . $conn->error);
}

$event = 'create';
$value = 1;

$stmt2->bind_param("sssss", $booking_log_id, $booking_id, $new_time, $event, $value,);

if ($stmt2->execute() === true) {
    echo "Nová rezervace byla úspěšně vytvořena.";
} else {
    echo "Chyba: " . $stmt2->error;
}

$meta_data = [
    ['name' => 'purpose', 'value' => $purpose],
    ['name' => 'email', 'value' => $email],
    ['name' => 'people', 'value' => $persons]
];

$meta_id = uniqid();

$error_occurred = false; 
$success_message = ''; 

foreach ($meta_data as $meta) {
    $meta_id = uniqid();
    $stmt3 = $conn->prepare("INSERT INTO booking_meta (id, booking_id, name, value) VALUES (?, ?, ?, ?)");
    if ($stmt3 === false) {
        die("Příprava selhala: " . $conn->error);
    }
    $stmt3->bind_param("ssss", $meta_id, $booking_id, $meta['name'], $meta['value']);
    if ($stmt3->execute() === false) {
        $error_occurred = true; 
        echo "Chyba: " . $stmt3->error;
    } else {
        
        $success_message = "Meta data byla úspěšně uložena.";
    }
    
}

if (!$error_occurred && !empty($success_message)) {
    echo "<script>console.log('" . $success_message . "');</script>";
}

$stmt1->close();
$stmt2->close();
$stmt3->close();
$conn->close();
?>
