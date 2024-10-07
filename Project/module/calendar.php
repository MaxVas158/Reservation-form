<?php
require_once '../system/access.php';

$sql = "SELECT date_start, date_end FROM booking";
$result = $conn->query($sql);

$events = array();

if ($result) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $events[] = array(
                'start' => $row["date_start"],
                'end' => $row["date_end"]
            );
        }
    }
} else {
    
    error_log("Chyba databáze" . $conn->error);
}

$conn->close();


echo json_encode($events);
?>