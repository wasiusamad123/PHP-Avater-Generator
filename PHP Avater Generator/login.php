<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-sX6lZ1Qn4U6EW53U6hhC28zN/xwO83Xd3NqQ2KjTf9d07TE43rkF/7egT06T/pH89pLOdRuG0K0gqu6YJY6+vQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<h1>Login</h1>
<?php
if (!empty($errors)) {
  echo "<ul>";
  foreach ($errors as $error) {
    echo "<li>$error</li>";
  }
  echo "</ul>";
}
?>

	<form method="POST">
    <label for="username">Username or Email Address</label>
    <input type="text" id="username" name="login" placeholder="Enter your username or email address">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter your password">
    <input type="submit" value="Login">
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</form>

<?php
$errors = array(); // initialize an empty array to store errors

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Validate input fields
    if (empty($login)) {
        $errors[] = "Username or email address is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    // If no errors, attempt to log in
    if (empty($errors)) {
        // Check if input matches database record
        $servername = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "avatar_generator";
        $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND password = ?");
        $stmt->bind_param("sss", $login, $login, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            // Login successful, start session
            session_start();
            $user = $result->fetch_assoc();
            $_SESSION['email'] = $user['email'];
            header("Location: profile.php");
            exit();
        } else {
            // Login failed, display error message
            echo "Invalid login credentials.";
        }
        $stmt->close();
        $conn->close();
    }
}
?>
</body>
</html>
