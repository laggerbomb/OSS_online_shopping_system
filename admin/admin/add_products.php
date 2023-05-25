<?php
session_start();
include("../../db.php");


if(isset($_POST['btn_save']))
{
  $product_name=$_POST['product_name'];
  $details=$_POST['details'];
  $price=$_POST['price'];
  $product_type=$_POST['product_type'];
  $brand=$_POST['brand'];
  $tags=$_POST['tags'];

  //picture coding
  $picture_name=$_FILES['picture']['name'];
  $picture_type=$_FILES['picture']['type'];
  $picture_tmp_name=$_FILES['picture']['tmp_name'];
  $picture_size=$_FILES['picture']['size'];

  if($picture_type=="image/jpeg" || $picture_type=="image/jpg" || $picture_type=="image/png" || $picture_type=="image/gif")
  {
    // Picture less than 50MB
    if ($picture_size <= 50000000){
      move_uploaded_file($picture_tmp_name,"../../product_images/".$picture_name);

      //insert the details to database
      $query = "INSERT INTO products 
        (product_cat, product_brand, product_title, product_price, product_desc, product_image, product_keywords) 
        VALUES ('$product_type', '$brand', '$product_name', '$price', '$details', '$picture_name', '$tags')";
      $result = mysqli_query($con, $query);

      if ($result) {
        echo '<script>alert("Product Added successfully!");</script>';
        //redirect back to menu
        echo "<script>window.location.href = 'products_list.php';</script>";
        exit();
      } 
      else {
        // Display the error message
        echo '<script>alert("Error: ' . $con->error . '");</script>';
      }
    }
    else{
      echo '<script>alert("Image Size too big");</script>';
    }
  }

  mysqli_close($con);
}
include "sidenav.php";
include "topheader.php";
?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <form action="" method="post" type="form" name="form" enctype="multipart/form-data">
          <div class="row">
         <div class="col-md-7">
            <div class="card">
              <div class="card-header card-header-primary">
                <h5 class="title">Add Product</h5>
              </div>
              <div class="card-body">
                
                  <div class="row">
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Title</label>
                        <input type="text" id="product_name" required name="product_name" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="">
                        <label for="">Add Image</label>
                        <input type="file" name="picture" required class="btn btn-fill btn-success" id="picture" >
                      </div>
                    </div>
                     <div class="col-md-12">
                      <div class="form-group">
                        <label>Description</label>
                        <textarea rows="4" cols="80" id="details" required name="details" class="form-control"></textarea>
                      </div>
                    </div>
                  
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Pricing</label>
                        <input type="number" id="price" name="price" required class="form-control" >
                      </div>
                    </div>
                  </div>
              </div>
              
            </div>
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-header card-header-primary">
                <h5 class="title">Categories</h5>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Category</label>
                          <select id="product_type" name="product_type" required class="form-control" 
                            style="background-color:#212840; color: white;">
                          <?php
                          $query = "SELECT cat_id, cat_title FROM categories";
                          $result = mysqli_query($con, $query);
                          if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                              $cat_id = $row['cat_id'];
                              $cat_title = $row['cat_title'];
                              echo '<option value="'. $cat_id .'">' . $cat_title . '</option>';
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="">Product Brand</label>
                        <select id="brand" name="brand" required class="form-control" 
                            style="background-color:#212840; color: white;">
                          <?php
                          $query = "SELECT brand_id , brand_title  FROM brands";
                          $result = mysqli_query($con, $query);
                          if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                              $brand_id = $row['brand_id'];
                              $brand_title = $row['brand_title'];
                              echo '<option value="'. $brand_id .'">' . $brand_title . '</option>';
                            }
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                     
                  
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Product Keywords</label>
                        <input type="text" id="tags" name="tags" required class="form-control" >
                      </div>
                    </div>
                  </div>
                
              </div>
              <div class="card-footer">
                  <button type="submit" id="btn_save" name="btn_save" required class="btn btn-fill btn-primary">Add Product</button>
              </div>
            </div>
          </div>
          
        </div>
         </form>
          
        </div>
      </div>
      <?php
include "footer.php";
?>