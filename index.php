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

// Pagination
$records_per_page = 20;
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $records_per_page;

// Search functionality
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$where_condition = empty($search) ? '' : "WHERE brand LIKE '%$search%' OR model LIKE '%$search%'";

$query = "SELECT * FROM autod $where_condition LIMIT $start_from, $records_per_page";
$result = $conn->query($query);

if (!$result) {
    die("Error in SQL query: " . $conn->error);
}

// Count total number of records
$total_records_query = "SELECT COUNT(*) AS total FROM autod $where_condition";
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['total'];

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);

// Check if there are more records beyond the current page
$has_next_page = $page < $total_pages;
?>

<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Information Table</title>
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .pagination {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .pagination button {
        padding: 5px 10px;
        cursor: pointer;
    }

    .pagination .prev {
        margin-right: auto; /* Pushes the "Previous" button to the left */
    }

    .pagination .next {
        margin-left: auto; /* Pushes the "Next" button to the right */
    }
    /* Added CSS rule to push the image to the right */
    /* Adjusted CSS to float the image to the right */
    img.add-car-button {
        float: right;
    }
    </style>
    <script>
        function navigateToPage(page) {
            var search = encodeURIComponent(document.getElementById('search').value);
            window.location.href = '?page=' + page + '&search=' + search;
        }
    </script>
</head>
<body>
    <form method="GET">
        <label for="search">Search by brand:</label>
        <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
    </form>
    
    <a href="add_car.php">
        <img class="add-car-button" src="plus.png" alt="Add New Car" width="30" height="30">
    </a>

    <table>
        <tr>
            <th>URL</th>
            <th>Brand</th>
            <th>Engine</th>
            <th>Mileage</th>
            <th>Fuel</th>
            <th>Model</th>
            <th>Model-Short</th>
            <th>Transmission</th>
            <th>Year</th>
            <th>Bodytype</th>
            <th>Drive</th>
            <th>Price</th>
            <!-- Add other column headers here -->
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['url'] . "</td>";
            echo "<td>" . $row['brand'] . "</td>";
            echo "<td>" . $row['engine'] . "</td>";
            echo "<td>" . $row['mileage'] . "</td>";
            echo "<td>" . $row['fuel'] . "</td>";
            echo "<td>" . $row['model'] . "</td>";
            echo "<td>" . $row['model_short'] . "</td>";
            echo "<td>" . $row['transmission'] . "</td>";
            echo "<td>" . $row['year'] . "</td>";
            echo "<td>" . $row['bodytype'] . "</td>";
            echo "<td>" . $row['drive'] . "</td>";
            echo "<td>" . $row['price'] . "</td>";
            // Add other columns here
            echo "</tr>";
        }
        ?>
    </table>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <button class="prev" onclick="navigateToPage(<?php echo $page - 1; ?>)">Previous</button>
        <?php endif; ?>

        <?php if ($has_next_page): ?>
            <button class="next" onclick="navigateToPage(<?php echo $page + 1; ?>)">Next</button>
        <?php endif; ?>
    </div>

    <?php if ($result->num_rows < $records_per_page): ?>
        <p>No more records.</p>
    <?php endif; ?>
</body>
</html>