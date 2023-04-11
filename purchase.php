<head>
    <h1>Purchase page</h1>
    <link rel="stylesheet" href="style.css">
</head>

<form method="post" action="">
    <label for="bookID">BookID:</label>
    <input type="text" id="bookID" name="bookID"><br><br>
    <label for="numCopies">Number of copies:</label>
    <input type="text" id="numCopies" name="numCopies"><br><br>
    <label for="customerName">Customer Name:</label>
    <input type="text" id="customerName" name="customerName"><br><br>
    <label for="purchaseDate">Purchase Date:</label>
    <input type="date" id="purchaseDate" name="purchaseDate"><br><br>
    <input type="submit" value="Submit">
</form>
<!-- Add this button wherever you want it on your page -->
<button onclick="goBack()">Go Back</button>

<script>
// This function takes the user back to the previous page
function goBack() {
  window.history.back();
}
</script>
<?php
// Establish a connection to the database
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "library";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the BookID and number of copies from the user
$bookID = isset($_POST['bookID']) ? $_POST['bookID'] : '';
$numCopies = isset($_POST['numCopies']) ? $_POST['numCopies'] : '';
$customerName = isset($_POST['customerName']) ? $_POST['customerName'] : '';
$purchaseDate = isset($_POST['purchaseDate']) ? $_POST['purchaseDate'] : '';

// Query the database for the number of available copies for the specified book
$query = "SELECT No_Of_Copies FROM Copies WHERE BookID = $bookID";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Error: BookID not found");
}

$availableCopies = $row['No_Of_Copies'];

// Check if the requested number of copies is more than the available copies
if ($numCopies > $availableCopies) {
    echo "Error: Requested number of copies is more than the available copies.";
} else {
    // Update the number of available copies in the database
    $newNumCopies = $availableCopies - $numCopies;
    $query = "UPDATE Copies SET No_Of_Copies = $newNumCopies WHERE BookID = $bookID";

    if (!mysqli_query($conn, $query)) {
        die("Error: " . mysqli_error($conn));
    } else {
        // Insert the purchase record into the database
        $insert_query = "INSERT INTO Purchases (Customer_Name, BookID, Purchase_Date, Count) VALUES ('$customerName', '$bookID', '$purchaseDate', '$numCopies')";
        if (!mysqli_query($conn, $insert_query)) {
            die("Error: " . mysqli_error($conn));
        } else {
            echo "Number of copies updated successfully and purchase record added to database!";
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>