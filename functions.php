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

if (isset($_POST['api_key'])) {
    $api_key_value = "tPmAT5Ab3j7F9";
    $api_key = ($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $sensorname = ($_POST["sensor"]);
        $temp = ($_POST["temp"]);
        $v1 = ($_POST["v1"]);
        $v2 = ($_POST["v2"]);
        $batterylevel = ($_POST["batterylevel"]);
        $query = "INSERT INTO data (device,temp,v1,v2,battery) VALUES ('$sensorname','$temp','$v1','$v2','$batterylevel') ";
        $result = mysqli_query($db, $query);
    }

}




?>