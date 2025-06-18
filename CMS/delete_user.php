<?php 

if(isset($_COOKIE['user_id'])){
    session_start();
    $_SESSION['user_id'] = $_COOKIE['user_id'];
}

 $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));
 $query = "DELETE FROM admin WHERE id='{$_SESSION['user_id']}'";
 mysqli_query($con,$query) or die(mysqli_error($con));
 header("Location: Users.php");
 mysqli_close($con);
?>