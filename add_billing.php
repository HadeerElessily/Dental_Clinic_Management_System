<?php
// Get the form data
$patient_name = $_POST["patient"];
$service = $_POST["service"];
$date = $_POST["date"];
$amount = $_POST["amount"];

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dental_clinic";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Retrieve the patient ID from the database
$sql = "SELECT id FROM patients WHERE name = '$patient_name'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$patient_id = $row["id"];

if ($row>=1){
// Insert the booking into the database
$sql = "INSERT INTO billing (patient_id, patient_name, service, date, amount)
        VALUES ('$patient_id', '$patient_name', '$service', '$date', '$amount')";
if (mysqli_query($conn, $sql)) {
  echo "billing added successfully.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
else{
    echo "That record does not exist.";
}


mysqli_close($conn);
?>

