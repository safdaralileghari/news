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
            <li><a href="Posts.php">News</a></li>
            <li><a href="<?php echo $_SERVER['PHP_SELF'];?>">Users</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <section class="category_contaner">


    <?php 
    
        if(isset($_SESSION['id'])){
            echo "<div class = 'add_category'>";
            // in this div there we have class add_category because button is styled in add_category class seletor
            echo "<a href='Add-user.php'>Add User</a>";
            echo "</div>";
        }
    ?>

        <table border = "2" class="category_table" >
            <thead>
                <tr>
                    <th>S.NO.</th>
                    <th>NAME</th>
                    <th>PHONE</th>
                    <th>EMAIL</th>
                    <th>TYPE</th>
                    <th style = "display:<?php if(isset($_SESSION['display'])){echo $_SESSION['display'];}?>;">EDIT</th>
                    <th style = "display:<?php if(isset($_SESSION['display'])){echo $_SESSION['display'];}?>;">DELETE</th>
                </tr>
            </thead>
            <tbody>

            <?php
            
            $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
            $query = "SELECT * FROM admin";
            $res = mysqli_query($con,$query) or die(mysqli_error($con));
            $sno = 1;
            if(mysqli_num_rows($res)>0){
                while($row = mysqli_fetch_assoc($res)){
            ?>
                <tr>
                    <th scope="row"><?php echo $sno?></th>
                    <td style="width: 300px;padding-left:10px ;"><?php echo $row['name'];?></td>
                    <td><?php echo $row['phone'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['type'];?></td>
                    <td style = "display:<?php if(isset($_SESSION['display'])){echo $_SESSION['display'];}?>;"><img src="../icons/editing.png" alt="edit-icon" width="30px" height="30px" id="edit" onclick="editUser('<?php echo $row['id']?>')"></td>
                    <?php
                      if($sno>1){
                    ?>
                      <td style = "display:<?php if(isset($_SESSION['display'])){ echo $_SESSION['display'];}?>;"><img src="../icons/delete.png" alt="edit-icon" width="30px" height="30px" id="delete" onclick="deleteUser('<?php echo $row['id']?>')"></td>
                    <?php
                     }
                     else{
                        echo "<td style = 'font-size:15px;color:gray;pointer-events: none;'><b>Can't delete<br>main Admin </b></td>";
                      }
                     $sno++;
                    ?>
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

        function editUser(value){
            document.cookie = "user_id="+value;
            location.href ="edit_user.php";
        }
        function deleteUser(value){ 
            document.cookie = "user_id="+value;
            location.href ="delete_user.php";
        }
    </script>
</body>
</html>