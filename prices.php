<?php
// Database connection
$connection = new mysqli("localhost", "root", "", "photography_website");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch all services and prices from the database for display
$services_query = "SELECT * FROM prices";
$services_result = $connection->query($services_query);

if ($services_result === false) {
    die("Error: " . $connection->error);
}

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
    <title>Prices - Malcolm Lismore Photography</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Styles for service display */
        .service-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .service-item {
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .service-item:hover {
            transform: scale(1.05);
        }

        .service-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .service-details {
            padding: 15px;
        }

        .service-details h3 {
            margin-top: 0;
        }

        .service-details p {
            margin: 5px 0;
        }

        .service-details .price {
            font-weight: bold;
            color: #005f73;
        }

        .view-link {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }

        .view-link:hover {
            text-decoration: underline;
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
         <button id="toggle-mode" class="mode-toggle"> <B> Dark Mode / Light Mode</B></button>
    </header>

    <main>
        <section>
            <h2 align="center">Photography Services</h2>
            <div class="service-list">
                <?php if (empty($services)): ?>
                    <p>No services available.</p>
                <?php else: ?>
                    <?php foreach ($services as $service): ?>
                        <div class="service-item">
                            <?php if (!empty($service['previous_shoots'])): ?>
                                <!-- Display first image from previous_shoots -->
                                <?php $images = explode(',', $service['previous_shoots']); ?>
                                <img src="<?= $images[0] ?>" alt="Service Image" class="service-image">
                            <?php else: ?>
                                <img src="default-image.jpg" alt="Default Service Image" class="service-image">
                            <?php endif; ?>
                            <div class="service-details">
                                <h3><?= $service['service_name'] ?></h3>
                                <p class="price">$<?= $service['price'] ?></p>
                                <p><strong>Time Period:</strong> <?= $service['time_period'] ?></p>
                                <p><strong>Number of Pics:</strong> <?= $service['number_of_pics'] ?></p>
                                <p><strong>Edited Pics:</strong> <?= $service['edited_pics'] ?></p>
                                <?php if (!empty($service['previous_shoots'])): ?>
                                    <a href="<?= $images[0] ?>" class="view-link" target="_blank">View the photo</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <p>
                          <?php endforeach; ?>
                        </p>
                        <p>
                          <?php endif; ?>
                                    </p>
            </div>
        </section>
    </main>
    <br> 
    <footer>
        <p>Contact Malcolm at: <a href="mailto:malcolm@gmail.com">malcolm@gmail.com</a></p>
        <p>&copy; 2024 Malcolm Lismore Photography</p>
    </footer>
    
    <script>
        // Dark/Light mode toggle
        const toggleButton = document.getElementById('toggle-mode');
        toggleButton.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'dark');
        });

        // Apply saved theme from local storage
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }
    </script>

</body>
</html>
