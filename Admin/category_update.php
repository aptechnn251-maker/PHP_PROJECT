<?php
    session_start();
    include('../config/connection.php');


    function validate_category($name){

        $name = trim($name);
       $name = stripcslashes($name);
        $name = htmlspecialchars($name);


        if(empty($name)){
            return "Category name is required";
        }
        if(!preg_match("/^[a-zA-Z]*$/", $name)){
            return "Only letters allowed";
        }
        return true;
    }


    if($_SERVER['REQUEST_METHOD'] != "POST"){

        header("Location: addcategory.php");
        exit;

    }
    $catgoryId = $_POST['catID'];
    $catName = $_POST['name']; //123

    $validate = validate_category($catName);

    if($validate !== true){
       $_SESSION['category_error'] = $validate;
       header('location: addcategory.php');
       exit;
    }
    
   $query = "update categories set name = '$catName' where id = $catgoryId";
   $res = mysqli_query($conn, $query);
   if($res){
     echo "<script>alert('Category Added Successfully');</script>";
     header('location: categorylist.php');
   }
   else{
     echo "<script>alert('Category Not Added');</script>";
     header('location: addcategory.php');
   }

?>