<?php
include 'assets/vendor/autoload.php';

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

    $query = "SELECT id, reading_time,device,temp,v1,v2,battery,DATE_FORMAT(reading_time, '%H:%i:%s') FROM data ORDER BY reading_time DESC LIMIT  10";
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
    if ($api_key == $api_key_value) {
        $sensorname = ($_POST["sensor"]);
        $temp = ($_POST["temp"]);
        $v1 = ($_POST["v1"]);
        $v2 = ($_POST["v2"]);
        $batterylevel = ($_POST["batterylevel"]);
        $query = "INSERT INTO data (device,temp,v1,v2,battery) VALUES ('$sensorname','$temp','$v1','$v2','$batterylevel') ";
        $result = mysqli_query($db, $query);
    }

}

if (isset($_POST['receivedatalog'])) {

    if (isset($_SESSION["time1"])) {
        $time1 = $_SESSION["time1"];
        $time2 = $_SESSION["time2"];

        $query = "SELECT id, reading_time,device,temp,v1,v2,battery,DATE_FORMAT(reading_time, '%H:%i:%s'),DATE_FORMAT(reading_time, '%d-%m-%Y') FROM  data WHERE  reading_time BETWEEN '$time1' AND '$time2' ORDER BY reading_time DESC LIMIT  10 ";
        $result = mysqli_query($db, $query);
        echo $query;
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

    } else {
        $query = "SELECT id, reading_time,device,temp,v1,v2,battery,DATE_FORMAT(reading_time, '%H:%i:%s'),DATE_FORMAT(reading_time, '%d-%m-%Y') FROM data ORDER BY reading_time DESC LIMIT  10 ";
        $result = mysqli_query($db, $query);

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

    }


    // Close the connection

    // Encode the data as JSON and return it to the JavaScript code
    echo json_encode($data);
}


if (isset($_POST['setmasa'])) {
    debug_to_console("asasasasa");
    $date1 = date('Y-m-d H:i:s', strtotime($_POST['time1']));

    $date2 = date('Y-m-d H:i:s', strtotime($_POST['time2']));


    $_SESSION["time1"] = $date1;
    $_SESSION["time2"] = $date2;
    // echo "asasaasdasdasdasdasdasdasdasdasdas";
    // debug_to_console($date1);
}

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $password_3 = mysqli_real_escape_string($db, $_POST['password_3']);

    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    if ($password_3 != "rackpoweriot") {
        array_push($errors, "Wrong Admin password");
    }

    // $checkexists = $db_handle->runQuery("SELECT * FROM users WHERE username='$username'  ");
    // $query = "INSERT INTO users (username,password) VALUES ('$username','$password') ";
    $query = "SELECT * FROM users WHERE username='$username'";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) {
        if (!empty($checkexists)) {
            array_push($errors, "Username already exists");
        }


    }
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database
        $query = "INSERT INTO users (username,password) VALUES ('$username','$password') ";
        $result = mysqli_query($db, $query);

        //   $_SESSION['username'] = $username;
        header('location: login.php');

    }
}

if (isset($_POST['login'])) {


    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    if (count($errors) == 0) {
        $password = md5($password);


        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'  ";
        $results = mysqli_query($db, $query);


        if (mysqli_num_rows($results) == 1) {
            $_SESSION['username'] = $username;

            // $_SESSION['accesslevel'] = $row["accesslevel"];
            header('location: index.php');



        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }




}
if (isset($_POST['pdf'])) {
    ob_start();
    require('assets/vendor/fpdf/fpdf.php');
    require('assets/vendor/fpdi/src/autoload.php');

    require('assets/vendor/fpdf/exfpdf.php');
    require('assets/vendor/fpdf/easyTable.php');



    // Instanciation of inherited class
    $pdf = new exFPDF('P', 'mm', 'A4');

    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 10);

    $tableb = new easyTable($pdf, '%{100}', 'border:0;font-size:8;');
    $tableb->easyCell('', 'img:assets/img/android-chrome-192x192.png,w40;valign:M;  align:C');
    $tableb->printRow();

    $pdf->Output();

    ob_end_flush(); 

}
?>