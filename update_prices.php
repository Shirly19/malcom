<?php
session_start();

// Database connection
$connection = new mysqli("localhost", "root", "", "photography_website");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Variable to hold success or error message
$message = '';

// Check if the form is submitted for inserting or updating data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];
    $time_period = $_POST['time_period'];
    $number_of_pics = $_POST['number_of_pics'];
    $edited_pics = $_POST['edited_pics'];

    // Handle image uploads
    $target_dir = "uploads/previous_shoots/";
    $image_paths = [];

    if (isset($_FILES['previous_shoots'])) {
        foreach ($_FILES['previous_shoots']['name'] as $key => $name) {
            $target_file = $target_dir . basename($name);
            $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file type (only allow images)
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($image_file_type, $allowed_types)) {
                if (move_uploaded_file($_FILES['previous_shoots']['tmp_name'][$key], $target_file)) {
                    $image_paths[] = $target_file;
                } else {
                    echo "Error uploading image $name";
                }
            }
        }
    }

    // Convert image paths to a comma-separated string
    $previous_shoots = implode(',', $image_paths);

    // Insert or Update the data
    if (isset($_POST['id']) && $_POST['id'] !== "") {
        // Update the existing entry
        $id = $_POST['id'];
        $stmt = $connection->prepare("UPDATE prices SET service_name=?, price=?, time_period=?, number_of_pics=?, edited_pics=?, previous_shoots=? WHERE id=?");
        $stmt->bind_param("ssssssi", $service_name, $price, $time_period, $number_of_pics, $edited_pics, $previous_shoots, $id);
    } else {
        // Insert a new entry
        $stmt = $connection->prepare("INSERT INTO prices (service_name, price, time_period, number_of_pics, edited_pics, previous_shoots) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $service_name, $price, $time_period, $number_of_pics, $edited_pics, $previous_shoots);
    }

    if ($stmt->execute()) {
        $message = "Price details uploaded successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch all services and prices from the database
$services_query = "SELECT * FROM prices";
$services_result = $connection->query($services_query);
$services = [];
if ($services_result->num_rows > 0) {
    while ($row = $services_result->fetch_assoc()) {
        $services[] = $row;
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload/Update Prices - Malcolm Lismore Photography</title>
    <link rel="stylesheet" href="style.css">
    <style>
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            margin: auto;
        }
        form input, form textarea {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .message {
            color: green;
            font-weight: bold;
            text-align: center;
        }
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
        }
        .service-list {
            margin-top: 20px;
            width: 80%;
            margin: auto;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
        .service-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .service-list th, .service-list td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <h1>Malcolm Lismore Photography</h1>
        </div>
        <nav>
            <ul>
                <li><a href="main.php">Home</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="prices.php">Prices</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2 align="center">Update Price Details</h2>
            <form action="update_prices.php" method="POST" enctype="multipart/form-data">
                <!-- If updating, pass the ID of the service being updated -->
                <input type="hidden" name="id" value="<?= isset($service_data['id']) ? $service_data['id'] : '' ?>">

                <label for="service_name">Service Name:</label>
                <input type="text" id="service_name" name="service_name" value="<?= isset($service_data['service_name']) ? $service_data['service_name'] : '' ?>" required>

                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="<?= isset($service_data['price']) ? $service_data['price'] : '' ?>" required>

                <label for="time_period">Time Period (e.g., 3 hours):</label>
                <input type="text" id="time_period" name="time_period" value="<?= isset($service_data['time_period']) ? $service_data['time_period'] : '' ?>" required>

                <label for="number_of_pics">Number of Pictures:</label>
                <input type="text" id="number_of_pics" name="number_of_pics" value="<?= isset($service_data['number_of_pics']) ? $service_data['number_of_pics'] : '' ?>" required>

                <label for="edited_pics">Number of Edited Pictures:</label>
                <input type="text" id="edited_pics" name="edited_pics" value="<?= isset($service_data['edited_pics']) ? $service_data['edited_pics'] : '' ?>" required>

                <label for="previous_shoots">Upload Previous Shoot Images:</label>
                <input type="file" id="previous_shoots" name="previous_shoots[]" multiple accept="image/*">

                <button type="submit">Upload/Update Price</button>
            </form>

            <!-- Display Success/Error Message -->
            <?php if ($message): ?>
                <div class="<?= strpos($message, 'Error') === false ? 'message' : 'error-message' ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <!-- Display Services List -->
            <div class="service-list">
                <h3>Current Price List</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Price</th>
                            <th>Time Period</th>
                            <th>Number of Pics</th>
                            <th>Edited Pics</th>
                            <th>Previous Shoots</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td><?= $service['service_name'] ?></td>
                                <td><?= $service['price'] ?></td>
                                <td><?= $service['time_period'] ?></td>
                                <td><?= $service['number_of_pics'] ?></td>
                                <td><?= $service['edited_pics'] ?></td>
                                <td><a href="<?= $service['previous_shoots'] ?>" target="_blank">View</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

</body>
</html>
