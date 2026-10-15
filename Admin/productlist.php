<?php
session_start();
include 'header.php';
include('../config/connection.php');

$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);
?>



<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product /</span> Product List</h4>

              <!-- Basic Bootstrap Table -->
              <div class="card">
                <h5 class="card-header">All Products</h5>
                <div class="table-responsive text-nowrap">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Product Name</th>
                        <th>Category Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                    <?php
                    
                        $query = "SELECT products.*, categories.name FROM products LEFT JOIN categories ON products.category_id = categories.id";
                        $res = mysqli_query($conn,$query);
                        if($res && mysqli_num_rows($res) > 0){
                            while($row = mysqli_fetch_assoc($res)){
                    ?>
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php  echo $row['product_name']?></strong></td>
                        <td><?php  echo $row['name']?></td>
                        <td><?php  echo $row['price']?></td>
                        <td><img src="../upload/<?php echo $row['image']?>" width="60" height="60"></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="productedit.php?id=<?php echo $row['id']?>"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="productdelete.php?delid=<?php echo $row['id']?>"
                                ><i class="bx bx-trash me-1"></i> Delete</a
                              >
                            </div>
                          </div>
                        </td>
                      </tr>
                    <?php    
                            }
                        }
                        else{
                            echo "No products found";
                        }
                    ?>
                      
                     
                    </tbody>
                  </table>
                </div>
              </div>
              <!--/ Basic Bootstrap Table -->
            </div>
</div>

<?php include 'footer.php'?>
