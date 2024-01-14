<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sussy.css">
    <title>Customer Details - Your Clothing Store</title>
</head>
<body>
<header>
        <div class="header-left">
            <!-- Assuming you have the logo as an image -->
            <img src="sussy.png" alt="Logo" class="logo">
        </div>
        <nav class="header-nav">
            <a href="sussy.php">Home</a>
            <a href="employee_details.php">Employee Details</a>
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
        <h1>Customer Details</h1>

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

        $itemsPerPage = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $startAt = ($page - 1) * $itemsPerPage;

        // Query for Customer Details
        echo "<h2>Customer Details</h2>";
        $query = "SELECT * FROM customer LIMIT $startAt, $itemsPerPage";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo "<table style='border: 1px solid black;'>><tr><th>ID</th><th>Name</th><th>Contact Number</th><th>Email</th><th>Address</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["CustomerID"]. "</td><td>" . $row["Name"]. "</td><td>" . $row["ContactNumber"]. "</td><td>" . $row["Email"]. "</td><td>" . $row["Address"]. "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No customer details found</p>";
        }

        $totalQuery = "SELECT COUNT(*) FROM customer";
        $totalResult = $conn->query($totalQuery);
        $totalRows = $totalResult->fetch_row()[0];
        $totalPages = ceil($totalRows / $itemsPerPage);
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='customer_details.php?page=$i'>$i</a> ";
        }

        $conn->close();
        ?>

        <h2>Search Customer Purchases</h2>
        <form method="post" action="customer_details.php">
            <label for="customerName">Customer Name:</label>
            <input type="text" id="customerName" name="customerName">
            <input type="submit" value="Search">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get the customer name from the form
            $customerName = $_POST['customerName'];

            // SQL to fetch customer's purchased items and transaction details
            $query = "SELECT c.Name, pp.*, t.TotalPrice, t.TimeofTransaction 
                      FROM customer c
                      JOIN productpurchased pp ON c.CustomerID = pp.CustomerID
                      JOIN transaction t ON pp.TransactionID = t.TransactionID
                      WHERE c.Name LIKE ?";

            // Prepare statement
            $stmt = $conn->prepare($query);
            $customerName = "%$customerName%";
            $stmt->bind_param("s", $customerName);

            // Execute and get results
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Display the results in a table
                echo "<table><tr><th>Customer Name</th><th>Product ID</th><th>Quantity</th><th>Purchased Price</th><th>Total Price</th><th>Time of Transaction</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["Name"]. "</td><td>" . $row["ProductID"]. "</td><td>" . $row["Quantity"]. "</td><td>" . $row["PurchasedPrice"]. "</td><td>" . $row["TotalPrice"]. "</td><td>" . $row["TimeofTransaction"]. "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No records found for " . htmlspecialchars($customerName) . "</p>";
            }

            $stmt->close();
        }
        ?>
    </main>
</body>
</html>
