
<!-- update sql -->
<?php

session_start();
if(!isset($_SESSION['type'])){
    header("Location: userlogin.php");
}

if(isset($_COOKIE['post_id'])){
    $_SESSION['post_id'] =  $_COOKIE['post_id'];
}

$copy_img = "";
if(isset($_POST['submit'])){
    if(isset($_FILES)){
        if(!empty($_FILES['post-image']['name'])){
            if(!empty($_POST['categories']) && $_POST['categories']!=="Categories"){
                if(!empty($_POST['title'])){
                    if(!empty($_POST['desc'])){
                        $img_tmp_name = $_FILES['post-image']['tmp_name'];
                        $img_file_name = $_FILES['post-image']['name'];
                        if(move_uploaded_file($img_tmp_name,dirname(getcwd())."/Upload-post-image/".$img_file_name)){
                            $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
                            $res = mysqli_query($con,"SELECT * FROM category WHERE category_name='{$_POST['categories']}'") or die(mysqli_error($con));
                            if(mysqli_num_rows($res)>0){
                                $row = mysqli_fetch_assoc($res);
                                $category_id = $row['category_id'];
                                $query = "UPDATE post SET post_title='{$_POST['title']}',post_desc='{$_POST['desc']}',post_image='{$img_file_name}',Category='{$category_id}',Author='{$_SESSION['id']}' WHERE post_id='{$_SESSION['post_id']}'";
                                mysqli_query($con,$query) or die(mysqli_error($con));                                
                                header("Location: Posts.php");
                            }
                            mysqli_close($con);
                        }
                    }
                    else{
                        $_SESSION['error_class'] = "error";
                        $_SESSION['error'] = "Description is nessasory";
                    }
                }
                else{
                    $_SESSION['error_class'] = "error";
                    $_SESSION['error'] = "Title is nessasory";
                }
            }
            else{
                $_SESSION['error_class'] = "error";
                $_SESSION['error'] = "Must selet the category ";
            }
            
        }
        else{
           
            $_SESSION['error_class'] = "error";
            $_SESSION['error'] = "News image is nessasory";
        }
    } 
  }

?>

<!--------->


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
    <title>manage news</title>
</head>
<body>
<nav class="navbar">
        <div class="logo">
            <img src="../icons/world-news.png" alt="news_icon" width="100px" height="100px">
        </div>
        <ul class="list" id="nav_list">
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="catgory_manage.php">Categories</a></li>
            <li><a href="<?php echo $_SERVER['PHP_SELF'];?>">News</a></li>
            <?php
            if(isset($_SESSION['type'])){
                if($_SESSION['type']==="admin"){   
            ?>
            <li><a href="Users.php" onclick="cheackForImg()">Users</a></li>
            <?php 
               }
            }
            ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <section class="contaner catgories_form" style="width:600px;height: 570px;margin:10px auto;display: block;">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
        <p class="<?php if(isset($_SESSION['error_class'])){echo $_SESSION['error_class'];}?>"><?php if(isset($_SESSION['error_class'])){echo $_SESSION['error'];}?></p>
        <?php
                    $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
                    $res = mysqli_query($con,"SELECT * FROM post WHERE post_id = '{$_SESSION['post_id']}'") or die(mysqli_error($con));
                    if(mysqli_num_rows($res)>0){
                        $row = mysqli_fetch_assoc($res);
        ?>
        <div>
                <label for="image">Select news image</label><br>
                <input type="file" name="post-image" style="margin-left: -10px;margin-top:10px;">
            </div>
            <div>
                <select name="categories">
                    <?php
                       $query = "SELECT * FROM category";
                       $res2 = mysqli_query($con,$query) or die(mysqli_error($con));
                       if(mysqli_num_rows($res2)>0){
                          while($row2 = mysqli_fetch_assoc($res2)){
                            
                             if($row2['category_id']===$row['Category']){
                                echo "<option selected>";
                                echo $row2['category_name'];
                                echo "</option>";
                             }
                             else{
                                echo "<option>";
                                echo $row2['category_name'];
                                echo "</option>";
                             }
                          }
                       }
                       mysqli_close($con);
                    ?>
                </select>
            </div>
            <div>
                <input type="text" name="title" placeholder="Title" value = "<?php echo $row['post_title'];?>">
            </div>
            <div>
                <textarea name="desc" id="catgory_desc" cols="80" rows="10" placeholder="Enter Description For News"><?php echo $row['post_desc'];?></textarea>
            </div>
            <div>
                <button type="submit" name="submit">Submit</button>
            </div>
            <?php
            }
            ?>
        </form>
    </section>
    <?php require("../footer.php");?>
</body>
</html>