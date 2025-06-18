<?php

if(isset($_GET['category_id'])){
    $id = $_GET['category_id'];
    // hare category is selected means show posts category wise
}
else{
    $id = false;
    // false means no category selected it means show all posts
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="icons/css/all.css">
    <link rel="stylesheet" href="style/responsive.css">
    <link rel="stylesheet" href="style/news.css">
    <title>News</title>

    <style>
        .category_selected{
            background-color:#04AA6D;
            border-bottom: 2px solid black;
        }
    </style>

</head>
<body>

<!-- header -->
<?php require("header.php");?>
    <!-- Content section -->
    <section class="content">
            <!-- sidebar to show the categories wise new -->
            <side class="sidebar_catgories">
                <ul class="side_catgory">
                    
                <?php
                
                $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
                $query = "SELECT category_id,category_name FROM category";
                $res = mysqli_query($con,$query) or die(mysqli_error($con));
                if(mysqli_num_rows($res)){
                    while($row = mysqli_fetch_assoc($res)){

                        if($row['category_id']===$id){
                            session_start();
                            $_SESSION['selected'] = "category_selected";
                        }
                        else{
                            if(isset($_SESSION['selected'])){
                                session_unset();
                                session_destroy();
                            }
                        }
                
                ?>
                <li><a href="news.php?category_id=<?php echo $row['category_id'];?>" class="<?php if(isset($_SESSION['selected'])){echo $_SESSION['selected'];}?>"><?php echo $row['category_name'];?></a></li>

                <?php 
                    }
                }
                ?>

                </ul>
            </side>

        <!-- news section hare -->
        
        <div class="news_list">
            <?php
             if($id!==false){
                $query = "SELECT *,name FROM post INNER JOIN admin ON post.Author = admin.id WHERE Category = $id ORDER by post_id DESC";
                // SELECT *,name FROM post INNER JOIN admin ON post.Author = admin.id WHERE post_id
             }
             else{
                $query = "SELECT *,name FROM post INNER JOIN admin ON post.Author = admin.id ORDER by post_id DESC";
             }
             $res = mysqli_query($con,$query) or die(mysqli_error($con));
             if(mysqli_num_rows($res)>0){
                while($row = mysqli_fetch_assoc($res)){

            ?>           
            
            <section class="news">
                <div class="news_image"><img src="Upload-post-image/<?php echo $row['post_image'];?>" alt="post" width="300px" height="500px"></div>
                <div class="news_title"><h2><?php echo $row['post_title'];?></h2></div>
                <div class="new_desc"><p><?php echo $row['post_desc'];?></p></div>
                <div class="author">&nbsp;&nbsp;&nbsp;&nbsp;Author: <span><?php echo $row['name'];?></span></div>
                <div class="news_date"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:</span> <?php echo $row['post_date'];?></div>
                <div class="news_time"><span>Time: </span><?php echo $row['post_time'];?></div>
            </section>

        <?php  
              }
           }
           mysqli_close($con);
            ?>
        </div>

        <!-- search box -->
       <!-- hare -->

</section>

<!-- Footer section -->
<?php require("footer.php");?>

</body>
<script src="jsfolder/script.js"></script>
</html>