<?php
include '../config/connection.php';
session_start();

// validation functions
function validate_product($productName)
{
    $prodName = trim($productName);
    if (empty($prodName)) {
        return "Product name is required";
    }
    return true;
}

function validate_price($price)
{
    $price = trim($price);
    if (empty($price)) {
        return "Product price is required";
    }
    if (!is_numeric($price) && $price < 0) {
        return "Product price must be a number greater than 0";
    }
    return true;
}

function validate_desc($desc)
{
    $desc = trim($desc);
    if (empty($desc)) {
        return "Product description is required";
    }
    if (strlen($desc) > 250) {
        return "Product description must be less than 250 characters";
    }
    return true;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header('Location: productlist.php');
    exit;
}

$_SESSION['error'] = [];

// collect form data
$prodId = $_POST['prodId'] ?? '';
$productName = $_POST['product_name'] ?? '';
$price = $_POST['price'] ?? '';
$description = $_POST['description'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$Category = $_POST['category_id'] ?? '';

// validation
$resProd = validate_product($productName);
if ($resProd !== true) {
    $_SESSION['error']['product_name'] = $resProd;
}

$resPrice = validate_price($price);
if ($resPrice !== true) {
    $_SESSION['error']['price'] = $resPrice;
}

$resDesc = validate_desc($description);
if ($resDesc !== true) {
    $_SESSION['error']['description'] = $resDesc;
}

if (empty($Category)) {
    $_SESSION['error']['category_id'] = "Product category is required";
}

// fetch old image
$oldimg = "";
$getold = "select image from products where id = $prodId";
$getres = mysqli_query($conn, $getold);
if ($getres && mysqli_num_rows($getres) > 0) {
    $oldrow = mysqli_fetch_assoc($getres);
    $oldimg = $oldrow['image'];
}

// handle new image (optional)
$new_name = $oldimg;
if (isset($_FILES['image']) && $_FILES['image']['error'] !== 4) {
    $img = $_FILES['image'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        $_SESSION['error']['image'] = "Only jpg, jpeg, png and gif files are allowed";
    } else if ($img['size'] > 2 * 1024 * 1024) {
        $_SESSION['error']['image'] = "Image size must be less than 2MB";
    } else {
        $new_name = time() . "_" . $img['name'];
        move_uploaded_file($img['tmp_name'], "../upload/$new_name");
        // delete old image file
        if ($oldimg != '' && file_exists("../upload/$oldimg")) {
            unlink("../upload/$oldimg");
        }
    }
}

// if any validation error, go back to edit page
if (!empty($_SESSION['error'])) {
    header('Location: productedit.php?id=' . $prodId);
    exit;
}

// update database
$productName = mysqli_real_escape_string($conn, $productName);
$description = mysqli_real_escape_string($conn, $description);
$price = mysqli_real_escape_string($conn, $price);
$quantity = mysqli_real_escape_string($conn, $quantity);

$query = "update products set product_name = '$productName', price = '$price', description = '$description', quantity = '$quantity', category_id = '$Category', image = '$new_name' where id = $prodId";
$res = mysqli_query($conn, $query);
if ($res) {
    $_SESSION['success'] = "Product updated successfully";
    header('Location: productlist.php');
    exit;
} else {
    $_SESSION['error']['general'] = "Failed to update product";
    header('Location: productedit.php?id=' . $prodId);
    exit;
}
?>
