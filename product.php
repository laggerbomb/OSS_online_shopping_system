<?php
include "header.php";
?>
		<!-- /BREADCRUMB -->
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});
</script>
		<script>
    
    (function (global) {
	if(typeof (global) === "undefined")
	{
		throw new Error("window is undefined");
	}
    var _hash = "!";
    var noBackPlease = function () {
        global.location.href += "#";
		// making sure we have the fruit available for juice....
		// 50 milliseconds for just once do not cost much (^__^)
        global.setTimeout(function () {
            global.location.href += "!";
        }, 50);
    };	
	// Earlier we had setInerval here....
    global.onhashchange = function () {
        if (global.location.hash !== _hash) {
            global.location.hash = _hash;
        }
    };
    global.onload = function () {        
		noBackPlease();
		// disables backspace on page except on input fields and textarea..
		document.body.onkeydown = function (e) {
            var elm = e.target.nodeName.toLowerCase();
            if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                e.preventDefault();
            }
            // stopping event bubbling up the DOM tree..
            e.stopPropagation();
        };		
    };
})(window);
</script>

		<!-- SECTION -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- Product main img -->
					
					<?php 
						include 'db.php';
						$product_id = $_GET['p'];
						
						$sql = " SELECT * FROM products WHERE product_id = $product_id";
						if (!$con) {
							die("Connection failed: " . mysqli_connect_error());
						}
						$result = mysqli_query($con, $sql);
						if (mysqli_num_rows($result) > 0) 
						{
							while($row = mysqli_fetch_assoc($result)) 
							{
							echo '
                                <div class="col-md-5 col-md-push-2">
                                <div id="product-main-img">
                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>
                                </div>
                            </div>
                                
                                <div class="col-md-2  col-md-pull-5">
                                <div id="product-imgs">
                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'g" alt="">
                                    </div>

                                    <div class="product-preview">
                                        <img src="product_images/'.$row['product_image'].'" alt="">
                                    </div>
                                </div>
                            </div>
						';
                                    
						?>
						<!-- FlexSlider -->
						
				
                    <div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name"><?php echo $row['product_title']; ?></h2>
							<div>
								<h3 class="product-price">$<?php echo $row['product_price']; ?></h3>
								<span class="product-available">In Stock</span>
							</div>
							<p><?php echo $row['product_desc']; ?></p>

							<div class="add-to-cart">
								<div class="btn-group" style="margin-left: 25px; margin-top: 15px">
								<button class="add-to-cart-btn" pid="'.$row['product_id'].'"  id="product" ><i class="fa fa-shopping-cart"></i> add to cart</button>
                                </div>
							</div>

							<ul class="product-links">
								<li>Category:</li>
								<?php
								$sql = "SELECT cat_title FROM categories c
									JOIN products p ON p.product_cat = c.cat_id
									WHERE p.product_id = $product_id";
								$result = mysqli_query($con, $sql);
								
								while ($row = mysqli_fetch_assoc($result)) {
									$categoryName = $row['cat_title'];
									echo '<li><a href="#">' . $categoryName . '</a></li>';
								}
								?>
							</ul>

							<ul class="product-links">
								<li>Share:</li>
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#"><i class="fa fa-envelope"></i></a></li>
							</ul>

						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- Section -->
		<div class="section main main-raised">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
                    
					<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="title">Related Products</h3>
							
						</div>
					</div>
					
					<?php 
							$_SESSION['product_id'] = $row['product_id'];
						}
					} 
					?>	
			<?php
				include 'db.php';
				$product_id = $_GET['p'];
                    
				$product_query = "SELECT * FROM products,categories WHERE product_cat=cat_id AND product_id BETWEEN $product_id AND $product_id+3";
                $run_query = mysqli_query($con,$product_query);
                if(mysqli_num_rows($run_query) > 0){

                    while($row = mysqli_fetch_array($run_query)){
                        $pro_id    = $row['product_id'];
                        $pro_cat   = $row['product_cat'];
                        $pro_brand = $row['product_brand'];
                        $pro_title = $row['product_title'];
                        $pro_price = $row['product_price'];
                        $pro_image = $row['product_image'];

                        $cat_name = $row["cat_title"];

                        echo "
							<div class='col-md-3 col-xs-6'>
							<a href='product.php?p=$pro_id'><div class='product'>
								<div class='product-img'>
									<img src='product_images/$pro_image' style='max-height: 170px;' alt=''>
								</div></a>
								<div class='product-body'>
									<p class='product-category'>$cat_name</p>
									<h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
									<h4 class='product-price header-cart-item-info'>$$pro_price</h4>
								</div>
								<div class='add-to-cart'>
									<button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
								</div>
							</div>
							</div>
						";
					};
      
				}
			?>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /Section -->
<?php
include "newslettter.php";
include "footer.php";

?>
