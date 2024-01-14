<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sussy.css">
    <title>Employee Details - Your Clothing Store</title>
</head>
<body>
<header>
        <div class="header-left">
            <!-- Assuming you have the logo as an image -->
            <img src="sussy.png" alt="Logo" class="logo">
        </div>
        <nav class="header-nav">
            <a href="sussy.php">Home</a>
            <a href="customer_details.php">Customer Details</a>
            <a href="add_customer_transaction.php">Add Transaction</a>
        </nav>
        <div class="header-right">
            <!-- Icons can be SVG, font icons, or images -->
            <a href="#"><img src="search.jpg" alt="Search"></a>
            <a href="#"><img src="profile.png" alt="Account"></a>
            <a href="#"><img src="cart.jpg" alt="Cart"></a>
        </div>
    </header>
    <main class="main">
        <h1>Employee Details</h1>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sussy";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query for Employee Details
        echo "<h2>Employee Details</h2>";
        $query = "SELECT * FROM employee";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Name</th><th>Position</th><th>Contact Number</th><th>Email</th><th>Address</th><th>Salary</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["EmployeeID"]. "</td><td>" . $row["EmployeeName"]. "</td><td>" . $row["Position"]. "</td><td>" . $row["ContactNumber"]. "</td><td>" . $row["Email"]. "</td><td>" . $row["Address"]. "</td><td>" . $row["Salary"]. "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No employee details found</p>";
        }

        $conn->close();
        ?>
    </main>
</body>
</html>
