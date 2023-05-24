<?php
session_start();
include("../../db.php");
error_reporting(0);

if(isset($_GET['action']) && $_GET['action']!="")
{
  $product_id=$_GET['product_id'];

  //Delete Action Here
  if($_GET['action']=='delete'){
      ///////picture delete/////////
      $query = "SELECT product_image FROM products WHERE product_id='$product_id'";
      $result = mysqli_query($con, $query);

      // Check if the query was successful
      if ($result) {
        $row = mysqli_fetch_assoc($result);
        $picture = $row['product_image'];

        // Construct the image path
        $path = "../../product_images/$picture";

        if (file_exists($path)) {
          if (unlink($path)) {
            echo 'Pleased wait while we redirect .....';
          } else {
            echo 'Failed to remove the image file.';
          }
        } else {
          echo 'Image file does not exist.';
        }
      } 
      else {
        echo "Failed to retrieve image from the database.";
      }

      /*this is delet query*/
      $delete_query = mysqli_query($con, "DELETE FROM products WHERE product_id='$product_id'");
      // Check if deletion was successful
      if ($delete_query && mysqli_affected_rows($con) > 0) {
        echo '<script>alert("Product deleted successfully!");</script>';
        echo '<script>
          setTimeout(function() {
            window.location.href = "../admin/products_list.php";
          }, 2000); // 2000 milliseconds = 2 seconds
        </script>';
        exit();
      } 
      else {
        echo '<script>alert("Failed to delete product.");</script>';
      }
  }
  else if($_GET['action']=='update'){
      echo '<script>alert("Update here now");</script>';
  }
}

///pagination
$page=$_GET['page'];

if($page=="" || $page=="1")
{
  $page1=0;	
}
else
{
  $page1=($page*10)-10;	
} 
include "sidenav.php";
include "topheader.php";
?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
         <div class="col-md-14">
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title"> Products List</h4>
                
              </div>
              <div class="card-body">
                <div class="table-responsive ps">
                  <table class="table tablesorter " id="page1" style='width:80%;'>
                    <thead class=" text-primary">
                      <tr><th>Image</th><th>Name</th><th>Price</th><th>
	                      <a class=" btn btn-primary" href="add_products.php">Add New</a></th></tr></thead>
                    <tbody>
                      <?php 

                        $result=mysqli_query($con,"select product_id,product_image, product_title,product_price from products Limit $page1,10")or die ("query 1 incorrect.....");

                        while(list($product_id,$image,$product_name,$price)=mysqli_fetch_array($result))
                        {
                          echo "
                          <tr>
                            <td style='width:20%;'><img src='../../product_images/$image' style='width:50px; height:50px; border:groove #000'>
                            </td style='width:40%;'><td>$product_name</td>
                            <td style='width:20%;'>$price</td>
                            <td style='width:10%;'><a class=' btn btn-success' href='products_list.php?product_id=$product_id&action=update'>Update</a></td>
                            <td style='width:10%;'><a class=' btn btn-danger' href='products_list.php?product_id=$product_id&action=delete'>Delete</a></td>
                          </tr>";
                        }

                        ?>
                    </tbody>
                  </table>
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>
            </div>
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                 <?php 
                  //counting paging
                  $paging=mysqli_query($con,"select product_id,product_image, product_title,product_price from products");
                  $count=mysqli_num_rows($paging);

                  $a=$count/10;
                  $a=ceil($a);
                  
                  for($b=1; $b<=$a;$b++)
                  {
                  ?> 
                    <li class="page-item"><a class="page-link" href="products_list.php?page=<?php echo $b;?>"><?php echo $b." ";?></a></li>
                  <?php	
                  }
                  ?>
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
      <?php
include "footer.php";
?>