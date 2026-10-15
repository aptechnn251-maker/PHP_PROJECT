<?php 
session_start();
$err = $_SESSION['error'] ?? '';
unset($_SESSION['error']);


include('header.php'); ?>
<?php include('../config/connection.php') ?>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product /</span> Add Product</h4>

    <div class="row">
        <div class="col-lg">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Create Product</h5>
                    <small class="text-muted float-end">Product details</small>
                </div>
                <div class="card-body">

                    <form action="product_insert.php" method="POST" enctype="multipart/form-data">
                        <!-- Product Name -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="product_name">Product Name</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-package"></i></span>
                                    <input type="text" name="product_name" id="product_name" class="form-control"
                                        placeholder="e.g. Wireless Headphones" required />
                                      
                                </div>
                                
                                    <span class = "text-danger
                                    "><?php echo $err['product_name'] ?? ''; ?></span>
                            </div>
                        </div>

                        <!-- Category Select -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="category_id">Category</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-category"></i></span>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="" disabled selected>Select Category</option>
                                           <!-- dynamic list -->
                                            <?php
                                            
                                                $query = "select * from categories";
                                                $res = mysqli_query($conn,$query);
                                                if($res && mysqli_num_rows($res) > 0){
                                                    while($row = mysqli_fetch_assoc($res)){
                                            ?>
                                            <option value=" <?php echo $row['id']?>"> <?php echo $row['name']?></option>
                                            <?php
                                                    }
                                                }
                                                else{
                                                    echo "No categories found";
                                                }
                                            ?>
                                            <span class = "text-danger"><?php echo $err['category_id'] ?? ''; ?></span>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <!-- Description -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="description">Description</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-detail"></i></span>
                                    <textarea name="description" id="description" class="form-control" rows="3"
                                        placeholder="Enter product description..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="price">Price</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0" name="price" id="price"
                                        class="form-control" placeholder="0.00" required />
                                </div>
                            </div>
                        </div>

                        <!-- Quantity -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="quantity">Quantity</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-hash"></i></span>
                                    <input type="number" min="0" name="quantity" id="quantity" class="form-control"
                                        placeholder="10" required />
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="image">Product Image</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-image-add"></i></span>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" name="submit" class="btn btn-primary">Save Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->

<?php include('footer.php'); ?>