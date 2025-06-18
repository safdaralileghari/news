<?php 


if(isset($_COOKIE['post_id'])){
    session_start();
    $_SESSION['post_id'] = $_COOKIE['post_id'];
}
 $con = mysqli_connect("localhost","root","","news") or die(mysqli_error($con));

 $category_id = mysqli_query($con,"SELECT Category FROM post WHERE post_id={$_SESSION['post_id']}");
 $query = "DELETE FROM post WHERE  post_id='{$_SESSION['post_id']}'"; 
 mysqli_query($con,$query);

 $category_id = mysqli_fetch_row($category_id);
 
//  $totalpost = mysqli_query($con,"SELECT post FROM category WHERE category_id ={$category_id[0]}");
//  $totalpost = mysqli_fetch_row($totalpost);
//  mysqli_query($con,"UPDATE category SET post = $totalpost[0]-1 WHERE category_id ={$category_id[0]}") or die(mysqli_error($con));                                

 header("Location: posts.php");
 mysqli_close($con);
?>