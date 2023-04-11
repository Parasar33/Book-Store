<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Delete Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Delete Book</h1>
    <form action="" method="post">
        <label for="bookID">Book ID:</label>
        <input type="text" id="bookID" name="bookID" required><br><br>
        <input type="submit" value="Delete">
    </form>
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

// Get BookID to be deleted
if (isset($_POST["bookID"])) {
    $bookID = $_POST["bookID"];

    // Check if book exists
    $sql = "SELECT * FROM Books WHERE BookID = '$bookID'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Book does not exist
        echo "Book with ID $bookID does not exist.";
    } else {
        // Delete all data related to the book
        $sql = "DELETE FROM Prices WHERE BookID = '$bookID'";
        $conn->query($sql);

        $sql = "DELETE FROM Copies WHERE BookID = '$bookID'";
        $conn->query($sql);

        $sql = "DELETE FROM Authors WHERE BookID = '$bookID'";
        $conn->query($sql);

        $sql = "DELETE FROM Books WHERE BookID = '$bookID'";
        $conn->query($sql);

        echo "Book with ID $bookID has been deleted successfully!";
    }
}

?>

</body>
</html>