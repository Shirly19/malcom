<?php
// Start the session
session_start();

// Database connection
$connection = new mysqli("localhost", "root", "", "photography_website");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prices - Malcolm Lismore Photography</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="logo">
            <h1>Malcolm Lismore Photography</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="prices.php">Prices</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['admin'])): ?>
                    <li><a href="admin.php">Admin Dashboard</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <button id="toggle-mode" class="mode-toggle">Dark Mode / Light Mode</button>
    </header>

    <main>
        <section id="prices">
            <h2>Prices</h2>
            <ul>
                <?php
                // Fetch and display prices from the database
                $query = "SELECT service_name, price FROM prices";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<li>' . $row['service_name'] . ': $' . $row['price'] . '</li>';
                    }
                } else {
                    echo "<p>No pricing information available.</p>";
                }
                ?>
            </ul>
        </section>
    </main>

    <footer>
        <p>Contact Malcolm at: <a href="mailto:malcolm@example.com">malcolm@example.com</a></p>
        <p>&copy; 2024 Malcolm Lismore Photography</p>
    </footer>

</body>
</html>

<?php
$connection->close();
?>
