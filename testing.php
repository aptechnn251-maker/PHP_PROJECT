<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="testing.php" method = "post" enctype="multipart/form-data">

        <input type="file" name = "image">
        <input type="submit" name = "submit" value = "Upload">

    </form>


    <?php
        if(isset($_POST['submit']) && isset($_FILES['image'])){
            $imgUpload = $_FILES['image'];

            echo "<pre>";
            print_r($imgUpload);
            echo "</pre>";

            echo $imgUpload['type'];

        }
    ?>
</body>
</html>