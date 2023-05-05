<!DOCTYPE html>
<html>
  <head>
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-sX6lZ1Qn4U6EW53U6hhC28zN/xwO83Xd3NqQ2KjTf9d07TE43rkF/7egT06T/pH89pLOdRuG0K0gqu6YJY6+vQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
    <h1>Registration Form</h1>
<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get form data
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  // Check if passwords match
  if ($password !== $confirm_password) {
    echo '<p style="color: red;">Passwords do not match.</p>';
  } else {
    // Generate avatar
    $avatar = generateAvatar($username);
    // Insert user data into database
    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "avatar_generator";
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    // Check if user already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
      echo '<p style="color: red;">User already exists.</p>';
    } else {
      // Insert user data into database
      $sql = "INSERT INTO users (username, email, password, avatar) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $email, $password, $avatar);
if ($stmt->execute()) {
    $_SESSION['email'] = $email;
    header("Location: profile.php");
    exit();
} else {
    echo '<p style="color: red;">Error: ' . $sql . '<br>' . $conn->error . '</p>';
}
    }
  }
}

function generateAvatar($username) {
  $colors = ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', 
            '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D'];
  $backgroundColor = $colors[rand(0, count($colors) - 1)];
  $initials = '';
  $words = explode(' ', $username);
  foreach ($words as $word) {
    $initials .= $word[0];
  }
  return '<div class="avatar" style="background-color: '.$backgroundColor.';"><span class="avatar-text">'.$initials.'</span></div>';
}
?>
<form method="POST" enctype="multipart/form-data">
  <label for="username">Username</label>
  <input type="text" id="username" name="username" placeholder="Enter your username" required>

  <label for="email">Email</label>
  <input type="email" id="email" name="email" placeholder="Enter your email" required>

  <label for="password">Password</label>
  <input type="password" id="password" name="password" placeholder="Enter your password" required>

  <label for="confirm_password">Confirm Password</label>
  <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>

  <label for="avatar">Avatar</label>
  <input type="file" id="avatar" name="avatar" accept="image/*" required>

  <input type="submit" value="Register">
</form>
</body>
</html>