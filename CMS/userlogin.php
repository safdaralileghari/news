<?php

// Start session
session_start();

// Check if session is set; if yes, redirect to dashboard
if(isset($_SESSION['type']) && isset($_SESSION['id'])){
    header("Location: http://localhost/code/php%20projects/news/CMS/dashboard.php");
    exit();
}

// Check if the login form has been submitted
if(isset($_POST['submit'])){
    // Check if email and password fields are not empty
    if(!empty($_POST['email']) && !empty($_POST['password'])){
        // Validate email format
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            // Check if the password is at least 8 characters long
            if(strlen($_POST['password']) >= 8){
                // Connect to the database
                $con = mysqli_connect("localhost", "root", "", "news");

                if($con){
                    // Escape user inputs for security
                    $email = mysqli_real_escape_string($con, $_POST['email']);
                    $password = mysqli_real_escape_string($con, $_POST['password']);

                    // Fetch user data from the database
                    $query = "SELECT * FROM admin WHERE email = '$email'";
                    $res = mysqli_query($con, $query);

                    if($res && mysqli_num_rows($res) > 0){
                        $row = mysqli_fetch_assoc($res);
                        // Verify the password
                        if(password_verify($password, $row['password'])){
                            // Set session variables
                            $_SESSION['type'] = $row['type'];
                            $_SESSION['id'] = $row['id'];

                            // Redirect to dashboard
                            header("Location: http://localhost/code/php%20projects/news/CMS/dashboard.php");
                            exit();
                        } else {
                            $_SESSION['error_class'] = "error";
                            $_SESSION['error'] = "Incorrect email or password.";
                        }
                    } else {
                        $_SESSION['error_class'] = "error";
                        $_SESSION['error'] = "Your account not found.";
                    }
                } else {
                    $_SESSION['error_class'] = "error";
                    $_SESSION['error'] = "Database connection error: " . mysqli_connect_error();
                }
            } else {
                $_SESSION['error_class'] = "error";
                $_SESSION['error'] = "Password must be at least 8 characters long.";
            }
        } else {
            $_SESSION['error_class'] = "error";
            $_SESSION['error'] = "Invalid email format.";
        }
    } else {
        $_SESSION['error_class'] = "error";
        $_SESSION['error'] = "Please fill in both email and password fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/Style.css">
    <link rel="stylesheet" href="../style/responsive.css">
    <link rel="stylesheet" href="../Style2.css">
    <title>Admin Login</title>
</head>
<body>
    <section class="login_form">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <p class="<?php if(isset($_SESSION['error_class'])){echo $_SESSION['error_class'];}?>"><?php if(isset($_SESSION['error_class'])){echo $_SESSION['error']; unset($_SESSION['error_class'], $_SESSION['error']);}?></p>
            <h1>Admin Login</h1>
            <div>
                <input type="text" name="email" id="email" placeholder="Email">
            </div>
            <div>
                <input type="password" name="password" id="pass" placeholder="Password">
            </div>
            <div>
                <button type="submit" name="submit">Login</button>
            </div>
        </form>
    </section>
</body>
</html>
