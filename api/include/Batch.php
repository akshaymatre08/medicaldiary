<?php



class Batch extends DbHandler
{

	function isBatchAlreadyExecuted()
	{

	}

    function makeReport()
    {
        $fullReportHTML = null;
        $count = 1;
        $header = $this->getHeader();
        $fullReportHTML .= $header;
        $todaysSaleRecord = $this->getTodaysSalesRecord();
        $priceAllTotalAmount = null;
        $priceAllDiscountAmount = null;
        foreach ($todaysSaleRecord as $rec)
        {
            $productBrand = $rec['productBrand'];
            $productName = $rec['productName'];
            $productSize = $rec['productSize'];
            $productPrice = $rec['productPrice'];
            $saleQuanitty = $rec['saleQuanitty'];
            $productSize = $rec['productSize'];
            $saleDiscount = $rec['saleDiscount'];
            $salePrice = $rec['salePrice'];
            $productSize = $rec['productSize'];
            $productTotalPrice = $rec['productPrice']*$rec['saleQuanitty'];
            $priceAllTotalAmount = $priceAllTotalAmount+$productTotalPrice;
            $priceAllDiscountAmount = $priceAllDiscountAmount+$salePrice;
            $sp = number_format($salePrice);
            $pp = number_format($productPrice);
            $body = <<<HERE
                <tr>
                <td>$count</td>
                <td>$productBrand</td>
                <td class='col-xs-3'>$productName</td>
                <td>$productSize</td>
                <td>$pp</td>
                <td>$saleQuanitty</td>
                <td>$productTotalPrice</td>
                <td>$saleDiscount</td>
                <td>$sp</td>
                </tr>
            HERE;

            $fullReportHTML .=$body;
            $count++;
        }
        $footer = $this->getFooter(number_format($priceAllTotalAmount),number_format($priceAllDiscountAmount));
        $fullReportHTML .=$footer;
        // print_r($fullReportHTML);
        return $fullReportHTML;
    }


    function getHeader()
    {
        $header = <<<HERE
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/b.css" rel="stylesheet">
        </head>
        <body>
        </style>
        <div class="col-md-12">   
        <div class="row">
        <div class="receipt-main" style="padding: 0px !important; margin:0px !important;">
        <div class="row">
        <div class="receipt-header">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <div align="center" class="receipt-center">
        <h5  style="font-size: 50px;">Azmi Unani Store</h5>
        <p style="font-size: 20px;">Daily Sales Report Of 25/13/2012</p>
        </div>
        </div>
        </div>
        </div>
        <div>
        <table class="table table-bordered">
        <thead>
        <tr>
        <th>Sr</th>
        <th>BRANDS</th>
        <th>PRODUCTS</th>
        <th>SIZE</th>
        <th>PRICE</th>
        <th>QUAN</th>
        <th>TOTAL</th>
        <th>DISC</th>
        <th>AMOUNT</th>
        </tr>
        </thead>
        <tbody> 
        HERE;
        return $header;
    }


    function getFooter($priceAllTotalAmount,$priceAllDiscountAmount)
    {

        $footer = <<<HERE
        <tr>
        <td></td>
        <td></td>
        <td class="text-right">
        <h2>
        <strong>Total: </strong>
        </h2>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-left text-danger">
        <h2>
        <strong><i class="fa fa-inr"></i> $priceAllTotalAmount</strong>
        </h2>
        </td>
        <td></td>
        <td class="text-left text-danger">
        <h2>
        <strong><i class="fa fa-inr"></i> $priceAllDiscountAmount</strong>
        </h2>
        </td>
        </tr>
        </tbody>
        </table>
        </div>
        </div>    
        </div>
        </div>
        </script>
        </body>
        </html>
        HERE;
        return $footer;
    }


}



?>