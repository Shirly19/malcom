<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");  // Redirect to login page if not logged in
    exit();
}

// Database connection
$connection = new mysqli("localhost", "root", "", "photography_website");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch all inquiries from the database and sort by inquiry_date
$query = "SELECT * FROM inquiries ORDER BY inquiry_date DESC";
$result = $connection->query($query);

// Check if the query was successful
if (!$result) {
    die("Error in query: " . $connection->error);
}

// Handle inquiry status update and reply submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inquiry_id'])) {
    $status = $_POST['status'];
    $reply = $_POST['reply'];
    $inquiry_id = $_POST['inquiry_id'];

    // Ensure status and reply are not empty
    if (empty($status) || empty($reply)) {
        $status_message = "Status and reply cannot be empty.";
    } else {
        // Update inquiry status and reply
        $update_query = "UPDATE inquiries SET status = ?, reply = ? WHERE id = ?";
        $stmt = $connection->prepare($update_query);

        if ($stmt === false) {
            die('Error preparing query: ' . $connection->error);
        }

        $stmt->bind_param("ssi", $status, $reply, $inquiry_id);

        // Debugging: Comment out or remove var_dump($_POST); for production code
        // var_dump($_POST);  // Remove this in production

        if ($stmt->execute()) {
            $status_message = "Inquiry status and reply updated successfully.";
        } else {
            $status_message = "Error updating inquiry: " . $stmt->error;
            echo "<br><br>Error Details: " . $stmt->error; // Debugging
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inquiries - Malcolm Lismore Photography</title>
    <style>
        /* Basic styles for the inquiry management page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #005f73;
            color: white;
            padding: 20px;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        .status-form {
            display: inline-block;
            margin-left: 10px;
        }
        .status-form select, .status-form textarea {
            padding: 5px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .status-form button {
            padding: 5px 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .status-form button:hover {
            background-color: #555;
        }
        .message {
            text-align: center;
            margin: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<header>
    <h1>Manage Inquiries</h1>
</header>

<main>
    <!-- Status message container, placed before the table -->
    <div class="message">
        <?php if (isset($status_message)) { echo $status_message; } ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Submitted At</th>
                <th>Status</th>
                <th>Reply</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Check if there are results to display
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                        <td><?php echo $row['inquiry_date']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['reply'])); ?></td>
                        <td>
                            <!-- Form for updating the status and reply -->
                            <form method="POST" class="status-form">
                                <input type="hidden" name="inquiry_id" value="<?php echo $row['id']; ?>">
                                <label>Status:</label>
                                <select name="status">
                                    <option value="pending" <?php if ($row['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="completed" <?php if ($row['status'] == 'completed') echo 'selected'; ?>>Completed</option>
                                </select>
                                <label>Reply:</label>
                                <textarea name="reply" rows="3"><?php echo htmlspecialchars($row['reply']); ?></textarea>
                                <button type="submit">Update Status & Reply</button>
                            </form>
                        </td>
                    </tr>
                <?php }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No inquiries found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</main>

</body>
</html>

<?php
$connection->close();
?>
