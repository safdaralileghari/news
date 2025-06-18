<?php
session_start();

/// hare we unset all error sessions that means when we login our account it is possible that we have made error
// in username or in password thats why we unset sessions have to prevent showing those errors again when the user
// logedin successfully 
unset($_SESSION['error_class']);
unset($_SESSION['error']); 
// the sessions of error_class and error indexes will be unseated and rest are available like previous

if(isset($_SESSION)){
    if(isset($_SESSION['type'])){
        if($_SESSION['type']!=="admin" && $_SESSION['type']!=="normal"){
            echo $_SESSION['type']."<br>";
            die("link error!");
        }
    }
    else{
        header("Location: userlogin.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/responsive.css">

    <script src="../Jquery/jquery.js"></script>

    <title>dashboard</title>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="../icons/world-news.png" alt="news_icon" width="100px" height="100px">
        </div>
        <ul class="list" id="nav_list">
            <li><a href="<?php echo $_SERVER['PHP_SELF'];?>">Dashboard</a></li>
            <li><a href="catgory_manage.php">Categories</a></li>
            <li><a href="Posts.php">News</a></li>
            <?php
            if(isset($_SESSION['type'])){
                if($_SESSION['type']==="admin"){   
            ?>
            <li><a href="Users.php">Users</a></li>
            <?php 
               }
            }
            ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <section class="contaner">
        <?php 

        $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
     
        $query1 = "SELECT COUNT(category_id) FROM category";
        $res1 = mysqli_query($con,$query1) or die(mysqli_error($con));

        $query2 = "SELECT COUNT(id) FROM admin";
        $res2 = mysqli_query($con,$query2) or die(mysqli_error($con));

        if($_SESSION['type']==="admin"){
            $query3 = "SELECT COUNT(post_id) FROM post";
            // $query3 = "SELECT SUM(post) FROM category";
        }
        else{
            $query3 = "SELECT COUNT(post_id) FROM post INNER JOIN admin on admin.id = post.Author WHERE admin.id = {$_SESSION['id']}";
        }
        
        $res3 = mysqli_query($con,$query3) or die(mysqli_error($con));
        if(mysqli_num_rows($res1)>0 && mysqli_num_rows($res2)>0 && mysqli_num_rows($res3)>0){
            
            $row1 = mysqli_fetch_row($res1);
            $row2 = mysqli_fetch_row($res2);
            $row3 = mysqli_fetch_row($res3);

            $total_categories = $row1[0];
            $total_users = $row2[0];
            $total_posts = $row3[0];

        }
        if($_SESSION['type']==="admin"){
        ?>
            <div class="users" id="users"><h2><?php echo $total_users;?> Users Registred</h2></div>
            <div class="catgories_menu" id="categories"><h2><?php echo $total_categories;?> Catgories Added</h2></div>
            <div class="news_menu" id="news"><h2><?php echo $total_posts;?> News published</h2></div>
        <?php
        }
        else if($_SESSION['type']==="normal"){
        ?>
            <div class="catgories_menu" id="categories"><h2><?php echo $total_categories;?> Catgories Added</h2></div>
            <div class="news_menu" id="news"><h2><?php echo $total_posts;?> News published</h2></div>
        <?php
        }

        mysqli_close($con);

        ?>
    </section>
    <?php require("../footer.php");?>


<script>

/**** JQuery hare ****/

$(document).ready(function(){
    $("#users").click(function(){
        location.href = "users.php";
    });
    $("#categories").click(function(){
        location.href  = "catgory_manage.php";
    });
    $("#news").click(function(){
        location.href = "Posts.php";
    });
});

</script>
</body>
</html>