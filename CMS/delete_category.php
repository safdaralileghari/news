<?php 

if(isset($_COOKIE['category_id'])){
    session_start();
    $_SESSION['category_id'] = $_COOKIE['category_id'];
}
else{
    print_r($_SESSION);
    die("error accured!");
}

 $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
 $query1 = "DELETE FROM post WHERE category = {$_SESSION['category_id']}"; 
 mysqli_query($con,$query1) or die("cant delete posts of that category");
 $query2 = "DELETE FROM category WHERE  category_id={$_SESSION['category_id']}";
 mysqli_query($con,$query2) or die("cant delete the category");
 header("Location: catgory_manage.php");
 mysqli_close($con);
?>