<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['logout'])) {
        // If the user clicked the "logout" button, destroy the session and redirect to the login page
        session_destroy();
        header('Location: login.php');
        exit;
    }
} else if(!isset($_SESSION['access_level'])) {
    // If the user is not logged in, redirect them to the login page
    header('Location: login.php');
    exit;
}

// If you need to restrict access to a specific access level, you could use something like this:
/*
if ($_SESSION['access_level'] != 'admin') {
    header('Location: index.html');
    exit;
}
*/
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
	<div class="logo"></div>
	<h1>Welcome to the Dental Clinic Management System</h1>
	<h2>Register Patient</h2>
	<form action="register.php" method="post">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" required>
        <label for="dob">Date of Birth:</label>
	    <input type="date" id="dob" name="dob" required>
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required>
		<label for="phone">Phone:</label>
		<input type="tel" id="phone" name="phone" required>
		<label for="address">Address:</label>
		<textarea id="address" name="address"></textarea>
		<button type="submit">Register</button>
	</form>
	<center><a href="showpatients.php" style="	background-color: #f17d2b;
		color: #ffffff;
		border: none;
		border-radius: 5px;
		padding: 10px 20px;
		cursor: pointer;
		"><button>View patients</button></a> 
		</center>	
	<h2>Schedule Appointment</h2>
<form action="schedule.php" method="post">
<label for="patient">Doctor:</label>
<input type="text" id="doctor" name="patient" required>
  <label for="patient">Patient Name:</label>
  <input type="text" id="patient" name="patient" required>
  <label for="date">Date:</label>
  <input type="date" id="date" name="date" required>
  <label for="time">Time:</label>
  <input type="time" id="time" name="time" required>
  <button type="submit">Schedule</button>
</form>
<center><a href="showbooking.php" style="	background-color: #f17d2b;
color: #ffffff;
border: none;
border-radius: 5px;
padding: 10px 20px;
cursor: pointer;
"><button>View Appointments</button></a> 
</center>	
	<h2>Add Billing Information</h2>
	<form action="add_billing.php" method="post">
		<label for="patient">Patient Name:</label>
        <input type="text" id="patient" name="patient" required>
		<label for="service">Service:</label>
		<input type="text" id="service" name="service" required>
		<label for="date">Date:</label>
		<input type="date" id="date" name="date" required>
		<label for="amount">Amount:</label>
		<input type="number" id="amount" name="amount" required>
		<button type="submit">Add Billing Information</button>
	</form>
	<center><a href="showbilling.php" style="	background-color: #f17d2b;
		color: #ffffff;
		border: none;
		border-radius: 5px;
		padding: 10px 20px;
		cursor: pointer;
		"><button>View billing</button></a> 
		</center>	
</body>
</html>