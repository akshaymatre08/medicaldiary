<?php 
	require_once dirname(__FILE__).'/include/header.php';
	require_once dirname(__FILE__).'/include/api.php';
	require_once dirname(__FILE__).'/include/navbar.php';
?>


    <div class="socialcodia">
        <div class="row">
            <div class="col l2 m4 s12">
            	<div class="card hoverable">
            		<div class="card-content blue lighten-1	 white-text">
            			<h3 style="font-weight: bold;" id="productsCount">0</h3>
            			<p style="font-weight: bold; font-size:20px;">Products</p>
            		</div>
            		<div class="card-action blue darken-2 center">
            			<a class="white-text" href="products">More<i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l2 m4 s12">
            	<div class="card hoverable">
            		<div class="card-content blue lighten-1 white-text">
            			<h3 style="font-weight: bold;" id="salesCount">0</h3>
            			<p style="font-weight: bold; font-size:20px;">Today Sale</p>
            		</div>
            		<div class="card-action blue darken-2 center">
            			<a class="white-text" href="salestoday">More<i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l2 m4 s12">
            	<div class="card hoverable">
            		<div class="card-content blue lighten-1 white-text">
            			<h3 style="font-weight: bold;" id="brandsCount">0</h3>
            			<p style="font-weight: bold; font-size:20px;">Brands</p>
            		</div>
            		<div class="card-action blue darken-2 center">
            			<a class="white-text" href="products">More<i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l2 m4 s12">
            	<div class="card hoverable">
            		<div class="card-content blue lighten-1 white-text">
            			<h3 style="font-weight: bold;" id="noticesCount">0</h3>
            			<p style="font-weight: bold; font-size:20px;">Notice</p>
            		</div>
            		<div class="card-action blue darken-2 center">
            			<a class="white-text" href="productsnotice">More<i class="material-icons tiny">open_in_new</i></a>
            		</div>
            	</div>
            </div>
            <div class="col l2 m4 s12">
                  <div class="card hoverable">
                        <div class="card-content blue lighten-1 white-text">
                              <h3 style="font-weight: bold;" id="expiringsCount">0</h3>
                              <p style="font-weight: bold; font-size:20px;">Expiring</p>
                        </div>
                        <div class="card-action blue darken-2 center">
                              <a class="white-text" href="expiringproducts">More<i class="material-icons tiny">open_in_new</i></a>
                        </div>
                  </div>
            </div>
            <div class="col l2 m4 s12">
                  <div class="card hoverable">
                        <div class="card-content blue lighten-1 white-text">
                              <h3 style="font-weight: bold;" id="expiredsCount">0</h3>
                              <p style="font-weight: bold; font-size:20px;">Expired</p>
                        </div>
                        <div class="card-action blue darken-2 center">
                              <a class="white-text" href="expiredproducts">More<i class="material-icons tiny">open_in_new</i></a>
                        </div>
                  </div>
            </div>
        </div>
        <div class="row">
        	<div class="col l6 m6 s12">
        		<div class="card z-depth-0">
        			<canvas id="chatSalesRecordOfDays" width="400" height="400"></canvas>
        		</div>
        	</div>
        	<div class="col l6 m6 s12">
        		<div class="card z-depth-0">
        			<canvas id="chatSalesRecordOfMonths" width="400" height="400"></canvas>
        		</div>
        	</div>
        	<div class="col l6 m6 s12">
        		<div class="card z-depth-0">
        			<canvas id="chartTopProductsRecord" width="400" height="400"></canvas>
        		</div>
        	</div>
            <div class="col l6 m6 s12">
                <div class="card z-depth-0">
                    <canvas id="chartTopProductsRecordYearly" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="col l4 m4 s12">
                <div class="card z-depth-0">
                    <canvas id="chartTopTenSellersMonthly" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="col l4 m4 s12">
                <div class="card z-depth-0">
                    <canvas id="chartTopTenSellersYearly" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="col l4 m4 s12">
                <div class="card z-depth-0">
                    <canvas id="chatSellerSalesRecordOfMonths" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="col l12 m12 s12">
                <div class="card z-depth-0">
                    <img src="src/img/fmo.jpg" class="responsive-img">
                </div>
            </div>
        </div>
    </div>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>