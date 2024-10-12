<?php
session_start();  // Start session

// Database connection
$connection = new mysqli("localhost", "root", "", "photography_website");

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle the inquiry form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Basic validation (you can expand this for more robust checks)
    if (empty($name) || empty($email) || empty($message)) {
        $inquiry_message = "Please fill in all the fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $inquiry_message = "Please provide a valid email address.";
    } else {
        // Use prepared statements to avoid SQL injection
        $query = "INSERT INTO inquiries (name, email, message) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param('sss', $name, $email, $message);
            if ($stmt->execute()) {
                $inquiry_message = "Your inquiry has been submitted successfully. We will get back to you shortly!";
            } else {
                $inquiry_message = "There was an error submitting your inquiry. Please try again.";
            }
            $stmt->close();
        } else {
            $inquiry_message = "Error preparing the query: " . $connection->error;
        }
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Malcolm Lismore Photography</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .contact-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        h1 {
            text-align: center;
        }
        .contact-container input, .contact-container textarea {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .contact-container button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .contact-container button:hover {
            background-color: #555;
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
            <li><a href="contact.php">Contact</a></li> <!-- Link to the Contact page -->
        </ul>
    </nav>
     <button id="toggle-mode" class="mode-toggle"> <B> Dark Mode / Light Mode</B></button>
</header>

<main>
    <section class="contact-container">
        <h1>Contact Malcolm Lismore Photography</h1>
        <p>&nbsp;</p>
        <!-- Display inquiry message (success/error) -->
        <?php if (isset($inquiry_message)) { ?>
        <p style="color: <?php echo (strpos($inquiry_message, 'successfully') !== false) ? 'green' : 'red'; ?>;">
                <?php echo $inquiry_message; ?>
        </p>
        <?php } ?>
        
        <!-- Inquiry Form -->
        <form method="POST">
          <p>
              <input type="text" name="name" placeholder="Your Name" required>
              <input type="email" name="email" placeholder="Your Email" required>
              <textarea name="message" rows="7" placeholder="Your Message" required></textarea>
          </p>
            <button type="submit">Submit Inquiry</button>
        </form>
    </section>
</main>

<footer>
    <p><strong>Contact Malcolm at: <a href="mailto:malcolm@example.com" style="color: white;">malcolm@example.com</a></strong></p>
    <p><strong>&copy; 2024 Malcolm Lismore Photography</strong></p>
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
