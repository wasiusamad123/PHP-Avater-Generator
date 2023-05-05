<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
  // Redirect to login page
  header('Location: login.php');
  exit;
}

// Get user ID from session
$email = $_SESSION['email'];

// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "avatar_generator";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve user data
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $username = $row['username'];
  $email = $row['email'];
  $avatar = $row['avatar'];
} else {
  echo "Error: User not found";
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Profile</title>
  <style>
    .avatar {
      display: inline-block;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      text-align: center;
      line-height: 100px;
      font-size: 36px;
      font-weight: bold;
      color: #ffffff;
    }
  </style>
</head>
<body>
  <h1>View Profile</h1>
  <div class="avatar" style="background-color: #<?php echo substr(md5($username), 0, 6); ?>;"><?php echo substr($username, 0, 1); ?></div>
  <p>Username: <?php echo $username; ?></p>
  <p>Email: <?php echo $email; ?></p>
  <p>Avatar: <?php echo $avatar; ?></p>
  
  <form action="logout.php" method="post">
    <button type="submit">Logout</button>
  </form>
</body>
</html>
