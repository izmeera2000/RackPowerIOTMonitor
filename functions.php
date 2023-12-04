<?php
use setasign\Fpdi\Fpdi;

session_start();
// initializing variables
$username = "";
$email = "";
$errors = array();
$errors2 = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'rackiot');



function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

if (isset($_POST['receivedata'])) {

    $query = "SELECT id, reading_time,device,temp,v1,v2,battery,DATE_FORMAT(reading_time, '%H:%i:%s') FROM data ORDER BY reading_time DESC  ";
    $result = mysqli_query($db, $query);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Close the connection

    // Encode the data as JSON and return it to the JavaScript code
    echo json_encode($data);
}






?>