<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Malcolm Lismore Photography</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header section -->
    <header>
        <h1>Malcolm Lismore Photography</h1>
        <nav>
            <ul>
                <li><a href="main.php">Home</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="prices.php">Prices</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
        <button id="toggle-mode" class="mode-toggle"><b>Dark Mode / Light Mode</b></button>
    </header>

    <!-- Main content for the About page -->
    <div class="content">
        <h1 align="center">About Malcolm Lismore Photography</h1>
        <p align="center"><b>Malcolm Lismore is a passionate photographer, <br> who specializes in capturing timeless moments.<br> With years of experience in the industry, he brings creativity and attention to detail to every shoot,<br> making each session a unique and memorable experience.</b></p>
        <br>

        <h3 align="center">Studio Location and Contact</h3>

        <table align="center" cellpadding="10" border="3" cellspacing="0">
            <tr>
                <td><b>Studio Location:</b></td>
                <td>123 Photography St, Camera City, Photography Land</td>
            </tr>
            <tr>
                <td><b>Email:</b></td>
                <td><a href="mailto:malcolm@example.com">malcolm@gmail.com</a></td>
            </tr>
            <tr>
                <td><b>Phone number:</b></td>
                <td>+1 (123) 456-7890</td>
            </tr>
        </table>

        <br> <br>

        <!-- Embedded Google Map -->
        <div style="text-align: center;">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d373270.4713924968!2d-3.517146!3d55.9408147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4887c780c6f666b9%3A0x400b23d52ccea80!2sEdinburgh%2C%20UK!5e0!3m2!1sen!2s!4v1696687731225!5m2!1sen!2s"
                width="600" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

    </div> <br>

    <!-- Footer section -->
    <footer>
        <p>&copy; 2024 Malcolm Lismore Photography</p>
    </footer>

</body>
</html>

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
