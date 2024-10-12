<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Malcolm Lismore Photography</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .dashboard-container {
	max-width: 600px;
	padding: 33px; /* Increased padding for better spacing */
	background-color: #fff;
	box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Softer shadow for a cleaner look */
	border-radius: 10px; /* Slightly larger border-radius for a more modern look */
	text-align: center;
	margin-top: 55px;
	margin-right: auto;
	margin-bottom: 50px;
	margin-left: auto;
	letter-spacing: normal;
	word-spacing: normal;
	font-size: 16px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px; /* Add margin below the heading */
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-spacing: 0 10px; /* Adds spacing between rows */
        }
        td {
            padding: 15px; /* Increased padding inside table cells */
            background-color: #eef; /* Light background for better readability */
            border-radius: 6px; /* Adds a slight rounding effect to table cells */
        }
        .dashboard-container button, .dashboard-container a {
            display: block;
            width: 100%;
            padding: 15px; /* Increased padding for better button sizing */
            margin: 15px 0; /* Increased margin for more spacing between buttons */
            background-color: #005f73;
            color: white;
            text-decoration: none;
            text-align: center;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px; /* Slightly larger font size for buttons */
        }
        .dashboard-container button:hover, .dashboard-container a:hover {
            background-color: #0a9396;
        }
    .style1 {
	font-weight: bold;
	font-size: 16px;
}
    </style>
</head>
<body>

<div class="dashboard-container">
  <h1>Admin Dashboard</h1>
  <p>Welcome, <?php echo $_SESSION['username']; ?>!</p><br>

    <div align="center">
      <!-- Link to Upload Image Page -->
      <span class="style1"><a href="upload_photo.php">Upload Photo</a>
      
      <!-- Link to Manage Inquiries -->
      <a href="manage_inquiries.php">Manage the Inquiries</a>
      
      <!-- Link to Update Prices Page -->
      <a href="update_prices.php">Update the Prices</a>
      
      <!-- Link to Delete Images from Gallery -->
      <a href="delete_image.php">Delete the Images</a>
      
      <!-- Logout -->
      <a href="logout.php">Logout from the admin dashboard</a></span>    </div>
</div>

</body>
</html>
