<?php /*
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';

    if (isset($_GET['sid']))
    {
        $sellerId = $_GET['sid'];
    }
    else
        header('LOCATION:invoices.php');

    $api = new API;
    $sellerResponse = $api->getSellerById($sellerId);
    $invoiceResponse = $api->getInvoicesBySellerId($sellerId);
    $allInvoiceAmount = 0;
    $allPaidAmount = 0;
    $allRemainingAmount = 0;
?>
<?php if(!$sellerResponse->error) 
  {
    $seller = $sellerResponse->seller;
  ?>
  
    <div class="socialcodia" >
        <div class="row">
            <div class="col s12 l6 m6">
                 <div class="card lighten-2 dark-text z-depth-0  light-white darken-1" style="min-height: 518px; border: 10px ridge #0288d1;" >
                    <img src="src/img/d_cover.jpg" alt="" class="responsive-img">
                  <div class="card-content center">
                    <img src="<?php echo $seller->sellerImage; ?>" alt="" class="responsive-img circle z-depth-2" style="width: 140px; border: 3px solid white; margin-top: -108px; max-height: 140px; max-width: 140px;">
                        <h5 class="center"><?php echo $seller->sellerName; ?></h5>
                        <div class="divider"></div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Contact</th>
                                    <td class="dark-text"><?php echo $seller->sellerContactNumber; ?></td>
                                </tr>
                                <tr>
                                    <th>Contact 1</th>
                                    <td class="dark-text"><?php echo $seller->sellerContactNumber1; ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td class="dark-text"><?php echo $seller->sellerAddress; ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
              </div>
              <div class="col s12 l6 m6 card z-depth-0" >
                    <canvas id="chartSellerIncome" width="400" height="400"></canvas>
              </div>
            <div class="col l12 s12 m12" style="padding: 30px 10px 30px 10px;">
                    <div id="productList">
                         <div class="card z-depth-0">
                            <table id="mstrTable" class="highlight responsive-table ">
                                <thead>
                                  <tr>
                                      <th>Sr No</th>
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
                                  <tr>
                                    <?php
                                    if (!$invoiceResponse->error)
                                    {
                                        $invoices = $invoiceResponse->invoices;
                                        $count = 1;
                                      foreach ($invoices as $invoice)
                                      {
                                        $allInvoiceAmount += $invoice->invoiceAmount;
                                        $allPaidAmount += $invoice->invoicePaidAmount;
                                        $allRemainingAmount += $invoice->invoiceRemainingAmount;
                                        $color = 'blue';
                                        $invoicePaidAmount = (int) $invoice->invoicePaidAmount;
                                        $invoiceRemainingAmount = (int) $invoice->invoiceRemainingAmount;
                                        if (empty($invoicePaidAmount))
                                            $invoicePaidAmount = 0;
                                        if (empty($invoiceRemainingAmount))
                                          $invoiceRemainingAmount = 0;
                                        if ($invoice->invoiceStatus=='UNPAID')
                                            $color = 'red';
                                        echo "<tr>";
                                        echo "<td>$count</td>";
                                        echo "<td style='font-weight:bold'>$invoice->invoiceNumber</td>";
                                        echo "<td class='blue-text darken-4 chip $color white-text' style='margin-top:25px;'>$invoice->invoiceStatus</td>";
                                        echo "<td>$invoice->invoiceAmount</td>";
                                        echo "<td>$invoicePaidAmount</td>";
                                        echo "<td>$invoiceRemainingAmount</td>";
                                        echo "<td class='blue-text darken-4'>$invoice->invoiceDate</td>";
                                        echo '<td><a href="invoice?inum='.$invoice->invoiceNumber.'" style="border: 1px solid white;border-radius: 50%;" class="btn blue" data-position="top" data-tooltip="View Invoice"><i class="material-icons white-text">remove_red_eye
                                            </i></a>';
                                        echo '<a href="payment?inum='.$invoice->invoiceNumber.'" style="border: 1px solid white;border-radius: 50%;" class="btn red" data-position="top" data-tooltip="Pay Amount"><i class="material-icons white-text">attach_money
                                        </i></a></td>';
                                        $count++;
                                        echo "</tr>";
                                      }
                                    }
                                    ?>
                                  </tr>
                                </tbody>
                            </table>
                         </div>
                         <div class="card z-depth-0 red">
                            <div class="row center">
                                <div class="col s4 l4 m4">
                                    <h5>Total Amount <b><?php echo $allInvoiceAmount; ?> </b></h5>
                                </div>
                                <div class="col s4 l4 m4">
                                    <h5>Paid Amount <b><?php echo $allPaidAmount; ?> </b></h5>
                                </div>
                                <div class="col s4 l4 m4">
                                    <h5>Remainig Amount <b><?php echo $allRemainingAmount; ?> </b></h5>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
        </div>
    </div>
 <?php }
  else
  {
    ?>

    <div class="socialcodia center">
          <h4>No Seller Found</h4>
          <img class="verticalCenter socialcodia" src="src/img/empty_cart.svg">
    </div>

    <?php
  }
  ?>

<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; */?>