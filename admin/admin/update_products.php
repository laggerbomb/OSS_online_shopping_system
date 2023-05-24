<?php
  session_start();
  include("../../db.php");
  include "sidenav.php";
  include "topheader.php";
?>

<?php
  //get the product_id from the product list menu
  if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($con, $query);
    
    if ($result) {
      // Process the query result and fetch the product data
      while ($row = mysqli_fetch_assoc($result)) {
        // Access the product data
        $product_title = $row['product_title'];
        $product_desc = $row['product_desc'];
        $product_price = $row['product_price'];
        $product_cat = $row['product_cat'];
        $product_brand = $row['product_brand'];
        $product_keywords = $row['product_keywords'];
      }
    } else {
      // Redirect to product list meu.php (if not found)
      echo "<script>window.location.href = 'products_list.php';</script>";
      exit;
    }

  } else {
      // Redirect to product list meu.php (if not found)
      echo "<script>window.location.href = 'products_list.php';</script>";
      exit;
  }
?>

<?php
  if(isset($_POST['btn_update']))
  {
    $product_title=$_POST['product_title'];
    $product_desc=$_POST['product_desc'];
    $product_price=$_POST['product_price'];
    $product_cat=$_POST['product_cat'];
    $product_brand=$_POST['product_brand'];
    $product_keywords=$_POST['product_keywords'];
  
    $query = "UPDATE products 
      SET product_title='$product_title', product_desc='$product_desc', 
        product_price='$product_price', product_cat='$product_cat', 
        product_brand='$product_brand', product_keywords='$product_keywords' 
        WHERE product_id = '$product_id'";
    $result = mysqli_query($con, $query);
  
    if ($result) {
      echo '<script>alert("Product Update successfully!");</script>';
      //redirect back to menu
      echo "<script>window.location.href = 'products_list.php';</script>";
      exit();
    } 
    else {
      // Display the error message
      echo '<script>alert("Error: ' . $con->error . '");</script>';
    }
  
    mysqli_close($con);
  }
?>

    <!-- End Navbar -->
    <div class="content">
      <div class="container-fluid">
        <form action="" method="post" type="form" name="form" enctype="multipart/form-data">
        <div class="row">
        <div class="col-md-7">
          <div class="card">
            <div class="card-header card-header-primary">
              <h5 class="title">Update Product</h5>
            </div>
            <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Product Title</label>
                      <input type="text" id="product_title" required name="product_title" class="form-control" value="<?php echo $product_title; ?>">
                    </div>
                  </div>
                    <div class="col-md-12">
                    <div class="form-group">
                      <label>Description</label>
                      <textarea rows="4" cols="80" id="product_desc" required name="product_desc" class="form-control"><?php echo $product_desc; ?></textarea>
                    </div>
                  </div>
                
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Pricing</label>
                      <input type="number" id="product_price" name="product_price" required class="form-control" value="<?php echo $product_price; ?>">
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
                      <select id="product_cat" name="product_cat" required class="form-control" style="background-color:#212840; color: white;">
                        <?php
                        $query = "SELECT cat_id, cat_title FROM categories";
                        $result = mysqli_query($con, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            $cat_id = $row['cat_id'];
                            $cat_title = $row['cat_title'];
                            $selected = ($cat_id == $product_cat) ? 'selected' : '';
                            echo '<option value="'. $cat_id .'" ' . $selected . '>' . $cat_title . '</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="">Product Brand</label>
                      <select id="product_brand" name="product_brand" required class="form-control" style="background-color:#212840; color: white;">
                        <?php
                        $query = "SELECT brand_id, brand_title FROM brands";
                        $result = mysqli_query($con, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                            $brand_id = $row['brand_id'];
                            $brand_title = $row['brand_title'];
                            $selected = ($brand_id == $product_brand) ? 'selected' : '';
                            echo '<option value="'. $brand_id .'" ' . $selected . '>' . $brand_title . '</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Product Keywords</label>
                      <input type="text" id="product_keywords" name="product_keywords" required class="form-control" value="<?php echo $product_keywords; ?>">
                    </div>
                  </div>
                </div>
              
            </div>
            <div class="card-footer">
                <button type="submit" id="btn_update" name="btn_update" required class="btn btn-fill btn-primary">Update Product</button>
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