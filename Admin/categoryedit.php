<?php

session_start();
 $error = $_SESSION['category_error'] ?? "";
unset($_SESSION['category_error']);

include 'header.php';
include('../config/connection.php')?>

<?php

    $category_id = $_GET['id'];
    $query = "select * from categories where id = $category_id";
    $res = mysqli_query($conn, $query);

    if($res && mysqli_num_rows($res) > 0){
        $category = mysqli_fetch_assoc($res);
        // print_r($category);
    }

    else{
        echo "Category not found";
        header('Location: addcategory.php');
    }
?>

  
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Category /</span> Add Category</h4>

  <div class="row">
    <div class="col-lg">
      <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">Add New Category</h5>
          <small class="text-muted float-end">Category Management</small>
        </div>
        <div class="card-body">
          <form action = "categoryupdate.php" method = "post">
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="category-name">Category Name</label>
              <div class="col-sm-10">
                <div class="input-group input-group-merge">
                  <span id="category-name-icon" class="input-group-text">
                    <i class="bx bx-category"></i>
                  </span>
                  <input type="hidden" value = <?php echo $category['id']?> name = "catId">
                  <input
                    type="text"
                    class="form-control"
                    id="category-name"
                    name="name"
                    placeholder="e.g. Electronics, Clothing, Software"
                    value = "<?php echo $category['name']?>"
                    aria-label="Category Name"
                    aria-describedby="category-name-icon" 
                    required
                  /> <br>
                  <span id="category-name-error" class="text-danger"> <?php echo $error?></span>
                </div>
              </div>
            </div>

            <div class="row justify-content-end">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Update Category</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- / Content -->



<?php include 'footer.php'?>