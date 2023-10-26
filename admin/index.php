<?php
include "../config.php";

$select_query = "SELECT * FROM submitbooking";
$data = mysqli_query($conn, $select_query);

  if (isset($_GET['delid'])) {
    $id = $_GET['delid'];
    $query = "DELETE FROM `submitbooking` WHERE bookingid='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
      header("Location: index.php?success");
    } else {
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
  <link rel="stylesheet" href="css/animate.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/bootstrap-datepicker.css">
  <link rel="stylesheet" href="css/jquery.timepicker.css">
  <link rel="stylesheet" href="css/flaticon.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Admin</title>
  <style>
    table {
      width: 100%;
    }

    select {
      border: none;
      background-color: none;
      width: 100%;
      height: 100%;
    }

    .confbutton,
    .delbutton {
      display: inline-block;
      background-color: lightgray;
      text-decoration: none;
      padding: 5px 8px;
      width: fit-content;
      border-radius: 3px;
    }

    .confbutton {
      color: green;
      background-color: #e6ffe6;
    }

    .delbutton {
      color: red;
      background-color: #ffe6e6;

    }
  </style>
</head>

<body>
  <table border="1">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Contact</th>
        <th>Email</th>
        <th>Room Type</th>
        <th>Rooms</th>
        <th>Check In Date & Time</th>
        <th>Check Out Date & Time</th>
        <th>Payment</th>
        <th>Confirmation</th>
      </tr>
    </thead>
    <tbody>

      <?php

      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\Exception;

      require 'PHPMailer/src/PHPMailer.php';
      require 'PHPMailer/src/Exception.php';
      require 'PHPMailer/src/SMTP.php';

      while ($row = mysqli_fetch_array($data)) {
        $email = $row['email'];
        $name = $row['name'];
        $roomtype = $row['roomtype'];
        $rooms = $row['rooms'];
        $totalpayment = $row['totalpayment'];
      ?>
        <tr>
          <td><?= $row['bookingid'] ?></td>
          <td><?= $name ?></td>
          <td><?= $row['contact'] ?></td>
          <td><?= $email ?></td>
          <td><?= $roomtype ?></td>
          <td><?= $rooms ?></td>
          <td><?= $row['checkindate'] ?><br><?= $row['checkintime'] ?></td>
          <td><?= $row['checkoutdate'] ?><br><?= $row['checkouttime'] ?></td>
          <td><?= $totalpayment ?></td>

          <td align="center">
            <a href="index.php?delid=<?= $row['bookingid'] ?>" type="button" id="delbutton" class="btn delbutton ">Delete</a>
            <a onclick="clicked(this.id)" href="index.php?confid=<?= $row['bookingid'] ?>" type="button" id="confbutton_<?= $row['bookingid'] ?>" class="btn confbutton">Confirm</a>
            <?php



            if (isset($_GET['confid'])) {
              $mail = new PHPMailer(true);
              $mail->isSMTP();
              $mail->Host = 'smtp.gmail.com';
              $mail->SMTPAuth = true;
              $mail->Username = 'sonanijemish7012@gmail.com';
              $mail->Password = 'lrjwpppoylfzindm';
              $mail->SMTPSecure = 'ssl';
              $mail->Port = '465';
              $mail->setFrom('sonanijemish7012@gmail.com');
              $mail->addAddress($email);
              $mail->isHTML(true);
              $mail->Subject = ' Goassy Confirm Booking';


              $message1 = "Hello, $name Your $rooms $roomtype is booked. Please Pay $totalpayment and Enjoy. Thank you";
              $mail->Body = $message1;
              $mail->send();


              echo
              "
              <script>

                alert('Sent Successfully');
                document.location.href = 'index.php';


                function clicked(nam){
                  // let name = nam;
                  document.getElementById(nam).style.display = 'none';
                  document.getElementById(nam).disabled = true;
                  console.log(document.getElementById(nam).attributes);
                }

              </script>

              ";
            }
            ?>

          </td>
        </tr>
      <?php } ?>
    </tbody>

  </table>
</body>

</html>