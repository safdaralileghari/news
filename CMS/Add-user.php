<?php
session_start();
if (!isset($_SESSION['type'])) {
    header("Location: userlogin.php");
    exit();
}

if (isset($_POST['submit'])) {
    if (!empty($_POST['name'])) {
        if (!empty($_POST['phone'])) {
            if (!empty($_POST['email'])) {
                if (!empty($_POST['password'])) {
                    // Name validation (add your own validation logic if necessary)
                    if (true) {
                        // Phone validation (add your own validation logic if necessary)
                        if (true) {
                            // Email validation
                            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                                // Password validation (add your own validation logic if necessary)
                                if (true) {
                                    // ALL VALIDATIONS COMPLETE
                                    $con = mysqli_connect("localhost", "root", "", "news") or die(mysqli_error($con));

                                    // Hash the password
                                    $passHash = password_hash($_POST["password"], PASSWORD_DEFAULT);

                                    // Prepare and bind
                                    $stmt = $con->prepare("INSERT INTO admin (name, phone, email, password, type) VALUES (?, ?, ?, ?, ?)");
                                    $stmt->bind_param("sssss", $_POST['name'], $_POST['phone'], $_POST['email'], $passHash, $_POST['role']);

                                    // Execute the statement
                                    if ($stmt->execute()) {
                                        header("Location: Users.php");
                                        exit();
                                    } else {
                                        $_SESSION['error_class'] = "error";
                                        $_SESSION['error'] = "Failed to add user";
                                    }

                                    // Close the statement and connection
                                    $stmt->close();
                                    mysqli_close($con);
                                } else {
                                    $_SESSION['error_class'] = "error";
                                    $_SESSION['error'] = "Incorrect Password";
                                }
                            } else {
                                $_SESSION['error_class'] = "error";
                                $_SESSION['error'] = "Incorrect Email";
                            }
                        } else {
                            $_SESSION['error_class'] = "error";
                            $_SESSION['error'] = "Incorrect Phone";
                        }
                    } else {
                        $_SESSION['error_class'] = "error";
                        $_SESSION['error'] = "Incorrect Name";
                    }
                } else {
                    $_SESSION['error_class'] = "error";
                    $_SESSION['error'] = "Must Fill Password Field";
                }
            } else {
                $_SESSION['error_class'] = "error";
                $_SESSION['error'] = "Must Fill Email Field";
            }
        } else {
            $_SESSION['error_class'] = "error";
            $_SESSION['error'] = "Must Fill Phone Field";
        }
    } else {
        $_SESSION['error_class'] = "error";
        $_SESSION['error'] = "Must Fill Name Field";
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

    <title>Add user</title>
</head>
<body>
<nav class="navbar">
        <div class="logo">
            <img src="../icons/world-news.png" alt="news_icon" width="100px" height="100px">
        </div>
        <ul class="list" id="nav_list">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="catgory_manage.php">Categories</a></li>
        <li><a href="Posts.php">News</a></li>
            <?php
            if (isset($_SESSION['type'])) {
                if ($_SESSION['type'] === "admin") {
                    echo '<li><a href="'.$_SERVER['PHP_SELF'].'">Users</a></li>';
                }
            }
            ?>
          <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <section class="contaner catgories_form" style="width:600px;height: 420px;margin:10px auto;display: block;">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
        <p class="<?php if (isset($_SESSION['error_class'])) { echo $_SESSION['error_class']; } ?>">
            <?php if (isset($_SESSION['error'])) { echo $_SESSION['error']; } ?>
        </p>
            <div>
                <input type="text" name="name" placeholder="Full name">
            </div>
            <div>
               <input type="text" name="phone" placeholder="Phone number">
            </div>
            <div>
               <input type="text" name="email" placeholder="Email address">
            </div>
            <div>
               <input type="password" name="password" placeholder="Password">
            </div>
            <div>
                <select name="role" id="role">
                    <option selected hidden>Role</option>
                    <option value="admin">Admin</option>
                    <option value="normal">Normal</option>
                </select>
            </div>
            <div>
                <button type="submit" name="submit">Submit</button>
            </div>
        </form>
    </section>
    <?php require("../footer.php");?>
</body>
</html>
