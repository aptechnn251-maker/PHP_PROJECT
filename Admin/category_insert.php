<?php
session_start();
include('../config/connection.php');

function validate_category($name){
    $name = trim($name);
    if(empty($name)){
       return "Category name is required";
    }
    if(!preg_match("/^[a-zA-Z\s]{3,20}$/", $name)){
        return "Category name must be between 3 and 20 characters";
    }
    return "true";
   
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: addcategory.php');
    exit;
}

$catName = $_POST['name']; //12345




$validatedcat = validate_category($catName);

if($validatedcat !== "true"){
   $_SESSION['category_error'] = $validatedcat;
   header('Location: addcategory.php');
   exit;
}

//insert into database
$query = "insert into categories (name) values ('$catName')";
$res = mysqli_query($conn ,$query);
if ($res){
    echo "<script>alert(' Category added successfully')</script>";
    header('Location: categorylist.php');
}
else{
    echo "<script>alert('Failed to add category')</script>";
}

?>