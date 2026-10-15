<?php
include('../config/connection.php');

$proddel = $_GET['delid'];

// fetch image to delete file
$imgquery = "select image from products where id = $proddel";
$imgres = mysqli_query($conn, $imgquery);
if ($imgres && mysqli_num_rows($imgres) > 0) {
    $imgrow = mysqli_fetch_assoc($imgres);
    $imgfile = "../upload/" . $imgrow['image'];
    if ($imgrow['image'] != '' && file_exists($imgfile)) {
        unlink($imgfile);
    }
}

$query = "delete from products where id = $proddel";
$res = mysqli_query($conn, $query);
if ($res) {
    echo "<script>alert('Product deleted successfully')</script>";
    header('Location: productlist.php');
}
?>
