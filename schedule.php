<?php
// Get the form data
$doctor = $_POST["doctor"];
$patient_name = $_POST["patient"];
$date = $_POST["date"];
$time = $_POST["time"];

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

// Check if there are any existing appointments on the chosen date
$sql = "SELECT * FROM appointments WHERE doctor = '$doctor' AND date='$date' AND time='$time'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // A previous appointment exists on the chosen date
    echo "Sorry, there is already an appointment scheduled on $date. Please choose a different date.";
} else {
    // No previous appointment exists on the chosen date, so add the new appointment to the database
    $sql = "INSERT INTO appointments (doctor,patient_id, patient_name, date, time)
            VALUES ('$doctor','$patient_id', '$patient_name', '$date', '$time')";
    if (mysqli_query($conn, $sql)) {
      echo "Appointment scheduled successfully.";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>