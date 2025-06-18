<?php 
if(isset($_COOKIE['post_id'])){
    $postid = $_COOKIE['post_id'];
}
else{
    header("Location: index.php");
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
    <title>Home</title>
</head>
<body>

<!-- header -->
<?php require("header.php");?>
    <!-- Content section -->
    <section class="content">
        <!-- news section hare -->
        <div class="news_list">
        <?php 
        

        $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
        $res = mysqli_query($con,"SELECT post_title,post_desc,post_image,post_date,post_time,name FROM post INNER JOIN admin ON post.Author = admin.id WHERE post_id = $postid")or die(mysqli_error($con));
        if(mysqli_num_rows($res)>0){
            $row = mysqli_fetch_assoc($res);
        ?>   
            <section class="news">
                <div class="news_image"><img src="Upload-post-image/<?php echo $row['post_image'];?>" alt="news_image" width="300px" height="500px"></div>
                <div class="news_title"><h2><?php echo $row['post_title'];?></h2></div>
                <div class="new_desc"><p><?php echo $row['post_desc'];?></p></div>
                <div class="author">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Author: <span><?php echo $row['name'];?></span></div>
                <div class="news_date"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date:  </span><?php echo $row['post_date']?></div>
                <div class="news_time">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Time: </span><?php echo $row['post_time'];?></div>
            </section>

        <?php 
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