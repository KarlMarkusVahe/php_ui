<?php
// Include your database connection code and necessary configurations here
$servername = ""; // enter server here
$username = ""; // enter username here
$password = ""; // enter user password here
$dbname = ""; // enter database name here

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding new cars
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $conn->real_escape_string($_POST['brand']);
    $engine = $conn->real_escape_string($_POST['engine']);
    $mileage = $conn->real_escape_string($_POST['mileage']);
    $fuel = $conn->real_escape_string($_POST['fuel']);
    $model = $conn->real_escape_string($_POST['model']);
    $model_short = $conn->real_escape_string($_POST['model_short']);
    $transmission = $conn->real_escape_string($_POST['transmission']);
    $year = $conn->real_escape_string($_POST['year']);
    $bodytype = $conn->real_escape_string($_POST['bodytype']);
    $drive = $conn->real_escape_string($_POST['drive']);
    $price = $conn->real_escape_string($_POST['price']);
    
    $insert_query = "INSERT INTO autod (brand, engine, mileage, fuel, model, model_short, transmission, year, bodytype, drive, price) VALUES ('$brand', '$engine', '$mileage', '$fuel', '$model', '$model_short', '$transmission', '$year', '$bodytype', '$drive', '$price')";
    
    if ($conn->query($insert_query) === TRUE) {
        echo "New car added successfully!";
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
    <!-- Your CSS and JavaScript code -->
</head>
<body>
    <h2>Add New Car</h2>
    <form method="POST">
        <label for="brand">Brand:</label>
        <input type="text" name="brand" required><br>
        <label for="engine">Engine:</label>
        <input type="text" name="engine" required><br>
        <label for="mileage">Mileage:</label>
        <input type="number" name="mileage" required><br>
        <label for="fuel">Fuel:</label>
        <input type="text" name="fuel" required><br>
        <label for="model">Model:</label>
        <input type="text" name="model" required><br>
        <label for="model_short">Model-Short:</label>
        <input type="text" name="model_short" required><br>
        <label for="transmission">Transmission:</label>
        <input type="text" name="transmission" required><br>
        <label for="year">Year:</label>
        <input type="number" name="year" required><br>
        <label for="bodytype">Bodytype:</label>
        <input type="text" name="bodytype" required><br>
        <label for="drive">Drive:</label>
        <input type="text" name="drive" required><br>
        <label for="price">Price:</label>
        <input type="number" name="price" required><br>
        <input type="submit" value="Add Car">
    </form>
</body>
</html>
