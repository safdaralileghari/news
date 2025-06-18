<?php 
session_start();
if(!isset($_SESSION['type'])){
    header("Location: userlogin.php");
}
   if(isset($_POST['submit'])){
    if(isset($_POST['catgory_name'])){
        if(!empty($_POST['catgory_name'])){
            if(!empty($_FILES['catgory_image'])){
                $con = mysqli_connect("localhost","root","","news") or die("sql connection field"); 
                $img_tmp_name = $_FILES['catgory_image']['tmp_name'];
                $img_file_name = $_FILES['catgory_image']['name'];
                if(move_uploaded_file($img_tmp_name,"../upload-images/".$img_file_name)){
                    $query = "INSERT INTO category(category_image,category_name) VALUE('{$img_file_name}','{$_POST['catgory_name']}')";
                    mysqli_query($con,$query) or die(mysqli_error($con));
                    header("Location: catgory_manage.php");
                    mysqli_close($con);
                }
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
            <li><a href="http://localhost/code/php%20projects/news/CMS/dashboard.php">Dashboard</a></li>
            <li><a href="<?php echo $_SERVER['PHP_SELF'];?>">Categories</a></li>
            <li><a href="Posts.php">News</a></li>
            <li><a href="Users.php">Users</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <section class="catgories_form">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method = "post" enctype="multipart/form-data">
        <div>
              <input type="text" name="catgory_name" id="catgory_name" placeholder="Catgory name" required>
        </div>
        <div class="catgory_image">
            <input type="file" name="catgory_image" id="catgory_image" required>
        </div>
        <div>
            <button type="submit" name = "submit" style="padding: 5px 15px;font-size:20px;margin:0 12px;">Submit</button>
        </div>
        </form>
    </section>
    <?php require("../footer.php");?>
</body>
</html>