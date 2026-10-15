<?php
session_start();
include('../config/connection.php');

function validate_category($category_name){
    $category_name = trim($category_name);
    if(empty($category_name)){
       return "Category name is required";
    }
    if(!preg_match("/^[a-zA-Z\s]{3,20}$/", $category_name)){
        return "Category name must be between 3 and 20 characters";
    }
    return "true";
   
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: addcategory.php');
    exit;
}

$catName = $_POST['category_name']; //12345
$catids = $_POST['catId'];




$validatedcat = validate_category($catName);

if($validatedcat !== "true"){
   $_SESSION['category_error'] = $validatedcat;
   header('Location: addcategory.php');
   exit;
}

//insert into database
$query = " update categories set category_name = '$catName' where id = $catids";
$res = mysqli_query($conn ,$query);
if ($res){
    echo "<script>alert(' Category updated successfully')</script>";
    header('Location: categorylist.php');
}
else{
    echo "<script>alert('Failed to add category')</script>";
}

?>