<?php
    session_start();
    if(!isset($_SESSION['type'])){
       header("Location: userlogin.php");
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
    <style>
        #edit,#delete{
            transition: .25s;
            cursor: pointer;
        }
        #edit:hover,#delete:hover{
            transform: scale(1.2,1.2);
        }
    </style>
    <title>dashboard</title>
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
    <section class="category_contaner">


    <?php 
    
        if(isset($_SESSION['id'])){
            echo "<div class = 'add_category'>";
            // in this div there we have class add_category because button is styled in add_category class seletor
            echo "<a href='Add_Post.php'>Add Post</a>";
            echo "</div>";
        }
    
    ?>

        <table border = "2" class="category_table" >
            <thead>
                <tr>
                    <th>S.NO.</th>
                    <th>NEWS TITLE</th>
                    <th>CATEGORY</th>
                    <th>NEWS IMAGE</th>
                    <th>NEWS DATE</th>
                    <th>AUTHOR</th>                   
                    <th>EDIT</th>
                    <th>DELETE</th>
                    <!-- <th style = "display:<?php // echo $_SESSION['display'];?>;">DELETE</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                
                      $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
                      if($_SESSION['type']==="admin"){
                        $query = "SELECT post_id,post_title,category_name,post_image,post_date,post_time,name FROM post INNER JOIN category ON post.Category = category.category_id INNER JOIN admin ON post.Author = admin.id";
                      }
                      else if($_SESSION['type']==="normal"){
                        $query = "SELECT post_id,post_title,category_name,post_image,post_date,post_time,name FROM post INNER JOIN category ON post.Category = category.category_id INNER JOIN admin ON post.Author = admin.id WHERE admin.id = {$_SESSION['id']}";
                      }
                      $res = mysqli_query($con,$query) or die(mysqli_error($con));
                      if(mysqli_num_rows($res)>0){
                        $sno = 1;
                        while($row = mysqli_fetch_assoc($res)){
                ?>
                <tr>
                    <th scope="row"><?php echo $sno++?></th>
                    <td style="width: 300px;padding-left:10px ;"><?php echo $row['post_title']?></td>
                    <td><?php echo $row['category_name'];?></td>
                    <td><img src="../Upload-post-image/<?php echo $row['post_image'];?>" width="100px" height="70px"></td>
                    <td><?php echo $row['post_date'];?> <br> <?php echo $row['post_time'];?></td>
                    <td><?php echo $row['name'];?></td>
                    <td ><img src="../icons/editing.png" alt="edit-icon" width="30px" height="30px" id="edit" onclick="editPost('<?php echo $row['post_id']?>')"></td>
                    <td style = "display:<?php if(isset($_POST['display'])){echo $_SESSION['display'];}?>;"><img src="../icons/delete.png" alt="edit-icon" width="30px" height="30px" id="delete" onclick="deletePost('<?php echo $row['post_id']?>')"></td>
                </tr>
                <?php 
                   }
                }
                mysqli_close($con);
                ?>
            </tbody>
        </table>
    </section>
    <?php require("../footer.php");?>
    <script>

        function editPost(value){
            
            document.cookie = "post_id="+value;
            location.href ="edit_post.php";

        }
        function deletePost(value){    
            document.cookie = "post_id="+value;
            location.href ="delete_post.php";
        
        }
    </script>
</body>

</html>