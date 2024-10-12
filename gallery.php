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
    <title>Gallery - Malcolm Lismore Photography</title>
    <link rel="stylesheet" href="style.css">
    <style type="text/css">
<!--
.style1 {font-weight: bold}
-->
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
        <button class="mode-toggle style1" id="toggle-mode"> <B>Dark Mode / Light Mode </B></button>
</header>

    <main>
        <section id="gallery">
            <h2 align="center">Gallery</h2>
            <div class="gallery">
                <?php
                // Fetch images from the database and display in the gallery
                $query = "SELECT image_path FROM photos";
                $result = $connection->query($query);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<img src="' . $row['image_path'] . '" alt="Gallery Image" class="thumbnail" onclick="openLightbox(this.src)">';
                    }
                } else {
                    echo "<p>No images available.</p>";
                }
                ?>
            </div>
            <!-- Lightbox for enlarged view -->
            <div id="lightbox" class="lightbox">
                <span class="close" onClick="closeLightbox()">&times;</span>
                <img class="lightbox-content" id="lightbox-img">
            </div>
        </section>
    </main>
    <br> <br>

    <footer>
        <p>Contact Malcolm at: <a href="mailto:malcolm@example.com">malcolm@gmail.com</a></p>
        <p>&copy; 2024 Malcolm Lismore Photography</p>
    </footer>

    <script>
        function openLightbox(src) {
            document.getElementById('lightbox').style.display = 'block';
            document.getElementById('lightbox-img').src = src;
        }

        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
        }
    </script>

</body>
</html>

<?php
$connection->close();
?>
    <script>
        // Dark/Light mode toggle
        const toggleButton = document.getElementById('toggle-mode');
        toggleButton.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
        });

        // Apply saved theme from local storage
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }
    </script>
