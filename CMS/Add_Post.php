<script>
    let time = new Date();
    document.cookie = "time="+time.getHours()+":"+time.getMinutes()+":"+time.getSeconds();
</script>

<?php

// our session starts hare
session_start();
if(!isset($_SESSION['type'])){
    header("Location: userlogin.php");
}

// if(isset($_COOKIE['time'])){
//     $time = $_COOKIE['time'];
// }
// setcookie("time","",time()-3600);  //to clear cookie

if(isset($_POST['submit'])){
    if(isset($_FILES)){
        if(!empty($_FILES['post-image']['name'])){
            if(!empty($_POST['categories']) && $_POST['categories']!=="Categories"){
                if(!empty($_POST['title'])){
                    if(!empty($_POST['desc'])){
                        
                        $img_tmp_name = $_FILES['post-image']['tmp_name'];
                        $img_file_name = $_FILES['post-image']['name'];
                       
                        if(move_uploaded_file($img_tmp_name,"../Upload-post-image/".$img_file_name)){
                            $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
                            $res = mysqli_query($con,"SELECT * FROM category WHERE category_name='{$_POST['categories']}'") or die(mysqli_error($con));
                            if(mysqli_num_rows($res)>0){
                                $row = mysqli_fetch_assoc($res);
                                $category_id = $row['category_id'];
                                $date = date("Y-m-d");
                                $time = time()-3600;
                                $query = "INSERT INTO post(post_title,post_desc,post_date,post_time,post_image,Category,Author) VALUES('{$_POST['title']}','{$_POST['desc']}','{$date}','{$time}','{$img_file_name}','{$category_id}','{$_SESSION['id']}')";
                                mysqli_query($con,$query) or die(mysqli_error($con));                                     
                                // $totalpost = mysqli_query($con,"SELECT * FROM post WHERE category ={$category_id}");
                                // $totalpost = mysqli_fetch_row($totalpost);
                                // mysqli_query($con,"UPDATE category SET post = $totalpost[0]+1 WHERE category_id ={$category_id}") or die(mysqli_error($con));                                
                          
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
            <li><a href="Users.php">Users</a></li>
            <?php 
               }
            }
            ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <section class="contaner catgories_form" style="width:600px;height: 570px;margin:10px auto;display: block;">
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
        <div>
                <label for="image">Select news image</label><br>
                <input type="file" name="post-image" style="margin-left: -10px;margin-top:10px;">
            </div>
            <div>
                <select name="categories">
                    <option value="Categories" hidden>Categories</option>
                    <?php
                       $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
                       $query = "SELECT * FROM category";
                       $res = mysqli_query($con,$query) or die(mysqli_error($con));
                       if(mysqli_num_rows($res)>0){
                          while($row = mysqli_fetch_assoc($res)){
                              echo "<option>";
                              echo $row['category_name'];
                              echo "</option>";
                          }
                       }
                       mysqli_close($con);
                    ?>
                </select>
            </div>
            <div>
                <input type="text" name="title" placeholder="Title">
            </div>
            <div>
                <textarea name="desc" id="catgory_desc" cols="80" rows="10" placeholder="Enter Description For News "></textarea>
            </div>
            <div>
                <button type="submit" name="submit">Submit</button>
            </div>
        </form>
    </section>
    <?php require("../footer.php");?>
</body>
</html>