<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

$conn = new mysqli($servername, $username, "", $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$bookID = $_POST["bookID"];
$noOfCopies = $_POST["noOfCopies"];

// Check if book exists
$sql = "SELECT * FROM Books WHERE BookID = '$bookID'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Update existing book
    $sql = "UPDATE Copies SET No_Of_Copies='$noOfCopies' WHERE BookID='$bookID'";
    $conn->query($sql);
    echo "Number of Copies have been Updated Successfully!";
}
    ?>
