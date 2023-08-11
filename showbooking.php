<style>
		.logo {
			display: block;
			margin: 10px auto;
			width: 110px;
			height: 110px;
			background-image: url(calendar.png);
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
		table {
			border-collapse: collapse;
			width: 100%;
			color: #333;
			font-family: Arial, sans-serif;
			font-size: 14px;
			text-align: left;
		}

		th, td {
			padding: 8px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		th {
			background-color: #f2f2f2;
			font-weight: bold;
			color: #666;
		}

		tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		tr:hover {
			background-color: #ddd;
		}
		nav ul {
        background-color: orange;
		padding: 0;
		margin: 0;
		list-style-type: none;
		display: flex;
		justify-content: space-between;
		align-items: center;
		height: 5%;
	}
	nav ul li {
		margin: 0 10px;
	}
	nav ul li a {
		color: black;
		text-decoration: none;
	}
	nav ul li a:hover {
		text-decoration: underline;
	}
	nav ul li:last-child {
		margin-right: 0;
	}
	nav form {
		margin: 10px;
		height: 20px;

	}
	nav input[type="submit"] {
		color: black;
		border: none;
		cursor: pointer;
	}
	nav input[type="submit"]:hover {
		text-decoration: underline;
	}
	</style>
	</style>
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

if (!isset($_SESSION['access_level'])) {
    // If the user is not logged in, redirect them to the login page
    header('Location: login.php');
    exit;
}

// Handle the search form submission
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE appointments.patient_name LIKE ? ORDER BY appointments.patient_id");
    $stmt->execute(["%$search%"]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->prepare("SELECT * FROM appointments");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Appointments</title>
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

	<h1>Patients Appointments</h1>
	<form method="post">
		<label for="search">Search for a patient:</label>
		<input type="text" id="search" name="search">
		<input type="submit" value="Search">
	</form>
	<table>
		<thead>
			<tr>
				<th>Patient ID</th>
				<th>Name</th>
				<th>date</th>
				<th>time</th>
        
			</tr>
		</thead>
		<tbody>
			<?php if ($rows) { // Check if $rows is not null ?>
			<?php foreach ($rows as $row) { ?>
			<tr>
				<td><?php echo $row['patient_id']; ?></td>
				<td><?php echo $row['patient_name']; ?></td>
				<td><?php echo $row['date']; ?></td>
				<td><?php echo $row['time']; ?></td>


			</tr>
			<?php } ?>
			<?php } else { // If $rows is null, display a message ?>
			<tr>
				<td colspan="4">No results found.</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
    
</body>
</html>

