<?php
session_start();

// Define the database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dental_clinic";

// Create a new PDO object and set the error mode to exceptions
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check the database for a matching username and password
    $stmt = $pdo->prepare("SELECT access_level FROM access WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $row = $stmt->fetch();
    
    if ($row) {
        // Set the session variable based on the user's access level
        $_SESSION['access_level'] = $row['access_level'];
        
        // Redirect the user to the appropriate page based on their access level
        if ($row['access_level'] == 'admin') {
            header('Location: admin.php');
            exit;
        } else if ($row['access_level'] == 'doctor') {
            header('Location: history.php');
            exit;
        } else if ($row['access_level'] == 'assistant') {
            header('Location: index.php');
            exit;
        }
    } else {
        // If no matching user was found in the database, display an error message
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dental Clinic Management System</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
			background-image: url();
		
			
			background-repeat: no-repeat;
			background-position: center center;
			background-attachment: fixed;
		}
		.logo {
			display: block;
			margin: 0 auto;
			width: 200px;
			height: 200px;
			background-image: url(logo1.jpg);
			background-size: cover;
			background-repeat: no-repeat;
			background-position: center center;
		}
		h1{
			color: #2ab5db;
			text-align: center;
		}
        h2{
			color: #f17d2b;
			text-align: center;
		}
		form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: transparent;
			background-image: linear-gradient(#2ab5db,#3b6eb5);
            border: 1px solid #ccc;
            border-radius: 5px;
		}
		label {
			display: block;
			margin-bottom: 10px;
			font-weight: bold;
            color: #ffffff;
		}
		input, textarea, select {
			display: block;
			width: 100%;
			padding: 10px;
			margin-bottom: 20px;
			border: 1px solid #ccc;
			border-radius: 5px;
			box-sizing: border-box;
		}
		button[type="submit"] {
			background-color: #f17d2b;
			color: #ffffff;
			border: none;
			border-radius: 5px;
			padding: 10px 20px;
			cursor: pointer;
		}
		button[type="submit"]:hover {
			background-color: #ffffff;
		}
		table {
			border-collapse: collapse;
			width: 100%;
		}
		
		th, td {
			text-align: left;
			padding: 8px;
		}
		
		th {
			background-color: #51d3f7;
			color: white;
		}
		
		tr:nth-child(even){background-color: #f2f2f2}
        
	</style>
</head>
<body>
	<div class="logo"></div>
	<h1>Welcome to the Dental Clinic Management System</h1>
	<?php if (isset($error)) { ?>
		<p><?php echo $error; ?></p>
	<?php } ?>
	<form action="login.php" method="post">
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" required>
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required>
		<button type="submit">Login</button>
	</form>
</body>
</html>