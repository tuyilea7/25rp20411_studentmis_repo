<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration - Students MIS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .registration-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .registration-header {
            background: #667eea;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .registration-body {
            padding: 40px;
        }
        .btn-register {
            background: #667eea;
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .btn-register:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="registration-container">
                    <div class="registration-header">
                        <h2 class="mb-0">Create Account</h2>
                        <p class="mb-0">Join Students Management Information System</p>
                    </div>
                    
                    <div class="registration-body">
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $servername = "25rp20411-db";
                            $username = "root";
                            $password = "password";
                            $dbname = "25rp20411_shareride_db";
                            
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            
                            $firstname = $_POST['firstname'];
                            $lastname = $_POST['lastname'];
                            $email = $_POST['email'];
                            $user_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            
                            $sql = "INSERT INTO users (user_firstname, user_lastname, user_email, user_password) VALUES (?, ?, ?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("ssss", $firstname, $lastname, $email, $user_password);
                            
                            if ($stmt->execute()) {
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success!</strong> Registration completed successfully!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                      </div>';
                            } else {
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> Registration failed: ' . $stmt->error . '
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                      </div>';
                            }
                            
                            $stmt->close();
                            $conn->close();
                        }
                        ?>
                        
                        <form method="POST" action="">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" required 
                                           placeholder="Enter your first name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" required 
                                           placeholder="Enter your last name">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required 
                                       placeholder="Enter your email">
                                <div class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required 
                                       placeholder="Create a password">
                                <div class="form-text">Must be at least 8 characters long.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" 
                                       placeholder="Confirm your password">
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#">Terms and Conditions</a>
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-register w-100 text-white">Create Account</button>
                        </form>
                        
                        <div class="text-center mt-4">
                            <p class="mb-0">Already have an account? <a href="login.php" class="text-decoration-none">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.style.borderColor = 'red';
            } else {
                this.style.borderColor = 'green';
            }
        });
    </script>
</body>
</html>