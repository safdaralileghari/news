<?php 
    session_start();
if(!isset($_SESSION['type'])){
    header("Location: userlogin.php");
}

if(isset($_COOKIE['category_name'])){

    $_SESSION['category_name'] = $_COOKIE['category_name'];
}

if(isset($_POST)){
    if(!empty($_POST['catgory_name'])){
        if(isset($_FILES)){
            if(!empty($_FILES['catgory_image'])){
                $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
                $qurey = "UPDATE category set category_name = '{$_POST['catgory_name']}',category_image = '{$_FILES['catgory_image']['name']}' where category_name='{$_SESSION['category_name']}'";
                mysqli_query($con,$qurey) or die(mysqli_error($con));
                header("Location: catgory_manage.php");
            }
        }
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
    <title>Add Catogries</title>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="../icons/world-news.png" alt="news_icon" width="100px" height="100px">
        </div>
        <ul class="list" id="nav_list">
            <li><a href="http://localhost/code/php%20projects/news2/CMS/dashboard.php">Dashboard</a></li>
            <li><a href="<?php echo $_SERVER['PHP_SELF'];?>">Categories</a></li>
            <li><a href="Posts.php">News</a></li>
            <li><a href="Users.php">Users</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <section class="catgories_form">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method = "post" enctype="multipart/form-data">
        
        <?php           
           $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
           $qurey = "SELECT * FROM category WHERE category_name = '{$_SESSION['category_name']}'";
           $res = mysqli_query($con,$qurey) or die(mysqli_error($con));
           if(mysqli_num_rows($res)>0){
              $row = mysqli_fetch_assoc($res);
        ?>
        <div>
              <input type="text" name="catgory_name" id="catgory_name" placeholder="Catgory name" value="<?php echo $row['category_name']?>">
        </div>
        <div class="catgory_image">
            <input type="file" name="catgory_image" id="catgory_image">
        </div>
        <div>
            <button type="submit" name = "submit" style="padding: 5px 15px;font-size:20px;margin:0 12px;">Submit</button>
        </div>
        <?php 
            }
            mysqli_close($con);
        ?> 
    </form>
    </section>
    <?php require("../footer.php");?>
</body>
</html>