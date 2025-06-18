<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="icons/css/all.css">
    <link rel="stylesheet" href="style/responsive.css">
    <link rel="stylesheet" href="style/catgories.css">
    <title>Home</title>
</head>
<body>

<?php require("header.php");?>

    <!-- Content section -->
    <section class="content">
        
        <!-- catogries to show catogries wise news -->
        <div class="catgories">
              <div class="cat_items">

              <?php
              
               $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
               $res = mysqli_query($con,"SELECT * FROM category") or die(mysqli_error($con));
               if(mysqli_num_rows($res)>0){
                 while($row = mysqli_fetch_assoc($res)){
              ?>

                <div onclick="showCategorieNews(<?php echo $row['category_id'];?>)">
                    <img src="catgories_images/<?php echo $row['category_image'];?>" alt="<?php echo $row['category_name'];?>" width="150px" height="140px">
                    <h3><?php echo $row['category_name'];?></h3>
                </div>
                
                <?php
                    }                
                }     
                mysqli_close($con);
                ?>
              </div>
        </div>

        <!-- search box -->
        <!--  -->
        <!-- hare -->

</section>

<!-- Footer section -->
<?php require("footer.php");?>

</body>
<script src="jsfolder/script.js"></script>
<script>
    function showCategorieNews(value){
        location.href = "news.php?category_id="+value;
    }
</script>
</html>