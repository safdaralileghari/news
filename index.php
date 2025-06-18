<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="icons/css/all.css">
    <link rel="stylesheet" href="style/responsive.css">
    <title>Home</title>
</head>
<body>

    
<?php require("header.php");?>

    <!-- Content section -->
    <section class="content">
        
        <!-- catogries to show catogries wise news -->
        <div class="catgories">
              <div class="cat_items">
                

              
              <!-- we insert 3 latest categories in cart-items -->
              <!-- php starts hare  -->
            <?php

              $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
              $query = "SELECT * FROM `category` ORDER BY category_id DESC";
              $res = mysqli_query($con,$query) or die(mysqli_error($con));
              if(mysqli_num_rows($res)>0){
                $count = 1;
                while($row = mysqli_fetch_assoc($res)){
     
                    $image = $row['category_image'];
                    $name = $row['category_name'];
            ?>
                <div onclick="showCategorieNews(<?php echo $row['category_id'];?>)">
                    <img src="catgories_images/<?php echo $image;?>" alt="<?php echo $row['category_name'];?>" width="150px" height="140px">
                    <h3><?php echo $name;?></h3>
                </div>

            <?php
                if($count===3)
                    break;

                    $count++;
                    }
                }
                mysqli_close($con);
            ?>

              </div>

        </div>

        <!-- sidebar to show some latest posts -->   
        <side class="sidebar">
            <!-- latest posts -->

            <!-- there are 10 latest posts are shown in sidebar -->
        <?php
            $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
            $query = "SELECT * FROM post";
            $res = mysqli_query($con,$query) or die(mysqli_error($con));
            if(mysqli_num_rows($res)>0){
                $count = 1;
                while($row = mysqli_fetch_assoc($res)){
        ?>
            <div class="latest_post" onclick="latestPost(<?php echo $row['post_id'];?>)">
                <div class="img_link">
                    <div class="image"><img src="news_pics/<?php echo $row['post_image'];?>" alt="<?php ?>" width="85px" height="80px"></div>
                    <div class="news_link"><a href="#"><?php echo $row['post_title'];?></a></div>
                </div>
                <div class="date_time">
                    <div class="date"><?php echo $row['post_date'];?></div>
                    <div class="time"><?php echo $row['post_time'];?></div>
                </div>
            </div>

            <?php
            if($count===10){
                break;            
                }
            }
        }
            mysqli_close($con); 
            ?>
        </side>

       
        
</section>

<?php require("footer.php");?>
</body>
<script src="jsfolder/script.js"></script>
<script>
    
    function showCategorieNews(value){
       location.href = "news.php?category_id="+value;
    }
    function latestPost(value){
        document.cookie = "post_id="+value;
        location.href = "readpost.php";
    }

</script>
</html>