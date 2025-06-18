<?php 

    session_start();
    if(isset($_SESSION['type'])){
        if($_SESSION['type']!=="admin"){
            $_SESSION['display'] = 'none';
        }
    }
    else{
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
            <li><a href="<?php echo $_SERVER['PHP_SELF'];?>">Categories</a></li>
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
    <section class="category_contaner">
        <?php if(isset($_SESSION['type'])){
            if($_SESSION['type']==="admin"){
                echo "<div class = 'add_category'>";
                echo "<a href='add_catrogries.php'>Add Category</a>";
                echo "</div>";
            }
        }
        ?>
        <!-- <div class="add_category">
            <a href="#">Add Category</a>
        </div> -->
        <table border = "2" class="category_table" >
            <thead>
                <tr>
                    <th>S.NO.</th>
                    <th>CATEGORY NAME</th>
                    <th>CATEGORY IMAGE</th>
                    <!-- <th>NO. OF NEWS</th> -->
                    <th style = "display:<?php if(isset($_SESSION['display'])){echo $_SESSION['display'];}?>;">EDIT</th>
                    <th style = "display:<?php if(isset($_SESSION['display'])){echo $_SESSION['display'];}?>;">DELETE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                  $con = mysqli_connect("localhost","root","","news") or die(mysqli_errno($con));
                  $query = "SELECT * FROM `category`  ORDER BY category_id DESC";
                  $result = mysqli_query($con,$query) or die(mysqli_errno($con));
                  if(mysqli_num_rows($result)>0){
                     $count = 1;
                     while($row = mysqli_fetch_assoc($result)){
                        // $cate_name = $row['category_name'];
                        // print_r($row);
                ?>
                <tr>
                    <th scope="row"><?php echo $count++;?></th>
                    <td><?php echo $row['category_name'];?></td>
                    <td><img src="../upload-images/<?php echo $row['category_image'];?>" width="100px" height="70px"></td>
                    <!-- <td><?php //echo $row['post'];?></td> -->
                    <td style = "display:<?php if(isset($_SESSION['display'])){ echo $_SESSION['display'];}?>;"><img src="../icons/editing.png" alt="edit-icon" width="30px" height="30px" id="edit" onclick="editCategory('<?php echo $row['category_name'];?>')"></td>
                    <td style = "display:<?php if(isset($_SESSION['display'])){ echo $_SESSION['display'];}?>;"><img src="../icons/delete.png" alt="edit-icon" width="30px" height="30px" id="delete" onclick="deleteCategory('<?php echo $row['category_id'];?>')"></td>
                </tr>
            <?php 
            }
               }
            ?> 
            </tbody>
        </table>
    </section>
    <?php require("../footer.php");?>
    <script>
        function editCategory(value){
            document.cookie = "category_name="+value;
            location.href = "edit_category.php";
        }
        function deleteCategory(id){
            document.cookie = "category_id="+id;
            location.href = "delete_category.php";
        }
    </script>
</body>
</html>