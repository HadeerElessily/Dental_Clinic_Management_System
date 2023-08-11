<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dental_clinic";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

// Retrieve data from the form
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$dob = $_POST["dob"];

// Insert data into the database
$sql = "INSERT INTO patients (name, email, phone, address, dob) VALUES ('$name', '$email', '$phone', '$address', '$dob')";
if (mysqli_query($conn, $sql)) {
	echo "New record created successfully";
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>

