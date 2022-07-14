<?php 
require_once dirname(__FILE__).'/include/header.php';
require_once dirname(__FILE__).'/include/api.php';
require_once dirname(__FILE__).'/include/navbar.php';
?>
<div class="socialcodia" style="margin-top: -30px">
  <div class="row">
    <div class="col l12 s12 m12" style="padding: 30px 0px 30px 10px;">
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
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="tableBody">
          </tbody>
        </table>
        <div id="divProcess"></div>
        <div class="row green lighten-4">
          <div class="col l6 m6 s6 center">
            <h5>Total Price = <span class="blue-text" id="totalAmount" style="font-weight: bold"></span></h5>
          </div>
          <div class="col l6 m6 s6 center">
            <h5>Total Sell Price = <span class="blue-text" id="saleAmount" style="font-weight: bold"></span></h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>