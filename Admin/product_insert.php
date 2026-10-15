<?php

include '../config/connection.php';
session_start();


//validation functions
function validate_product($productName){
   $prodName =  trim($productName);
   if(empty($prodName)){
    return "Product name is required";
   }
  
}
function validate_price($price){
    $price = trim($price);
    if(empty($price)){
        return "Product price is required";
    }
  if(!is_numeric($price) && $price < 0){
    return "Product price must be a number greater than 0";
  }
return true;
    
}

function description($desc){
    $desc = trim($desc);
    if(empty($desc)){
        return "Product description is required";
    }
    if(strlen($desc) < 250){
        return "Product description must be less than 250 characters";
    }
return true ;
}

if($_SERVER["REQUEST_METHOD"] != "POST"){
    header('Location: product_add.php');
    exit;
}

//
$_SESSION['error'] = []; //empty array intialize

//collect form data
$productName = $_POST['product_name'] ?? '';  //null value
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$Category = $_POST['category_id'] ?? '';



//check testing validation
$resProd = validate_product($productName);
if($resProd !== true){
    $_SESSION['error']['product_name'] = $resProd;
}

$resPrice = validate_price($price);
if($resPrice !== true){
    $_SESSION['error']['price'] = $resPrice;
}

$resDesc = description($description);
if($resDesc !== true){
    $_SESSION['error']['description'] = $resDesc;
}
if(empty($Category)){
    $_SESSION['error']['category_id'] = "Product category is required";
}

//check Image
$new_name = "";
if(isset($_FILES['image']) && $_FILES['image']['error'] !== 4 ){ 
    $img = $_FILES['image'];

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION)); //Apple.jifif
    if(!in_array($ext,$allowed)){
        $_SESSION['error']['image'] = "Only jpg, jpeg, png and gif files are allowed";
    }else if($img['size'] > 2 * 1024 * 1024){
        $_SESSION['error']['image'] = "Image size must be less than 2MB";
    }else{
        $new_name = time(). "_"  .$img['name'];
    }
}
else{
    $_SESSION['error']['image'] = "Product image is required";
}

//Move file to uploads folder
move_uploaded_file($img['tmp_name'], "../upload/$new_name");



//insert data into database
$query = "insert into products (product_name, price, description, quantity, category_id, image) values ('$productName', '$price', '$description', '$quantity', '$Category', '$new_name')";

$res = mysqli_query($conn, $query);
if($res){
    echo "Product added successfully";
}
else{
    echo "Failed to add product";
}


?>


 