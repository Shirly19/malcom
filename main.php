<?php
session_start();  // Start session

// Database connection
$connection = new mysqli("localhost", "root", "", "photography_website");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malcolm Lismore Photography</title>
    <link rel="stylesheet" href="style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body,td,th {
	font-size: 16px;
}
.style5 {
	font-size: 16px
}
body {
	margin-left: 0px;
	background-repeat: repeat;
}
-->
</style></head>
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
  <button class="mode-toggle" id="toggle-mode"> <b>Dark Mode / Light Mode</b></button>
</header>

<main>
    <section id="home">
        <h1 align="center"><strong>Welcome to Malcolm Lismore Photography</strong></h1>
        <div align="center">
          <img src="images/welcome.jpeg""alt="Malcolm Lismore Photography Logo" height="360">    
          <p>&nbsp;</p>
        </div>
        <p align="center" class="dark-mode" style="line-height: 1.7;">
            <strong>Discover the art of photography through the lens of Malcolm Lismore. With years of experience in capturing unforgettable moments,<br>
            I specialize in various types of photography including weddings, corporate events, portraits, and more.<br>
            I believe in creating timeless memories that can be cherished forever. Whether you're looking for intimate portraits or large-scale event photography,<br>
            I'm here to make your special moments shine. Each project I take on is unique,<br>
            and I ensure that I give my clients my full attention and dedication to produce the best results.<br>
            Photography is not just about capturing images, it’s about telling a story.<br>
            I would be honored to be part of your story and help you create beautiful memories.</strong>        </p>
    </section>

    <!-- Only show the Admin Login Button if not logged in -->
    <?php if (!isset($_SESSION['admin'])): ?>
  <section id="admin-login">
    <p>&nbsp;</p>
    <p align="center"><em>If you're an admin, click below to log in and access the admin panel:</em></p>
    <div align="center"><button class="login-admin-button">
      <a href="admin.php">Login as Admin</a> </div>
    </section>
    <?php endif; ?>
</main>

<p>&nbsp;</p>
<footer>
  <p class="logo"><strong>Contact Malcolm at: <a href="mailto:malcolm@example.com" style="color: white;">malcolm@example.com</a></strong></p>
    <p class="logo"><strong>&copy; 2024 Malcolm Lismore Photography</strong></p>
</footer>

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

</body>
</html>

<?php
$connection->close();
?>
