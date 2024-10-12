<?php
// Database connection
$connection = new mysqli("localhost", "root", "", "photography_website");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Insert data into inquiries table
    $query = "INSERT INTO inquiries (name, email, message, status) VALUES (?, ?, ?, 'pending')";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        // Redirect back to homepage with success message
        header("Location: main.php?success=true");
    } else {
        // Handle error
        echo "Error: Could not submit inquiry.";
    }

    $stmt->close();
}

$connection->close();
?>
