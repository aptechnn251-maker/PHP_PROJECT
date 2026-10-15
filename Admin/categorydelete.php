<?php

    include('../config/connection.php');


   $catdel =  $_GET['delid'];

   $query = "delete from categories where id = $catdel";
   $res = mysqli_query($conn, $query);
   if($res){
    echo "<script>alert('Category deleted successfully')</script>";
    header('Location: categorylist.php');
   }
?>