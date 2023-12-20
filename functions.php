<?php
include 'assets/vendor/autoload.php';

use setasign\Fpdi\Fpdi;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

session_start();
// initializing variables
$username = "";
$email = "";
$errors = array();
$errors2 = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'rackiot');

if (isset($_GET['logout'])) {
    session_destroy();
    header("location: login.php");
}


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

if (isset($_GET['api_key'])) {
    $query = "SELECT * FROM data LIMIT  1 ";
    $result = mysqli_query($db, $query);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data["v1"] = $row['v1'];
        $data["v2"] = $row['v2'];
    }
    echo json_encode($data);

}

if (isset($_POST['receivedatalog'])) {

    if (isset($_SESSION["time1"])) {
        $time1 = $_SESSION["time1"];
        $time2 = $_SESSION["time2"];

        $query = "SELECT id, reading_time,device,temp,v1,v2,battery,DATE_FORMAT(reading_time, '%H:%i:%s'),DATE_FORMAT(reading_time, '%d-%m-%Y') FROM  data WHERE  reading_time BETWEEN '$time1' AND '$time2' ORDER BY reading_time DESC LIMIT  10 ";
        $result = mysqli_query($db, $query);
        // echo $query;
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
if (isset($_POST['resetmasa'])) {
    unset($_SESSION["time1"]);
    unset($_SESSION["time2"]);

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
    $tableb->endTable();

    $tablebahB = new easyTable($pdf, '%{10,24,22,22,22}', 'border:0;font-size:8;');
    if (isset($_SESSION["time1"])) {
        $time1 = $_SESSION["time1"];
        $time2 = $_SESSION["time2"];

        $query = "SELECT id, reading_time,device,temp,v1,v2,battery,DATE_FORMAT(reading_time, '%H:%i:%s'),DATE_FORMAT(reading_time, '%d-%m-%Y') FROM  data WHERE  reading_time BETWEEN '$time1' AND '$time2' ORDER BY reading_time DESC LIMIT  10 ";
    } else {

        $query = "SELECT id, reading_time,device,temp,v1,v2,battery,DATE_FORMAT(reading_time, '%H:%i:%s'),DATE_FORMAT(reading_time, '%d-%m-%Y') FROM data ORDER BY reading_time DESC LIMIT  10 ";

    }
    $result = mysqli_query($db, $query);
    $counter = 1;
    while ($row = $result->fetch_assoc()) {

        $tablebahB->easyCell($counter);
        $tablebahB->easyCell($row['reading_time']);
        $tablebahB->easyCell($row['temp']);
        $tablebahB->easyCell($row['v1']);
        $tablebahB->easyCell($row['v2']);
        $tablebahB->printRow();
        $counter += 1;
    }
    // $tablebahB->easyCell('asasa');
    // $tablebahB->printRow();

    $tablebahB->endTable();

    $pdf->Output();

    ob_end_flush();

}


function sendemail_alert($receiver, $v1, $v2, $temp)
{


    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.google.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'info@tabikakemas.com.my';                     //SMTP username
        $mail->Password = 'tabikakemas33';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


        //Recipients
        $mail->setFrom('info@tabikakemas.com.my', 'Tabika Kemas');
        $mail->addAddress($receiver);     //Add a recipient

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $tarikh = date('M Y');
        $mail->Subject = "Kemasukan Tidak Diterima";
        ob_start();
        require_once 'assets/email/kemasukantak.php';
        $output = ob_get_clean();
        $mail->Body = $output;




        $mail->send();
        // echo 'Message has been sent';

    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        // array_push($errors2, "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");

    }
}

if (isset($_POST['sub'])) {
    // (B) GET SUBSCRIPTION
    $sub = Subscription::create(json_decode($_POST["sub"], true));
    // $endpoint = 'https://fcm.googleapis.com/fcm/send/abcdef...'; // Chrome

    // (C) NEW WEB PUSH OBJECT - CHANGE TO YOUR OWN!
    $push = new WebPush(["VAPID" => [
        "subject" => "izmeera2000@gmail.com",
        "publicKey" => "BAvoKBUHaF1sy1-l2mUdTlMls0zwsYpsCmXvLsxXpLdeYTnKOZvS--Ia9HgQuTINB9EeVwzhRUYwBNxZOc84axI",
        "privateKey" => "qbpOKMoIFMtAnlflzmKlxO94NCfv4fzSlaPkTXYwqDY"
    ]]);

    // (D) SEND TEST PUSH NOTIFICATION
    $result = $push->sendOneNotification($sub, json_encode([
        "title" => "Selamat Datang!",
        "body" => "Sila Tunggu",
        "icon" => "assets/img/favicon.ico",
        //   "image" => "assets/img/android-chrome-192x192.png"
    ]));
    $endpoint = $result->getRequest()->getUri()->__toString();

    // (E) SHOW RESULT - OPTIONAL
    if ($result->isSuccess()) {
        echo "Successfully sent {$endpoint}.";
    } else {
        echo "Send failed {$endpoint}: {$result->getReason()}";
        $result->getRequest();
        $result->getResponse();
        $result->isSubscriptionExpired();
    }
}


if (isset($_POST['edit1'])) {

    $stock1 = $_POST['val1'];

    $query = "SELECT * FROM data  ORDER BY id DESC LIMIT  1";
    $result = mysqli_query($db, $query);

    $data = array();
    while ($row = $result->fetch_assoc()) {
      // $data[] = $row;
    //   $stock1 = $row['v1'];
      $stock2 = $row['v2'];
    }

    $query = "INSERT INTO data (v1,v2) VALUES ('$stock1','$stock2')";
    $result = mysqli_query($db, $query);


}
if (isset($_POST['edit2'])) {

    $stock2 = $_POST['val2'];

    $query = "SELECT * FROM data  ORDER BY id DESC LIMIT  1";
    $result = mysqli_query($db, $query);

    $data = array();
    while ($row = $result->fetch_assoc()) {
      // $data[] = $row;
    //   $stock1 = $row['v1'];
      $stock1 = $row['v1'];
    }

    $query = "INSERT INTO data (v1,v2) VALUES ('$stock1','$stock2')";
    $result = mysqli_query($db, $query);


}
?>