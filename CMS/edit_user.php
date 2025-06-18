<?php   


session_start();
if(!isset($_SESSION['type'])){
    header("Location: userlogin.php");
}


if(isset($_COOKIE['user_id'])){
    $_SESSION['user_id'] = $_COOKIE['user_id'];
}

   if(isset($_POST['submit'])){

    // first of all unset all the errors
    unset($_SESSION['error_class']);
    unset($_SESSION['error']); 

     if(!empty($_POST['name'])){
        if(!empty($_POST['phone'])){
            if(!empty($_POST['email'])){
                if(!empty($_POST['password'])){
                    // hare validation starts
                    if(true)//name validation
                    {
                    // first validate name 
                       if(true){
                    // then after validate phone
                            if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
                    // then after validate email
                                 if(true){
                    // then after validate password
                                    // ALL VALIDATIONS COMPLETE
                                    

                                    $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
                                    $query = "UPDATE admin SET name = '{$_POST['name']}',phone = '{$_POST['phone']}',email = '{$_POST['email']}',password = '{$_POST['password']}',type = '{$_POST['role']}' WHERE id= {$_SESSION['user_id']}";

                                    mysqli_query($con,$query) or die(mysqli_error($con));
                                    header("Location: Users.php");
                                    mysqli_close($con);
                                 }
                                 else{
                                    $_SESSION['error_class'] = "error";
                                    $_SESSION['error'] = "  Incorrect Password";
                                 }
                            }
                            else{
                                $_SESSION['error_class'] = "error";
                                $_SESSION['error'] = "  Incorrect Email";
                            }
                       }
                       else{
                        $_SESSION['error_class'] = "error";
                        $_SESSION['error'] = "  Incorrect Phone";
                       }
                    }
                    else{
                        $_SESSION['error_class'] = "error";
                        $_SESSION['error'] = "  Incorrect Name";
                    }
                }
                else{
                    $_SESSION['error_class'] = "error";
                    $_SESSION['error'] = "Must Fill Email Field";
                }
            }
            else{
                $_SESSION['error_class'] = "error";
                $_SESSION['error'] = "Must Fill Phone Field";
            }
        }
        else{
            $_SESSION['error_class'] = "error";
            $_SESSION['error'] = "Must Fill Phone Field";
        }
     }
     else{
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
    <link rel="stylesheet" href="style/style.css">

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
            if(isset($_SESSION['type'])){
                if($_SESSION['type']==="admin"){   
            ?>
            <li><a href="<?php echo $_SERVER['PHP_SELF'];?>">Users</a></li>
            <?php 
               }
            }
            ?>
          <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <section class="contaner catgories_form" style="width:600px;height: 420px;margin:10px auto;display: block;">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
        <p class="<?php if(isset($_SESSION['error_class'])){echo $_SESSION['error_class'];}?>"><?php if(isset($_SESSION['error_class'])){echo $_SESSION['error'];}?></p>
           
        <!-- PHP STARTS HARE -->

        <?php
        $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
        $query = "SELECT * FROM admin WHERE id = {$_SESSION['user_id']}";
        $res = mysqli_query($con,$query) or die(mysqli_error($con));
        if(mysqli_num_rows($res)>0){
            $row = mysqli_fetch_assoc($res); 
        ?>
        
            <div>
                <input type="text" name="name" value="<?php echo $row['name'];?>" placeholder="Full name">
            </div>
            <div>
               <input type="text" name="phone" value="<?php echo $row['phone'];?>" placeholder="Phone number">
            </div>
            <div>
               <input type="text" name="email" value="<?php echo $row['email'];?>" placeholder="Email address">
            </div>
            <div>
               <input type="text" name="password" value="<?php echo $row['password'];?>" placeholder="Password">
            </div>
            <div>
                <select name="role" id="role">
                    <option selected hidden>Role</option>
                    <option value = "admin" <?php if($row['type']==="admin"){echo "selected";}?>>admin</option>
                    <option value = "normal" <?php if($row['type']==="normal"){echo "selected";}?>>normal</option>
                </select>
            </div>
            <div>
                <button type="submit" name="submit">Submit</button>
            </div>

            <!-- condition bracket ends hare -->
            <?php
            }
            mysqli_close($con);
            ?>
            <!------------>
        </form>
    </section>
    <?php require("../footer.php");?>
</body>
</html>