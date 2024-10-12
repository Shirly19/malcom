<<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

// Database connection
$connection = new mysqli("localhost", "root", "", "photography_website");

// Delete image if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $image_id = $_POST['image_id'];

    // Get the image path from the database
    $query = "SELECT image_path FROM photos WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Delete image file from the server
    $image_path = $row['image_path'];
    if (unlink($image_path)) {
        // Delete image record from the database
        $query = "DELETE FROM photos WHERE id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('i', $image_id);

        if ($stmt->execute()) {
            $success_message = "Image deleted successfully.";
        } else {
            $error_message = "Error deleting image from database.";
        }
    } else {
        $error_message = "Error deleting image file.";
    }
}

// Fetch all images from the database
$query = "SELECT * FROM photos";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Image from Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .delete-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        td {
            padding: 10px;
        }
        .delete-container button {
            width: 100%;
            padding: 10px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-container button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>

<div class="delete-container">
    <h1>Delete Image</h1>

    <?php if (isset($error_message)) { ?>
        <div style="color: red;"><?php echo $error_message; ?></div>
    <?php } elseif (isset($success_message)) { ?>
        <div style="color: green;"><?php echo $success_message; ?></div>
    <?php } ?>

    <form method="POST">
        <table>
            <tr>
                <td><label for="image_id">Choose Image to Delete:</label></td>
                <td>
                    <select name="image_id" id="image_id" required>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo basename($row['image_path']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">Delete Image</button>
                </td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>
