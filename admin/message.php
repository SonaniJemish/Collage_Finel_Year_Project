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

if (isset($_GET['confid'])) {
  $bookingId = $_GET['confid'];
  $query = "SELECT * FROM submitbooking WHERE bookingid='$bookingId'";
  $result = mysqli_query($conn, $query);

  if ($row = mysqli_fetch_assoc($result)) {
    $mobile = $row['contact'];
    $message = "Your booking with ID $bookingId has been confirmed. Thank you!";
    $username = "sonanijemish7012@gmail.com"; // Replace with your actual username
    $hash = "60a9b67dbfd0a3d3be80aacead9ce83e1e67b8fe82189000dbb6fa78285f359e"; // Replace with your actual hash

    $sender = "TXTLCL";
    $numbers = $mobile;
    $message = urlencode($message);
    $api_data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=0";

    $ch = curl_init("http://api.textlocal.in/send/?" . $api_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Head section content -->
</head>
<body>
  <table border="1">
    <thead>
      <!-- Table header content -->
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_array($data)) {
        $mobile = $row['contact'];
        ?>
        <tr>
          <!-- Table row content -->
          <td>
            <a href="index.php?delid=<?= $row['bookingid'] ?>" type="button" class="btn btn-large">Delete</a><br>
            <?php if (!empty($mobile) && empty($row['confirmation'])) { ?>
              <a href="index.php?confid=<?= $row['bookingid'] ?>" type="button" class="btn btn-large">Confirm</a>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>
</html>
