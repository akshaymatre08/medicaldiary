<?php 
require_once dirname(__FILE__).'/include/header.php';
require_once dirname(__FILE__).'/include/api.php';
require_once dirname(__FILE__).'/include/navbar.php';
?>
  <div class="socialcodia" style="margin-top: 0px">
    <div class="row">
      <div class="card z-depth-0 cotainer center">
        <div class="row">
          <div class="col s12 l4 m4">
            <div class="input-field">
              <i class="material-icons prefix">date_range</i>
              <input type="date" name="fromDate" id="fromDate">
              <label for="fromDate">From Date</label>
            </div>
          </div>
          <div class="col s12 l4 m4" >
            <div class="input-field">
              <i class="material-icons prefix">date_range</i>
              <input type="date" name="toDate" id="toDate">
              <label for="fromDate">To Date </label>
            </div>
          </div>
          <div class="col s12 l4 m4" >
            <div class="input-field">
              <input type="submit" style="border-radius:5px;" onclick="fetchProductRecordByDate()" class="btn blue" value="Search" name="btnFetchProduct" id="btnFetchProduct">
            </div>
          </div>
        </div>
      </div>
          <div class="col l12 s12 m12" style="padding: 0px 0px 0px 10px;">
            <div class="card z-depth-0">
              <div class="card-content">
                <div class="input-field">
                  <input type="text" name="productName" id="productName" placeholder="" onkeyup="filterProduct()">
                  <label for="productName">Enter Product Name</label>
                </div>
              </div>
            </div>
            <div id="productList">
             <div class="card z-depth-0">
               <table id="mstrTable" class="highlight responsive-table ">
                <thead>
                  <tr>
                    <th>Sr No</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Discount</th>
                    <th>Sale Price</th>
                    <th>Brand</th>
                    <th>Manufacture</th>
                    <th>Expire</th>
                    <th>Sales Time</th>
                  </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
              </table>
              <div id="divProcess"></div>
              <div class="row green lighten-4" style="padding:0px; margin: 0px;">
                <div class="col l6 m6 s6 center">
                  <h5>Total Price = <span id="totalPrice" class="blue-text" style="font-weight: bold"><?php //echo number_format($totalEndPrice); ?></span></h5>
                </div>
                <div class="col l6 m6 s6 center">
                  <h5>Total Sell Price = <span id="sellPrice" class="blue-text" style="font-weight: bold"><?php // echo number_format($totalEndSellPrice); ?></span></h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
  <?php require_once dirname(__FILE__).'/include/footer.php'; ?>