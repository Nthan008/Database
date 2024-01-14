<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sussy.css">
    <style>form {
    background-color: #f2f2f2;
    padding: 20px;
    margin: 20px 0;
    border-radius: 5px;
}
form label {
    display: block;
    margin-bottom: 5px;
}

.form-row {
    display: flex;
    margin-bottom: 10px;
    align-items: center;
}

.form-row label {
    flex: 0 0 150px;
    margin-bottom: 0;
}

.form-row input, .form-row select {
    flex: 1;
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
input[type="submit"] {
    background-color: #E193AA;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}

input[type="submit"]:hover {
    background-color: #d172a6;
}
@media (max-width: 600px) {
    .form-row {
        flex-direction: column;
    }

    .form-row label {
        margin-bottom: 5px;
    }
}
</style>
    <title>Add Customer Transaction</title>
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
            <a href="employee_details.php">Employee Details</a>
        </nav>
        <div class="header-right">
            <!-- Icons can be SVG, font icons, or images -->
            <a href="#"><img src="search.jpg" alt="Search"></a>
            <a href="#"><img src="profile.png" alt="Account"></a>
            <a href="#"><img src="cart.jpg" alt="Cart"></a>
        </div>
    </header>
    <main class="main">
    <h2>Add New Customer</h2>
<form action="add_customer_transaction.php" method="post">
    <label for="newCustomerName">Name:</label>
    <input type="text" id="newCustomerName" name="newCustomerName" required><br>

    <label for="newContactNumber">Contact Number:</label>
    <input type="text" id="newContactNumber" name="newContactNumber"><br>

    <label for="newEmail">Email:</label>
    <input type="email" id="newEmail" name="newEmail"><br>

    <label for="newAddress">Address:</label>
    <input type="text" id="newAddress" name="newAddress"><br>

    <input type="submit" name="formType" value="addCustomer">
</form>

    <h2>Add Customer Transaction</h2>
    <form action="add_customer_transaction.php" method="post">

    <h2>Transaction Details</h2>
    <label for="customerID">Select Customer:</label>
    <select name="customerID" id="customerID">
    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sussy";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT CustomerID, Name FROM customer";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['CustomerID'] . "'>" . $row['Name'] . " (ID: " . $row['CustomerID'] . ")</option>";
        }
        ?>

    </select><br>
        <h2>Transaction Details</h2>
        <!-- EmployeeID input could be set based on logged-in user or another logic -->
        <label for="employeeId">Employee ID:</label>
            <select name="employeeId" id="employeeId">
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "sussy";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $employeeQuery = "SELECT EmployeeID, EmployeeName FROM employee";
            $employeeResult = $conn->query($employeeQuery);

            while ($employee = $employeeResult->fetch_assoc()) {
                echo "<option value='" . $employee['EmployeeID'] . "'>" . $employee['EmployeeName'] . "</option>";
            }
            ?>

</select><br>


        <label for="totalPrice">Total Price:</label>
        <input type="number" step="0.01" id="totalPrice" name="totalPrice" required><br>
        <h2>Product Purchased</h2>
        <label for="productId">Select Product:</label>
    <select name="productId" id="productId">
    <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "sussy";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT ProductID, Name, Price FROM product";
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
    echo "<option value='" . $row['ProductID'] . "'>" . $row['Name'] . " - $" . $row['Price'] . "</option>";
}

            ?>
    </select><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required><br>

        <label for="purchasedPrice">Purchased Price:</label>
        <input type="number" step="0.01" id="purchasedPrice" name="purchasedPrice" required><br>
        <input type="submit" name="formType" value="addTransaction">


        

    </form>
    <h2>Add Employee Details</h2>
    <form action="add_customer_transaction.php" method="post">
        <label for="employeeName">Employee Name:</label>
        <input type="text" id="employeeName" name="employeeName" required><br>

        <label for="position">Position:</label>
        <input type="text" id="position" name="position" required><br>

        <label for="employeeContactNumber">Contact Number:</label>
        <input type="text" id="employeeContactNumber" name="employeeContactNumber" required><br>

        <label for="employeeEmail">Email:</label>
        <input type="email" id="employeeEmail" name="employeeEmail" required><br>

        <label for="employeeAddress">Address:</label>
        <input type="text" id="employeeAddress" name="employeeAddress" required><br>

        <label for="salary">Salary:</label>
        <input type="number" id="salary" name="salary" required><br>
        <input type="submit" name="formType" value="addEmployee">

    </form>
</main>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['formType'] == 'addCustomer') {
        $stmt = $conn->prepare("INSERT INTO customer (Name, ContactNumber, Email, Address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $newCustomerName, $newContactNumber, $newEmail, $newAddress);
    
        $newCustomerName = $_POST['newCustomerName'];
        $newContactNumber = $_POST['newContactNumber'];
        $newEmail = $_POST['newEmail'];
        $newAddress = $_POST['newAddress'];
        $stmt->execute();
    
        echo "New customer record created successfully";
        $stmt->close();
    }
    
    if (isset($_POST['formType']) && $_POST['formType'] == 'addTransaction') {
    // Prepare and bind
    $employeeId = $_POST['employeeId'];
    $stmt = $conn->prepare("INSERT INTO customer (Name, ContactNumber, Email, Address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $customerName, $contactNumber, $email, $address);

    // Set parameters and execute
    $customerName = $_POST['customerName'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $stmt->execute();

    $last_customer_id = $conn->insert_id;

    $stmt = $conn->prepare("INSERT INTO transaction (TimeofTransaction, CustomerID, EmployeeID, TotalPrice) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siid", $timeOfTransaction, $last_customer_id, $employeeId, $totalPrice);

    // Set parameters and execute
    $timeOfTransaction = date("Y-m-d H:i:s"); // Current date and time
    $employeeId = 1; // Set this to the actual employee ID, or obtain it from another source
    $totalPrice = $_POST['totalPrice'];
    $stmt->execute();

    echo "New transaction record created successfully";
    $stmt = $conn->prepare("INSERT INTO productpurchased (CustomerID, ProductID, Quantity, PurchasedPrice, TimeofTransaction) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiids", $last_customer_id, $productId, $quantity, $purchasedPrice, $timeOfTransaction);

    // Set parameters and execute for each product purchased
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $purchasedPrice = $_POST['purchasedPrice'];
    $stmt->execute();

    echo "New product purchase record added successfully";


    $stmt->close();
    }
    // Check if employee form data is submitted
    if (isset($_POST['employeeName'])) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO employee (EmployeeName, Position, ContactNumber, Email, Address, Salary) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $employeeName, $position, $employeeContactNumber, $employeeEmail, $employeeAddress, $salary);

        // Set parameters and execute
        $employeeName = $_POST['employeeName'];
        $position = $_POST['position'];
        $employeeContactNumber = $_POST['employeeContactNumber'];
        $employeeEmail = $_POST['employeeEmail'];
        $employeeAddress = $_POST['employeeAddress'];
        $salary = $_POST['salary'];
        $stmt->execute();

        echo "New employee record created successfully";

        $stmt->close();
    }
    $conn->close();
}
?>
