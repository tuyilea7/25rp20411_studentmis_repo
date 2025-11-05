<!DOCTYPE html>
<html>
<head>
    <title>USER REGISTRATION</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 400px; margin: 0 auto; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; 
                border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; margin: 5px 0; }
        .success { color: green; margin: 5px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h2></h2>
        
        <?php
        session_start();
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $servername = "25rp20411-database";
            $username = "root";
            $password = "password";
            $dbname = "25rp20411_database";
            
            $conn = new mysqli($servername, $username, $password, $dbname);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $sql = "SELECT user_id, user_name, user_emil, user_password FROM users WHERE user_email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                
                if (password_verify($password, $user['user_password'])) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_name'] = $user['user_email'] . ' ' . $user['user_name'];
                    echo "<div class='success'>Registration successfull successful! Welcome " . $user['user_firstname'] . "!</div>";
                    // Redirect to dashboard or home page
                    header("refresh:2;url=dashboard.php");
                } else {
                    echo "<div class='error'>Invalid password!</div>";
                }
            } else {
                echo "<div class='error'>User not found!</div>";
            }
            
            $stmt->close();
            $conn->close();
        }
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
        
</body>
</html>