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
            <input type="text" name="productName" autocomplete="off" id="productName" placeholder="" onkeyup="filterProduct()">
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
              <th>Image</th>
              <th>Name</th>
              <th>Invoice Number</th>
              <th>Status</th>
              <th>Total Amount</th>
              <th>Paid Amount</th>
              <th>Remaining Amount</th>
              <th>Invoice Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="tableBody">
          </tbody>
        </table>
        <div id="divProcess"></div>
      </div>
    </div>
  </div>
</div>
</div>
<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>