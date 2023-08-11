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
    if (isset($_POST['logout'])) {
        // If the user clicked the "logout" button, destroy the session and redirect to the login page
        session_destroy();
        header('Location: login.php');
        exit;
    } else if (isset($_POST['add_user'])) {
        // If the user submitted the "add user" form, insert the data into the database
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $access_level = $_POST['access_level'];
        
        $stmt = $pdo->prepare("INSERT INTO access (name, username, password, access_level) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $username, $password, $access_level]);
        
        header('Location: admin.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Page - Dental Clinic Management System</title>
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
    
	nav {
		background-color: #0077cc;
		color: #fff;
		height: 60px;
	}
	nav ul {
		padding: 0;
		margin: 0;
		list-style-type: none;
		display: flex;
		justify-content: space-between;
		align-items: center;
		height: 100%;
	}
	nav ul li {
		margin: 0 10px;
	}
	nav ul li a {
		color: #fff;
		text-decoration: none;
	}
	nav ul li a:hover {
		text-decoration: underline;
	}
	nav ul li:last-child {
		margin-right: 0;
	}
	nav form {
		margin: 0;
		height: 20px;

	}
	nav input[type="submit"] {
		background-color: transparent;
		color: #fff;
		border: none;
		cursor: pointer;
	}
	nav input[type="submit"]:hover {
		text-decoration: underline;
	}
	</style>
</head>
<body>
<nav>
		<ul>
			<li><a href="index.php">Register</a></li>
			<?php if ($_SESSION['access_level'] == 'admin') { ?>
				<li><a href="admin.php">Admin</a></li>
			<?php } else if ($_SESSION['access_level'] == 'doctor') { ?>
				<li><a href="history.php">Doctor</a></li>
			<?php } else if ($_SESSION['access_level'] == 'assistant') { ?>
				<li><a href="index.php">Assistant</a></li>
			<?php } ?>
			<li>
				<form method="post">
					 <input type="submit" name="logout" value="Logout">
				</form>
			</li>
		</ul>
	</nav>
	<h1> Dental Clinic Management System</h1>
	<h1>WELCOME ADMIN<h1>
	
	<h2>Add Doctor or Assistant</h2>
	<form action="admin.php" method="post">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" required>
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" required>
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required>
		<label for="access_level">Access Level:</label>
		<select id="access_level" name="access_level">
			<option value="doctor">Doctor</option>
			<option value="assistant">Assistant</option>
		</select>
        <button type="submit" name="add_user">Add User</button>
	</form>
	<!-- Add code for displaying a list of doctors and assistants here -->
</body>
</html>