<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    // File upload logic
    $target_dir = "images/";  // Path to save uploaded images
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    
    // Check if the file is a valid image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        // Move uploaded file to the images folder
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Save image path in the database (optional, for dynamic galleries)
            $connection = new mysqli("localhost", "root", "", "photography_website");
            $query = "INSERT INTO photos (image_path) VALUES ('$target_file')";
            if ($connection->query($query)) {
                echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
            } else {
                echo "Error uploading image to database.";
            }
            $connection->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Image Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .upload-container {
            max-width: 400px;
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
        .error-message, .success-message {
            color: red;
            text-align: center;
        }
        .upload-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .upload-container button {
            width: 100%;
            padding: 10px;
            background-color: #005f73;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .upload-container button:hover {
            background-color: #0a9396;
        }
    </style>
</head>
<body>

    <div class="upload-container">
        <h1>Upload Image</h1>

        <!-- Form for uploading images -->
        <form method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label for="file">Choose an image:</label></td>
                    <td><input type="file" name="file" id="file" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">Upload Image</button>
                    </td>
                </tr>
            </table>
        </form>

        <?php if (isset($error_message)) { ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php } elseif (isset($success_message)) { ?>
            <div class="success-message">
                <?php echo $success_message; ?>
            </div>
        <?php } ?>
    </div>

</body>
</html>
