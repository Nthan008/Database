<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sussy.css">
    <title>Website Header</title>
    <style>
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <!-- Assuming you have the logo as an image -->
            <img src="sussy.png" alt="Logo" class="logo">
        </div>
        <nav class="header-nav">
            <a href="employee_details.php">Employee Details</a>
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

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <img src="sussy.png" alt="Logo" class="modal-logo">
            </div>
            <h2>Customer Login</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <button type="submit" name="loginBtn">Login</button>
            </form>
            <p>Don't have an account? <a href="#" id="registerBtn">Register</a></p>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="modal-header">
                <img src="sussy.png" alt="Logo" class="modal-logo">
            </div>
            <h2>Customer Registration</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="name" placeholder="Name">
                <input type="text" name="contactNumber" placeholder="Contact Number">
                <input type="text" name="email" placeholder="Email">
                <input type="text" name="address" placeholder="Address">
                <input type="password" name="password" placeholder="Password">
                <button type="submit" name="registerBtn">Register</button>
            </form>
        </div>
    </div>

    <div id="loginSuccessfulModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-header">
            <img src="sussy.png" alt="Logo" class="modal-logo">
        </div>
        <h2>Login Successful</h2>
        <p>You are now logged in.</p>
        <button id="continueBtn">Continue</button>
    </div>
</div>
<?php
session_start(); // Start a new session or resume the existing session

$servername = "localhost"; // Your MySQL server name
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "sussy"; // Your MySQL database name

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login logic
if (isset($_POST['loginBtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM customer WHERE Email = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Login successful
        $row = $result->fetch_assoc();
        $_SESSION['customerID'] = $row['CustomerID'];
        $_SESSION['customerName'] = $row['Name'];
        
        // Send a JSON response to indicate successful login
        echo json_encode(['success' => true, 'message' => 'Login successful']);
        exit();
    } else {
        // Login failed
        $loginError = "Invalid username or password";
        
        // Send a JSON response to indicate login failure
        echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
        exit();
    }
}



// Registration logic
if (isset($_POST['registerBtn'])) {
    $name = $_POST['name'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    $sql = "INSERT INTO customer (Name, ContactNumber, Email, Address, Password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $contactNumber, $email, $address, $password);

    if ($stmt->execute()) {
        // Registration successful
        $registrationSuccess = "Registration successful! You can now log in.";
    } else {
        // Registration failed
        $registrationError = "Registration failed. Please try again.";
    }
}

// Close the MySQLi connection
$conn->close();
?>
<!-- The rest of your HTML goes here -->

    <main>
        <!-- Example product grid -->
        <div class="product-grid">
            <div class="product-item">
                <img src="banner.png" alt="Product 1">
            </div>
            <div class="product-item">
                <img src="product2.jpg" alt="Product 2">
                
                <div class="product-overlay">
                    Most Selling Product<br>
                    <?php
                    // Your PHP code to fetch and display most selling product details
                    $host = 'localhost'; // or your host
                    $user = 'root'; // your database username
                    $password = ''; // your database password
                    $dbname = 'sussy'; // your database name

                    // Create connection
                    $conn = new mysqli($host, $user, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query
                    $sql = "SELECT p.ProductID, p.Name, p.Stock, p.Price, SUM(pp.Quantity) AS TotalQuantity
                            FROM productpurchased pp
                            JOIN product p ON pp.ProductID = p.ProductID
                            GROUP BY p.ProductID
                            ORDER BY TotalQuantity DESC
                            LIMIT 1;";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of the most selling product
                        while($row = $result->fetch_assoc()) {
                            echo "ID: " . $row["ProductID"] . "<br>";
                            echo "Name: " . $row["Name"] . "<br>";
                            echo "Stock: " . $row["Stock"] . "<br>";
                            echo "Price: " . $row["Price"] . "<br>";
                        }
                    } else {
                        echo "0 results";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
            <div class="product-item">
                <img src="product3.jpg" alt="Product 3">
                <div class="product-overlay">
                    Cheapest Product<br>
                    <?php
                    // Your PHP code to fetch and display most selling product details
                    $host = 'localhost'; // or your host
                    $user = 'root'; // your database username
                    $password = ''; // your database password
                    $dbname = 'sussy'; // your database name

                    // Create connection
                    $conn = new mysqli($host, $user, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query
                    $sqlCheapest = "SELECT * FROM product ORDER BY Price ASC LIMIT 1";

                    $result = $conn->query($sqlCheapest);

                    if ($result->num_rows > 0) {
                        // Output data of the most selling product
                        while($row = $result->fetch_assoc()) {
                            echo "ID: " . $row["ProductID"] . "<br>";
                            echo "Name: " . $row["Name"] . "<br>";
                            echo "Stock: " . $row["Stock"] . "<br>";
                            echo "Price: " . $row["Price"] . "<br>";
                        }
                    } else {
                        echo "0 results";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
            <div class="product-item">
                <img src="product4.png" alt="Product 4">
                <div class="product-overlay">
                    Most Expensive Product<br>
                    <?php
                    // Your PHP code to fetch and display most selling product details
                    $host = 'localhost'; // or your host
                    $user = 'root'; // your database username
                    $password = ''; // your database password
                    $dbname = 'sussy'; // your database name

                    // Create connection
                    $conn = new mysqli($host, $user, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query
                    $sqlExpensive = "SELECT * FROM product ORDER BY Price DESC LIMIT 1";

                    $result = $conn->query($sqlExpensive);

                    if ($result->num_rows > 0) {
                        // Output data of the most selling product
                        while($row = $result->fetch_assoc()) {
                            echo "ID: " . $row["ProductID"] . "<br>";
                            echo "Name: " . $row["Name"] . "<br>";
                            echo "Stock: " . $row["Stock"] . "<br>";
                            echo "Price: " . $row["Price"] . "<br>";
                        }
                    } else {
                        echo "0 results";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
            <div class="product-item">
                <img src="product5.jpg" alt="Product 5">
                <div class="product-overlay">
                    Cheapest Product<br>
                    <?php
                    // Your PHP code to fetch and display most selling product details
                    $host = 'localhost'; // or your host
                    $user = 'root'; // your database username
                    $password = ''; // your database password
                    $dbname = 'sussy'; // your database name

                    // Create connection
                    $conn = new mysqli($host, $user, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query
                    $sqlCheapest = "SELECT * FROM product ORDER BY Price ASC LIMIT 1";

                    $result = $conn->query($sqlCheapest);

                    if ($result->num_rows > 0) {
                        // Output data of the most selling product
                        while($row = $result->fetch_assoc()) {
                            echo "ID: " . $row["ProductID"] . "<br>";
                            echo "Name: " . $row["Name"] . "<br>";
                            echo "Stock: " . $row["Stock"] . "<br>";
                            echo "Price: " . $row["Price"] . "<br>";
                        }
                    } else {
                        echo "0 results";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
            <div class="product-item">
                <img src="product4.png" alt="Product 4">
                <div class="product-overlay">
                    Least Purchased Product<br>
                    <?php
                    // Your PHP code to fetch and display most selling product details
                    $host = 'localhost'; // or your host
                    $user = 'root'; // your database username
                    $password = ''; // your database password
                    $dbname = 'sussy'; // your database name

                    // Create connection
                    $conn = new mysqli($host, $user, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // SQL query
                    $sqlLeastPurchased = "SELECT p.ProductID, p.Name, p.Stock, p.Price, SUM(pp.Quantity) AS TotalQuantity
                      FROM productpurchased pp
                      JOIN product p ON pp.ProductID = p.ProductID
                      GROUP BY p.ProductID
                      ORDER BY TotalQuantity ASC
                      LIMIT 1";

                    $result = $conn->query($sqlExpensive);

                    if ($result->num_rows > 0) {
                        // Output data of the most selling product
                        while($row = $result->fetch_assoc()) {
                            echo "ID: " . $row["ProductID"] . "<br>";
                            echo "Name: " . $row["Name"] . "<br>";
                            echo "Stock: " . $row["Stock"] . "<br>";
                            echo "Price: " . $row["Price"] . "<br>";
                        }
                    } else {
                        echo "0 results";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>

            <!-- Add more products as needed -->
        </div>
    </main>

    <script src="script.js">// JavaScript for carousel navigation
const carousel = document.querySelector('.carousel');
const carouselItems = document.querySelectorAll('.carousel-item');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

let currentIndex = 0;

// Show the initial item
showItem(currentIndex);

// Function to show a specific item
function showItem(index) {
    // Hide all items
    carouselItems.forEach(item => {
        item.style.display = 'none';
    });

    // Show the item at the given index
    carouselItems[index].style.display = 'block';
}

// Event listener for "Previous" button
prevBtn.addEventListener('click', () => {
    currentIndex--;
    if (currentIndex < 0) {
        currentIndex = carouselItems.length - 1;
    }
    showItem(currentIndex);
});

// Event listener for "Next" button
nextBtn.addEventListener('click', () => {
    currentIndex++;
    if (currentIndex >= carouselItems.length) {
        currentIndex = 0;
    }
    showItem(currentIndex);
});</script>       // JavaScript for carousel navigation

</body>
</html>
