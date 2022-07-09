<?php

require_once dirname(__FILE__).'/JWT.php';

    $JWT = new JWT;


class DbHandler
{
    private $con;
    private $userId;
    private $saleId;
    private $invoiceNumber;
    private $customerInvoiceNumber;
    private $invoiceId;
    private $creditorId;
    private $customerId;
    private $creditId;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbCon.php';
        $db = new DbCon;
        $this->con =  $db->Connect();
    }

    //Getter Setter For User Id Only

    function setUserId($userId)
    {
        $this->userId = $userId;
    }

    function getUserId()
    {
        return $this->userId;
    }

    function setSaleId($saleId)
    {
        $this->saleId = $saleId;
    }

    function getSaleId()
    {
        return $this->saleId;
    }

    function getCustomerId()
    {
        return $this->customerId;
    }

    function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    function setCustomerInvoiceNumber($customerInvoiceNumber)
    {
        $this->customerInvoiceNumber = $customerInvoiceNumber;
    }

    function getCustomerInvoiceNumber()
    {
        return $this->customerInvoiceNumber;
    }

    function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    function getInvoiceId()
    {
        return $this->invoiceId;
    }

    function getCreditorId()
    {
        return $this->creditorId;
    }

    function setCreditorId($creditorId)
    {
        $this->creditorId = $creditorId;
    }

    function getCreditId()
    {
        return $this->creditId;
    }

    function setCreditId($creditId)
    {
        $this->creditId = $creditId;
    }

    function login($email,$password)
    {
        if($this->isEmailValid($email))
        {
            if($this->isEmailExist($email))
            {
                $hashPass = $this->getPasswordByEmail($email);
                if(password_verify($password,$hashPass))
                {
                    return LOGIN_SUCCESSFULL;
                }
                else
                    return PASSWORD_WRONG;
            }
            else
                return USER_NOT_FOUND;
        }
        else
            return EMAIL_NOT_VALID;
    }

    function sendGCM($title,$body, $to) {

        $url = FIREBASE_URL;

        $data = array(
            'title' => $title,
            'body' =>$body,
            'icon'=>'sales_all'
        );

        $fields = json_encode (array('registration_ids'=>$to,'notification'=>$data ));


        $headers = array (
                'Authorization: key=' .FIREBASE_AUTHORIZATION_KEY,
                'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec( $ch );
        curl_close( $ch );
    }

    function updatePassword($password, $newPassword)
    {
        $tokenId = $this->getUserId();
        $hashPass = $this->getPasswordById($tokenId);
        if(password_verify($password,$hashPass))
        {
            $newHashPassword = password_hash($newPassword,PASSWORD_DEFAULT);
            $query = "UPDATE admin SET password=? WHERE id=?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param('ss',$newHashPassword,$tokenId);
            if($stmt->execute())
                return PASSWORD_CHANGED;
            else
                return PASSWORD_CHANGE_FAILED;
        }
        else
            return PASSWORD_WRONG;  
    }

    function verifyPassword($password)
    {
        $hashPass = $this->getPasswordById($this->getUserId());
        if (password_verify($password,$hashPass))
            return true;
        else
            return false;
    }

    function addProduct($productName,$productBrand,$productCategory,$productSize,$productLocation,$productPrice,$productQuantity,$productManufactureDate,$productExpireDate,$productBarCode)
    {
        $query = "INSERT INTO products (item_id,brand_id,category_id,size_id,location_id,product_price,product_quantity,product_manufacture,product_expire,barCode) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ssssssssss",$productName,$productBrand,$productCategory,$productSize,$productLocation,$productPrice,$productQuantity,$productManufactureDate,$productExpireDate,$productBarCode);
        if ($stmt->execute())
        {
            $this->addProductsRecord($productName,$productBrand,$productCategory,$productSize,$productLocation,$productPrice,$productQuantity,$productManufactureDate,$productExpireDate);
            return true;
        }
        else
            return false;
    }

    function updateProduct($productId,$productName,$productBrand,$productCategory,$productSize,$productLocation,$productPrice,$productQuantity,$productManufactureDate,$productExpireDate,$barCode)
    {
        $productQuantity = $productQuantity + $this->getSalesCountByProductId($productId)+$this->getSellerSalesCountByProductId($productId);
        $query = "UPDATE products SET item_id=?, brand_id=?, category_id=?, size_id=?, location_id=?, product_price=?, product_quantity=?, product_manufacture=?, product_expire=?, barCode=? WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("sssssssssss",$productName,$productBrand,$productCategory,$productSize,$productLocation,$productPrice,$productQuantity,$productManufactureDate,$productExpireDate,$barCode,$productId);
        if ($stmt->execute())
        {
            // $this->addProductsRecord($productName,$productBrand,$productCategory,$productSize,$productLocation,$productPrice,$productQuantity,$productManufactureDate,$productExpireDate);
            return true;
        }
        else
            return false;
    }

    function addSeller($sellerName,$sellerEmail,$sellerContactNumber,$sellerContactNumber1,$sellerImage,$sellerAddress)
    {
        if (!empty($sellerImage))
            $sellerImage = $this->uploadImage($sellerImage);
        else
            $sellerImage = '';
        $query = "INSERT INTO sellers (sellerName,sellerEmail,sellerContact,sellerContact1,sellerImage,sellerAddress) VALUES(?,?,?,?,?,?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ssssss",$sellerName,$sellerEmail,$sellerContactNumber,$sellerContactNumber1,$sellerImage,$sellerAddress);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function addAdmin($adminName,$adminEmail,$adminPassword,$adminPosition,$adminImage)
    {
        if (!empty($adminImage))
            $adminImage = $this->uploadImage($adminImage);
        else
            $adminImage = '';
        $hashPass = password_hash($adminPassword, PASSWORD_DEFAULT);
        $query = "INSERT INTO admin (name,email,password,position,image) VALUES(?,?,?,?,?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("sssss",$adminName,$adminEmail,$hashPass,$adminPosition,$adminImage);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function updateAdmin($adminId,$adminName,$adminEmail,$adminPassword,$adminPosition,$adminImage)
    {
        $admin = $this->getAdminById($adminId);
        if (!empty($adminImage))
            $adminImage = $this->uploadImage($adminImage);
        else
            $adminImage = $admin['adminImage'];
        if(empty($adminPassword))
            $adminPassword = $admin['adminPassword'];
        else
            $adminPassword = password_hash($adminPassword, PASSWORD_DEFAULT);
        $query = "UPDATE admin SET name=?, email=? , password=? , position=? , image=? WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("sssss",$adminName,$adminEmail,$hashPass,$adminPosition,$adminImage,$adminId);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function updateAdminSelf($adminId,$adminName,$adminImage)
    {
        if (!empty($adminImage))
            $adminImage = $this->uploadImage($adminImage);
        else
            $adminImage = $this->getAdminById($adminId)['adminImage'];
        $hashPass = password_hash($adminPassword, PASSWORD_DEFAULT);
        $query = "UPDATE admin SET name=? image=? WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("sss",$adminName,$adminImage,$adminId);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function getSalesStatusOfEveryMonth()
    {
        $rec = array();
        $record = array();
        // $query = "select date_format(created_at,'%M'),sum(sell_price) from sells group by year(created_at),month(created_at) order by year(created_at),month(created_at)";
        $query = "select date_format(created_at,'%M'),sum(sell_price) from sells group by date_format(created_at,'%M'),year(created_at),month(created_at) ORDER BY year(created_at),month(created_at)";
        $stmt = $this->con->prepare($query);
        $stmt->execute();  
        $stmt->bind_result($month,$sellPrice);
        while($stmt->fetch())
        {
            $rec['month']= $month;
            $rec['totalSales'] = $sellPrice;
            array_push($record, $rec);
        }
        return $record;
    }


    function getSellerSalesStatusOfEveryMonthBySellerId($sellerId)
    {
        $rec = array();
        $record = array();
        $query = "select date_format(created_at,'%M'),sum(sell_price) from sellers_sells WHERE seller_id=? group by date_format(created_at,'%M'),year(created_at),month(created_at) ORDER BY year(created_at),month(created_at)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$sellerId);
        $stmt->execute();  
        $stmt->bind_result($month,$sellPrice);
        while($stmt->fetch())
        {
            $rec['month']= $month;
            $rec['totalSales'] = $sellPrice;
            array_push($record, $rec);
        }
        return $record;
    }

    function getSellerSalesStatusOfEveryMonth()
    {
        $rec = array();
        $record = array();
        // $query = "select date_format(created_at,'%M'),sum(sell_price) from sellers_sells group by year(created_at),month(created_at) order by year(created_at),month(created_at)";
        $query = "select date_format(created_at,'%M'),sum(sell_price) from sellers_sells group by date_format(created_at,'%M'), year(created_at),month(created_at) order by year(created_at),month(created_at)";
        $stmt = $this->con->prepare($query);
        $stmt->execute();  
        $stmt->bind_result($month,$sellPrice);
        while($stmt->fetch())
        {
            $rec['month']= $month;
            $rec['totalSales'] = $sellPrice;
            array_push($record, $rec);
        }
        return $record;
    }

    function getSalesStatusOfEveryDay()
    {
        $rec = array();
        $record = array();
        // $query = "select date_format(created_at,'%d'),sum(sell_price) from sells WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) group by week(created_at),day(created_at) order by month(created_at),day(created_at) ASC";
        $query = "select date_format(created_at,'%d'),sum(sell_price) from sells WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) group by date_format(created_at,'%d'), week(created_at),day(created_at)";
        $stmt = $this->con->prepare($query);
        $stmt->execute();  
        $stmt->bind_result($day,$sellPrice);
        while($stmt->fetch())
        {
            $rec['day']= $day;
            $rec['totalSales'] = $sellPrice;
            array_push($record, $rec);
        }
        return $record;
    }

    // Old Script Which Is Not Working On Server. Removing Rank From The Query
    // function getTopTenMostSalesProduct()
    // {
    //     $rec = array();
    //     $record = array();
    //     $products = array();
    //     $query = "SELECT product_id, SUM(sell_quantity), ROW_NUMBER() OVER (order by sum(sell_quantity) DESC) FROM sells WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY product_id order by SUM(sell_quantity) DESC LIMIT 10";
    //     $stmt = $this->con->prepare($query);
    //     $stmt->execute();  
    //     $stmt->bind_result($productId,$saleQuantity,$rank);
    //     while($stmt->fetch())
    //     {
    //         $rec['productId']= $productId;
    //         $rec['saleQuantity'] = $saleQuantity;
    //         $rec['rank'] = $rank;
    //         array_push($record, $rec);
    //     }
    //     foreach ($record as $rec) 
    //     {
    //         $pro = $this->getProductById($rec['productId']);
    //         $pro['saleQuantity'] = $rec['saleQuantity'];
    //         array_push($products, $pro);
    //     }
    //     return $products;
    // }
    
    function getTopTenMostSalesProduct()
    {
        $rec = array();
        $record = array();
        $products = array();
        $query = "SELECT product_id, SUM(sell_quantity) FROM sells WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY product_id order by SUM(sell_quantity) DESC LIMIT 10";
        $stmt = $this->con->prepare($query);
        $stmt->execute();  
        $stmt->bind_result($productId,$saleQuantity);
        while($stmt->fetch())
        {
            $rec['productId']= $productId;
            $rec['saleQuantity'] = $saleQuantity;
            array_push($record, $rec);
        }
        foreach ($record as $rec) 
        {
            $pro = $this->getProductById($rec['productId']);
            $pro['saleQuantity'] = $rec['saleQuantity'];
            array_push($products, $pro);
        }
        return $products;
    }

    function getTopTenMostSalesProductOfYear()
    {
        $rec = array();
        $record = array();
        $products = array();
        $query = "SELECT product_id, SUM(sell_quantity) FROM sells GROUP BY product_id ORDER BY SUM(sell_quantity) DESC LIMIT 10";
        $stmt = $this->con->prepare($query);
        $stmt->execute();  
        $stmt->bind_result($productId,$saleQuantity);
        while($stmt->fetch())
        {
            $rec['productId']= $productId;
            $rec['saleQuantity'] = $saleQuantity;
            array_push($record, $rec);
        }
        foreach ($record as $rec) 
        {
            $pro = $this->getProductById($rec['productId']);
            $pro['saleQuantity'] = $rec['saleQuantity'];
            array_push($products, $pro);
        }
        return $products;
    }

    // Old Script which is not working on server
    // function getTopTenMostSalesProductOfEveryMonth()
    // {
    //     $rec = array();
    //     $record = array();
    //     $products = array();
    //     $query = "SELECT product_id, SUM(sell_quantity), ROW_NUMBER() OVER (order by sum(sell_quantity) DESC) FROM sells WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY product_id order by SUM(sell_quantity) DESC LIMIT 10";
    //     $stmt = $this->con->prepare($query);
    //     $stmt->execute();  
    //     $stmt->bind_result($productId,$saleQuantity,$rank);
    //     while($stmt->fetch())
    //     {
    //         $rec['productId']= $productId;
    //         $rec['saleQuantity'] = $saleQuantity;
    //         $rec['rank'] = $rank;
    //         array_push($record, $rec);
    //     }
    //     foreach ($record as $rec) 
    //     {
    //         $pro = $this->getProductById($rec['productId']);
    //         $pro['saleQuantity'] = $rec['saleQuantity'];
    //         array_push($products, $pro);
    //     }
    //     return $products;
    // }
    
    function getTopTenMostSalesProductOfEveryMonth()
    {
        $rec = array();
        $record = array();
        $products = array();
        // $query = "SELECT product_id, SUM(sell_quantity), ROW_NUMBER() OVER (order by sum(sell_quantity) DESC) FROM sells WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY product_id order by SUM(sell_quantity) DESC LIMIT 10";
        $query = "SELECT product_id, SUM(sell_quantity) FROM sells WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY product_id order by SUM(sell_quantity) DESC LIMIT 10";
        $stmt = $this->con->prepare($query);
        $stmt->execute();  
        $stmt->bind_result($productId,$saleQuantity);
        while($stmt->fetch())
        {
            $rec['productId']= $productId;
            $rec['saleQuantity'] = $saleQuantity;
            array_push($record, $rec);
        }
        foreach ($record as $rec) 
        {
            $pro = $this->getProductById($rec['productId']);
            $pro['saleQuantity'] = $rec['saleQuantity'];
            array_push($products, $pro);
        }
        return $products;
    }

    function getMonthName($monthNumber)
    {
        switch ($monthNumber) {
            case '01':
                return 'January';
                break;
            case '02':
                return 'February';
                break;  
            case '03':
                return 'March';
                break;
            case '04':
                return 'April';
                break;
            case '05':
                return 'May';
                break;
            case '06':
                return 'June';
                break;
            case '07':
                return 'July';
                break;
            case '08':
                return 'August';
                break;
            case '09':
                return 'September';
                break;
            case '10':
                return 'October';
                break;
            case '11':
                return 'November';
                break;
            case '12':
                return 'December';
                break;
            
            default:
                # code...
                break;
        }
    }

    function getSellers()
    {
        $sellers = array();
        $query = "SELECT sellerId,sellerName,sellerEmail,sellerContact,sellerContact1,sellerImage,sellerAddress from sellers ORDER BY sellerId ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sellerId,$sellerName,$sellerEmail,$sellerContactNumber,$sellerContactNumber1,$sellerImage,$sellerAddress);
        while ($stmt->fetch())
        {
            $seller['sellerId'] = $sellerId;
            $seller['sellerName'] = $sellerName;
            $seller['sellerEmail'] = $sellerEmail;
            $seller['sellerContactNumber'] = $sellerContactNumber;
            $seller['sellerContactNumber1'] = $sellerContactNumber1;
            if (isset($sellerImage) && !empty($sellerImage))
                $seller['sellerImage'] = WEBSITE_DOMAIN.$sellerImage;
            else
                $seller['sellerImage'] = null;
            $seller['sellerAddress'] = $sellerAddress;
            array_push($sellers, $seller);
        }
        return $sellers;
    }

    function getAdmins()
    {
        $admins = array();
        $query = "SELECT id,name,email,image,position from admin ORDER BY position ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($adminId,$adminName,$adminEmail,$adminImage,$adminPosition);
        while ($stmt->fetch())
        {
            $admin['adminId'] = $adminId;
            $admin['adminName'] = $adminName;
            $admin['adminEmail'] = $adminEmail;
            $admin['adminImage'] = $adminImage;
            $admin['adminPosition'] = ADMIN_POSITIONS_NAME[$adminPosition-1];
            if (isset($adminImage) && !empty($adminImage))
                $admin['adminImage'] = WEBSITE_DOMAIN.$adminImage;
            else
                $admin['adminImage'] = null;
            array_push($admins, $admin);
        }
        return $admins;
    }

    function getSellerById($sellerId)
    {
        $sellers = array();
        $query = "SELECT sellerId,sellerName,sellerEmail,sellerContact,sellerContact1,sellerImage,sellerAddress from sellers WHERE sellerId=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$sellerId);
        $stmt->execute();
        $stmt->bind_result($sellerId,$sellerName,$sellerEmail,$sellerContactNumber,$sellerContactNumber1,$sellerImage,$sellerAddress);
        $stmt->fetch();
        $seller['sellerId'] = $sellerId;
        $seller['sellerName'] = $sellerName;
        $seller['sellerEmail'] = $sellerEmail;
        $seller['sellerContactNumber'] = $sellerContactNumber;
        $seller['sellerContactNumber1'] = $sellerContactNumber1;
        if (isset($sellerImage) && !empty($sellerImage))
            $seller['sellerImage'] = WEBSITE_DOMAIN.$sellerImage;
        else
            $seller['sellerImage'] = WEBSITE_DOMAIN.'uploads/api/user.png';
        $seller['sellerAddress'] = $sellerAddress;
        // array_push($sellers, $seller);
        return $seller;
    }

    function isSellerExist($sellerId)
    {
        $sellers = array();
        $query = "SELECT sellerId FROM sellers WHERE sellerId=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$sellerId);
        $stmt->execute();
        $stmt->bind_result($sId);
        $stmt->fetch();
        if (!empty($sId))
            return true;
        else
            return false;
    }

    function isInvoiceExist($invoiceNumber)
    {
        $sellers = array();
        $query = "SELECT invoice_id FROM invoices WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($iId);
        $stmt->fetch();
        if (!empty($iId))
            return true;
        else
            return false;
    }

    function getInvoiceUrlByInvoiceNumber($invoiceNumber)
    {
        $sellers = array();
        $query = "SELECT invoice_url FROM invoices WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($invoiceUrl);
        $stmt->fetch();
        return $invoiceUrl;
    }

    function uploadImage($image)
    {
        $imageUrl ="";
        if ($image!=null) 
        {
            $imageName = $image->getClientFilename();
            $image = $image->file;
            $targetDir = "uploads/";
            $targetFile = $targetDir.uniqid().'.'.pathinfo($imageName,PATHINFO_EXTENSION);
            if (move_uploaded_file($image,$targetFile))
                $imageUrl = $targetFile;
        }
        return $imageUrl;
    }

    function addProductsRecord($productName,$productBrand,$productCategory,$productSize,$productLocation,$productPrice,$productQuantity,$productManufactureDate,$productExpireDate)
    {
        $query = "INSERT INTO products_record (item_id,brand_id,category_id,size_id,location_id,product_price,product_quantity,product_manufacture,product_expire) VALUES(?,?,?,?,?,?,?,?,?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("sssssssss",$productName,$productBrand,$productCategory,$productSize,$productLocation,$productPrice,$productQuantity,$productManufactureDate,$productExpireDate);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function getMonthlyIncomeOfSellerById($sellerId)
    {
        $data = array();
        $ddd = array();
        $query = "SELECT date_format(created_at,'%M'), product_id,sell_discount,SUM(sell_quantity) FROM sellers_sells WHERE seller_id=? AND YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY date_format(created_at,'%M'),seller_id,product_id ORDER BY created_at";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$sellerId);
        $stmt->execute();
        $stmt->bind_result($monthName,$productId,$sellDiscount,$saleQuantity);
        while ($stmt->fetch())
        {
            $d['monthName'] = $monthName;
            $d['productId'] = $productId;
            $d['sellDiscount'] = $sellDiscount;
            $d['saleQuantity'] = $saleQuantity;
            array_push($data, $d);
        }
        $stmt->close();
        $netProfit = 0;
        $maxProfit = 0;
        foreach ($data as $dt)
        {
            $product = $this->getProductById($dt['productId']);
            $product['productPrice'] = ($product['productPrice']/100)*$dt['sellDiscount'];
            if ($product['productName']==='FAROOQUI MASSAGE OIL' && $product['productBrand']==='FHC' && $product['productSize']==='50ML')
            {
                $maxPrice = $product['productPrice']*$dt['saleQuantity'];
                $price = ($product['productPrice']-10)*$dt['saleQuantity'];
            }
            if ($product['productName']==='LASANI CHOORAN' && $product['productBrand']==='FHC' && $product['productSize']==='100GM')
            {
                $maxPrice = $product['productPrice']*$dt['saleQuantity'];
                $price = ($product['productPrice']-10)*$dt['saleQuantity'];
            }
            else if ($product['productName']==='FAROOQUI MASSAGE OIL' && $product['productBrand']==='FHC' && $product['productSize']==='100ML')
            {
                $maxPrice = $product['productPrice']*$dt['saleQuantity'];
                $price = ($product['productPrice']-15)*$dt['saleQuantity'];
            }
            else if ($product['productName']==='FAROOQUI MASSAGE OIL' && $product['productBrand']==='FHC' && $product['productSize']==='200ML')
            {
                $maxPrice = $product['productPrice']*$dt['saleQuantity'];
                $price = ($product['productPrice']-30)*$dt['saleQuantity'];
            }
            // $netProfit = $netProfit+$price;
            // $maxProfit = $maxProfit+$maxPrice;
            $monthName = $dt['monthName'];

            if (!isset($ddd[$monthName])) {
                $ddd[$monthName] = [
                    'monthName' => $monthName, 
                    'netProfit' => 0,
                    'maxProfit' => 0,
                ];
            }

            $ddd[$monthName]['netProfit'] += $price;
            $ddd[$monthName]['maxProfit'] += $maxPrice;
        }
        return array_values($ddd);
    }

    function addBrand($brandName)
    {
        $query = "INSERT INTO brands (brand_name) VALUES(?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$brandName);
        return ($stmt->execute()) ? true : false;
    }

    function addItem($itemName,$itemDescription)
    {
        $query = "INSERT INTO items (itemName,itemDescription) VALUES(?,?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ss",$itemName,$itemDescription);
        return ($stmt->execute()) ? true : false;
    }

        /*
                Working on it.

                Logic : First fetch the product notice count from database server and then perform the logic and return the data.

                Means : Instead of hard coding , store the notice count value into database server. fetch that value, and perform the
                logic.
        */
    function getProductNoticeCount()
    {
        $query = "SELECT productNoticeCount FROM settings";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productNoticeCount);
        $stmt->fetch();
        return $productNoticeCount;
    }

    function updateProductNoticeCount($productNoticeCount)
    {
        $query = "UPDATE settings SET productNoticeCount =?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productNoticeCount);
        return ($stmt->execute()) ? true : false;
    }

    function getNewCustomerInvoiceNumber()
    {
        $query = "SELECT invoiceNumber from customerinvoices ORDER BY invoiceId DESC LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($invoiceNumber);
        $stmt->fetch();
        if (empty($invoiceNumber))
            $invoiceNumber = CUSTOMER_INVOICE_SHORT_NAME."10000";
        $companyTag = substr($invoiceNumber,0, strlen(CUSTOMER_INVOICE_SHORT_NAME));
        $invoiceNumber = (int) substr($invoiceNumber,strlen(CUSTOMER_INVOICE_SHORT_NAME), 10)+1;
        $invoiceNumber = $companyTag.$invoiceNumber;
        return $invoiceNumber;
    }

    function getNewInvoiceNumber()
    {
        $query = "SELECT invoice_number from invoices ORDER BY invoice_id DESC LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($invoiceNumber);
        $stmt->fetch();
        if (empty($invoiceNumber))
            $invoiceNumber = COMPANY_SHORT_NAME."10000";
        $companyTag = substr($invoiceNumber,0, strlen(COMPANY_SHORT_NAME));
        $invoiceNumber = (int) substr($invoiceNumber,strlen(COMPANY_SHORT_NAME), 10)+1;
        $invoiceNumber = $companyTag.$invoiceNumber;
        return $invoiceNumber;
    }

    function addPayment($sellerId,$invoiceNumber,$paymentAmount)
    {
        $tokenId = $this->getUserId();
        date_default_timezone_set('Asia/Kolkata');
        $paymentMode = 'CASH';
        $date = date('y/m/d H:i:s', time());
        $query = "INSERT INTO payments (payment_mode,payment_date,payment_amount,payment_receiver,invoice_number,seller_id) VALUES(?,?,?,?,?,?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ssssss",$paymentMode,$date,$paymentAmount,$tokenId,$invoiceNumber,$sellerId);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function addCreditsPayment($creditId,$paymentAmount)
    {
        $creditorId = $this->getCreditorIdByCreditId($creditId);
        $tokenId = $this->getUserId();
        date_default_timezone_set('Asia/Kolkata');
        $paymentMode = 'CASH';
        $date = date('y/m/d H:i:s', time());
        $query = "INSERT INTO creditPayments (paymentMode,paymentDate,paymentAmount,paymentReciever,creditId,creditorId) VALUES(?,?,?,?,?,?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ssssss",$paymentMode,$date,$paymentAmount,$tokenId,$creditId,$creditorId);
        return ($stmt->execute()) ? true : false;
    }

    function isPaymentAmountLessThanInvoiceAmount($invoiceNumber,$paymentAmount)
    {
        $invoiceAmount = (int) $this->getTotalAmountByInvoiceNumber($invoiceNumber);
        $paymentAmount = (int) $paymentAmount;
        $paidAmount = (int) $this->getAllPaidAmountByInvoiceNumber($invoiceNumber);
        return ($invoiceAmount-$paidAmount-$paymentAmount>=0) ? true : false;
    }

    function isPaymentAmountLessThanCreditAmount($creditId,$paymentAmount)
    {
        $invoiceAmount = (int) $this->getTotalAmountByCreditId($creditId);
        $paymentAmount = (int) $paymentAmount;
        $paidAmount = (int) $this->getAllPaidAmountByCreditId($creditId);
        return ($invoiceAmount-$paidAmount-$paymentAmount>=0) ? true : false;
    }

    function getAllPaidAmountByInvoiceNumber($invoiceNumber)
    {
        $query = "SELECT SUM(payment_amount) FROM payments WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($totalAmount);
        $stmt->fetch();
        return $totalAmount;
    }

    function getTotalAmountByInvoiceNumber($invoiceNumber)
    {
        $query = "SELECT SUM(sell_price) FROM sellers_sells WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($totalAmount);
        $stmt->fetch();
        return $totalAmount;
    }

    function getTotalAmountByCreditId($creditId)
    {
        $salesId = $this->getSalesIdByCreditId($creditId);
        $salesId = implode(",",$salesId);
        $query = "SELECT SUM(sell_price) FROM sells WHERE sell_id IN ($salesId)";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($totalAmount);
        $stmt->fetch();
        return $totalAmount;
    }

    function getSalesIdByCreditId($creditId)
    {
        $query = "SELECT salesId FROM credits WHERE creditId=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$creditId);
        $stmt->execute();
        $stmt->bind_result($salesId);
        $stmt->fetch();
        return json_decode($salesId);
    }

    function getRemainingAmountByCreditId($creditId)
    {
        $totalAmount = $this->getTotalAmountByCreditId($creditId);
        $paidAmount = $this->getAllPaidAmountByCreditId($creditId);
        return $totalAmount-$paidAmount;
    }

    function getCreditStatusById($creditId)
    {
        $totalAmount = $this->getTotalAmountByCreditId($creditId);
        $paidAmount = $this->getAllPaidAmountByCreditId($creditId);
        return ($totalAmount-$paidAmount==0) ? 'PAID' : 'UNPAID';
    }

    //CAFUSION : This function is not completed yet, We are not using this funtion to anywhere
    function getTotalOrignalAmountByInvoiceNumber($invoiceNumber)
    {
        $productIds = $this->getAllProductIdAndsaleQuantityByInvoiceNumber($invoiceNumber);
        $query = "SELECT SUM(sell_price) FROM sellers_sells WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($totalAmount);
        $stmt->fetch();
        return $productIds;
    }

    function getCurrentAmountOfInvoiceByInvoiceNumber($invoiceNumber)
    {
        $paidAmount = (int) $this->getAllPaidAmountByInvoiceNumber($invoiceNumber);
        $invoiceAmount = (int) $this->getTotalAmountByInvoiceNumber($invoiceNumber);
        return $invoiceAmount-$paidAmount;
    }

    function addCustomerInvoice($customerId,$invoiceNumber,$invoiceUrl)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('y/m/d', time());
        $query = "INSERT INTO customerinvoices (invoiceNumber,invoiceUrl,customerId,invoiceDate) VALUES(?,?,?,?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ssss",$invoiceNumber,$invoiceUrl,$customerId,$date);
        if ($stmt->execute())
        {
            return true;
        }
        else
            return false;
    }

    function addInvoice($sellerId)
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = date('y/m/d', time());
        $invoiceNumber = $this->getNewInvoiceNumber();
        $query = "INSERT INTO invoices (invoice_number,seller_id,invoice_date) VALUES(?,?,?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("sss",$invoiceNumber,$sellerId,$date);
        if ($stmt->execute())
        {
            $this->setInvoiceNumber($invoiceNumber);
            return true;
        }
        else
            return false;
    }

    function deleteInvoice($invoiceNumber)
    {
        $query = "DELETE FROM invoices WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$invoiceNumber);
        if ($stmt->execute())
        {
            if ($this->deleteAllSellerSalesByInvoiceNumber($invoiceNumber)) 
                return true;
        }
        else
            return false;
    }

    function deleteAllSellerSalesByInvoiceNumber($invoiceNumber)
    {
        $query = "DELETE FROM sellers_sells WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$invoiceNumber);
        return ($stmt->execute()) ? true : false;
    }

    function sellProduct($productId)
    {
        if ($this->isProductAvailable($productId))
        {
            $productPrice = $this->getProductPriceById($productId);
            $productQuantity = 1;
            $query = "INSERT INTO sells (product_id,sell_quantity,sell_price) VALUES(?,?,?)";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("sss",$productId,$productQuantity,$productPrice);
            if ($stmt->execute())
            {
                $this->setSaleId($stmt->insert_id);
                return SELL_PRODUCT;
            }
            else
                return SELL_PRODUCT_FAILED;
        }
        else
            return PRODUCT_QUANTITY_LOW;
    }

    function addCustomer($customerName,$customerMobile,$customerAddress)
    {
        $query = "INSERT INTO customers (customerName,customerMobile,customerAddress) VALUES(?,?,?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("sss",$customerName,$customerMobile,$customerAddress);
        if ($stmt->execute())
        {
            $this->setCustomerId($stmt->insert_id);
            return true;
        }
        else
            return false;
    }

    function addCreditor($customerName,$customerMobile,$customerAddress)
    {
        if (!$this->isCreditorExistByMobile($creditorMobile))
        {
            $query = "INSERT INTO creditors (creditorName,creditorMobile,creditorAddress) VALUES(?,?,?)";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("sss",$creditorName,$creditorMobile,$creditorAddress);
            if ($stmt->execute())
            {
                $this->setCreditorId($stmt->insert_id);
                return true;
            }
            else
                return false;
        }
        else
            return true;
    }

    function addCreditRecord($creditorName,$creditorMobile,$creditorAddress,$creditDescription,$paidAmount,$salesId)
    {
        $error = false;
        foreach ($salesId as $sId)
        {
            if ($this->isSaleExist($sId))
                $error = false;
            else
                $error = true;
        }
        if (empty($creditDescription))
            $creditDescription = '';

        if (empty($paidAmount))
            $paidAmount = 0;

        if (!$error)
        {
            $salesId = json_encode($salesId);
            $salesIds = json_decode($salesId,true);
            if ($this->addCreditor($creditorName,$creditorMobile,$creditorAddress))
            {
                date_default_timezone_set('Asia/Kolkata');
                $date = new DateTime();
                $creditTime = $date->format('Y-m-d H:i:s');
                if ($this->getCreditorId()!=null)
                    $creditorId = $this->getCreditorId();
                else
                    $creditorId = $this->getCreditorIdByMobileNumber($creditorMobile);
                $query = "INSERT INTO credits (creditorId,salesId,creditDescription,creditTime) VALUES (?,?,?,?)";
                $stmt = $this->con->prepare($query);
                $stmt->bind_param('ssss',$creditorId,$salesId,$creditDescription,$creditTime);
                if ($stmt->execute())
                {
                    $this->setCreditId($stmt->insert_id);
                    if ($paidAmount>0) 
                    {
                        $creditorId = $this->getCreditorIdByMobileNumber($creditorMobile);
                        $creditId = $this->getCreditId();
                        return ($this->addCreditsPayment($creditId,$paidAmount)) ? true : false;
                    }
                    else
                        return true;
                }
                else
                    return false;
            }
        }
    }

    function getCredits()
    {
        $credits = array();
        $creditss = array();
        $products = array();
        $query = "SELECT creditId,creditorId,creditDescription,salesId,creditTime FROM credits";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($creditId,$creditorId,$creditDescription,$salesId,$creditTime);
        while ($stmt->fetch())
        {
          $credit['creditId'] = $creditId;
          $credit['creditorId'] = $creditorId;
          $credit['creditDescription'] = $creditDescription;
          $credit['salesId'] = json_decode($salesId);
          $credit['creditTime'] = $creditTime;
          array_push($credits, $credit);
        }
        $stmt->close();
        foreach($credits as $credit)
        {
            $crdt['creditId'] = $credit['creditId'];
            $crdt['creditTotalAmount'] = $this->getTotalAmountByCreditId($crdt['creditId']);
            $crdt['creditPaidAmount'] = $this->getAllPaidAmountByCreditId($crdt['creditId']);
            $crdt['creditRemainingAmount'] = $this->getRemainingAmountByCreditId($crdt['creditId']);
            $crdt['creditStatus'] = $this->getCreditStatusById($crdt['creditId']);
            $crdt['creditDescription'] = $credit['creditDescription'];
            foreach ($credit['salesId'] as $id) {
                $product= $this->getProductBySlaeId($id);   //not returing the product info, then rmv it.
                array_push($products, $product);
            }
            $crdt['creditor'] = $this->getCreditorById($credit['creditorId']);
            // $crdt['product'] = $products;
            $crdt['creditDate'] = $credit['creditTime'];
            $products = [];
            array_push($creditss, $crdt);
        }
        return $creditss;
    }

    function getCreditById($creditId)
    {
        $credits = array();
        $creditss = array();
        $products = array();
        $query = "SELECT creditId,creditorId,creditDescription,salesId,creditTime FROM credits WHERE creditId = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$creditId);
        $stmt->execute();
        $stmt->bind_result($creditId,$creditorId,$creditDescription,$salesId,$creditTime);
        $stmt->fetch();
        $credits['creditId'] = $creditId;
        $credits['creditorId'] = $creditorId;
        $credits['creditDescription'] = $creditDescription;
        $credits['salesId'] = json_decode($salesId);
        $credits['creditTime'] = $creditTime;
        $stmt->close();
        $crdt['creditId'] = $credits['creditId'];
        $crdt['creditTotalAmount'] = $this->getTotalAmountByCreditId($credits['creditId']);
        $crdt['creditPaidAmount'] = $this->getAllPaidAmountByCreditId($credits['creditId']);
        $crdt['creditRemainingAmount'] = $this->getRemainingAmountByCreditId($credits['creditId']);
        $crdt['creditStatus'] = $this->getCreditStatusById($credits['creditId']);
        $crdt['creditDescription'] = $credits['creditDescription'];
        foreach ($credits['salesId'] as $id) {
            $product= $this->getSaleInfoBySaleId($id);
            array_push($products, $product);
        }
        $crdt['creditor'] = $this->getCreditorById($credits['creditorId']);
        $crdt['sales'] = $products;
        $crdt['creditDate'] = $credits['creditTime'];
        return $crdt;
    }

    function getAllPaidAmountByCreditId($creditId)
    {
        $query = "SELECT SUM(paymentAmount) FROM creditpayments WHERE creditId=?";
        $stmt =  $this->con->prepare($query);
        $stmt->bind_param('s',$creditId);
        $stmt->execute();
        $stmt->bind_result($paymentAmount);
        $stmt->fetch();
        return ($paymentAmount<1) ? 0 : $paymentAmount;
    }

    function getCreditorById($creditorId)
    {
        $query = "SELECT creditorId,creditorName,creditorMobile,creditorAddress from creditors WHERE creditorId=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$creditorId);
        $stmt->execute();
        $stmt->bind_result($creditorId,$creditorName,$creditorMobile,$creditorAddress);
        $stmt->fetch();
        $creditor['creditorId'] = $creditorId;
        $creditor['creditorName'] = $creditorName;
        $creditor['creditorMobile'] = $creditorMobile;
        $creditor['creditorAddress'] = $creditorAddress;
        return $creditor;
    }

    function isCreditorExistByMobile($mobileNumber)
    {
        $query = "SELECT creditorId from creditors WHERE creditorMobile=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$mobileNumber);
        $stmt->execute();
        $stmt->bind_result($creditorId);
        $stmt->store_result();
        $stmt->fetch();
        if ($stmt->num_rows()>0)
        {
            $this->setCreditorId($creditorId);
            return true;
        }
        else
            return false;
    }

    function sellProductToSeller($productId,$invoiceNumber)
    {
        if ($this->isProductAvailable($productId))
        {
            $sellerId =$this->getSellerIdByInvoiceNumber($invoiceNumber);
            $productPrice = $this->getProductPriceById($productId);
            $productQuantity = 1;
            $query = "INSERT INTO sellers_sells (invoice_number,seller_id,product_id,sell_quantity,sell_price) VALUES(?,?,?,?,?)";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("sssss",$invoiceNumber,$sellerId,$productId,$productQuantity,$productPrice);
            if ($stmt->execute())
            {
                $this->setSaleId($stmt->insert_id);
                return SELL_PRODUCT;
            }
            else
                return SELL_PRODUCT_FAILED;
        }
        else
            return PRODUCT_QUANTITY_LOW;
    }

    function getTopTenSellerOfThisMonth()
    {
        $sellers = array();
        $sellerss = array();
        $query = "SELECT SUM(sell_price), seller_id FROM sellers_sells WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) GROUP BY seller_id ORDER BY SUM(sell_price) DESC";   
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sellPrice,$sellerId);
        while($stmt->fetch())
        {
            $data['sellPrice'] = $sellPrice;
            $data['sellerId'] = $sellerId;
            array_push($sellers, $data);
        }
        $stmt->close();
        foreach ($sellers as $seller) 
        {
            $sel = $this->getSellerById($seller['sellerId']);
            $sel['sales'] = $seller['sellPrice'];
            array_push($sellerss, $sel);
        }
        return $sellerss;
    }

    function getTopTenSellerOfThisYear()
    {
        $sellers = array();
        $sellerss = array();
        $query = "SELECT SUM(sell_price), seller_id FROM sellers_sells WHERE YEAR(created_at) = YEAR(CURRENT_DATE()) GROUP BY seller_id ORDER BY SUM(sell_price) DESC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sellPrice,$sellerId);
        while($stmt->fetch())
        {
            $data['sellPrice'] = $sellPrice;
            $data['sellerId'] = $sellerId;
            array_push($sellers, $data);
        }
        $stmt->close();
        foreach ($sellers as $seller) 
        {
            $sel = $this->getSellerById($seller['sellerId']);
            $sel['sales'] = $seller['sellPrice'];
            array_push($sellerss, $sel);
        }
        return $sellerss;
    }

    function isProductAvailable($productId)
    {
        $productQuantity = $this->getProductQuantityById($productId);
        $salesQuantity = $this->getAllSalesQuantityOfProudctById($productId);
        $sellerSalesQuantity = $this->getAllSellerSalesQuantityOfProudctById($productId);
        if ($productQuantity-$salesQuantity-$sellerSalesQuantity>0)
            return true;
        else
            return false;
    }

    function deleteSoldProduct($sellId)
    {
        if($this->isSaleExist($sellId))
        {
            $query = "DELETE FROM sells WHERE sell_id =?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("s",$sellId);
            if ($stmt->execute())
                return SALE_RECORD_DELETED;
            else
                return SALE_RECORD_DELETE_FAILED;
        }
        else
            return SALE_NOT_EXIST;
    }

    function deleteSellerSoldProduct($sellId)
    {
        if($this->isSellerSaleExist($sellId))
        {
            $query = "DELETE FROM sellers_sells WHERE sellers_sell_id =?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("s",$sellId);
            if ($stmt->execute())
                return SALE_RECORD_DELETED;
            else
                return SALE_RECORD_DELETE_FAILED;
        }
        else
            return SALE_NOT_EXIST;
    }

    function isSaleExist($sellId)
    {
        $query = "SELECT sell_id from sells WHERE sell_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$sellId);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows()>0)
            return true;
        else
            return false;
    }

    function isSellerSaleExist($sellId)
    {
        $query = "SELECT sellers_sell_id from sellers_sells WHERE sellers_sell_id =?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$sellId);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows()>0)
            return true;
        else
            return false;
    }

    function isCreditExist($creditId)
    {
        $query = "SELECT creditId from credits WHERE creditId =?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$creditId);
        $stmt->execute();
        $stmt->store_result();
        return ($stmt->num_rows()>0) ? true : false;
    }

    function getInvoiceByInvoiceNumber($invoiceNumber)
    {
        $invoice = array();
        $invoices = array();
        $invoicess = array();
        $pro = array();
        if (!$this->isInvoiceExist($invoiceNumber))
           return $pro;
        $query = "SELECT invoice_id,invoice_number,seller_id,invoice_date FROM invoices WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($invoiceId,$invoiceNumber,$sellerId,$invoiceDate);
        $stmt->fetch();
        $invoice['invoiceId']           = $invoiceId;
        $invoice['invoiceNumber']       = $invoiceNumber;
        $invoice['sellerId']            = $sellerId;
        $invoice['invoiceDate']         = $invoiceDate;
        array_push($invoices, $invoice);
        $stmt->close();
        foreach ($invoices as  $invoice)
        {
            $paidAmount                     = (int) $this->getAllPaidAmountByInvoiceNumber($invoice['invoiceNumber']);
            $invoiceRemainingAmount         = $this->getTotalAmountByInvoiceNumber($invoice['invoiceNumber']) - (int) $this->getAllPaidAmountByInvoiceNumber($invoice['invoiceNumber']);
            $seller                         = $this->getSellerById($invoice['sellerId']);
            $sellerImage                    = $seller['sellerImage'];
            if (empty($sellerImage))
                $sellerImage = WEBSITE_DOMAIN.'uploads/api/user.png';
            if (empty($paidAmount))
                $paidAmount = 0;
            if (empty($invoiceRemainingAmount ))
                $invoiceRemainingAmount  = 0;
            $inv['invoiceId']               = $invoice['invoiceId'];
            $inv['invoiceNumber']           = $invoice['invoiceNumber'];
            $inv['invoiceDate']             = $invoice['invoiceDate'];
            $inv['invoiceAmount']           = $this->getTotalAmountByInvoiceNumber($invoice['invoiceNumber']);
            $inv['invoiceTotalPrice']       = $this->getTotalPriceOfInvoiceByInvoiceNumber($invoice['invoiceNumber']);
            $inv['invoicePaidAmount']       = $paidAmount;
            $inv['invoiceRemainingAmount']  = $invoiceRemainingAmount;
            $inv['invoiceStatus']           = $this->isInvoicePaid($inv['invoiceNumber']);
            $inv['sellerName']              = $seller['sellerName'];
            $inv['sellerImage']             = $sellerImage;
            $inv['sellerId']                = $seller['sellerId'];
            $inv['sellerContactNumber']     = $seller['sellerContactNumber'];
            $inv['sellerContactNumber1']    = $seller['sellerContactNumber1'];
            $inv['sellerAddress']           = $seller['sellerAddress'];
        }
        return $inv;
    }

    function getInvoicesBySellerId($sellerId)
    {
        $invoice = array();
        $invoices = array();
        $invoicess = array();
        $pro = array();
        $query = "SELECT invoice_id,invoice_number,seller_id,invoice_date FROM invoices WHERE seller_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$sellerId);
        $stmt->execute();
        $stmt->bind_result($invoiceId,$invoiceNumber,$sellerId,$invoiceDate);
        while($stmt->fetch())
        {
            $invoice['invoiceId']           = $invoiceId;
            $invoice['invoiceNumber']       = $invoiceNumber;
            $invoice['sellerId']            = $sellerId;
            $invoice['invoiceDate']         = $invoiceDate;
            array_push($invoices, $invoice);
        }
        $stmt->close();
        foreach ($invoices as  $invoice)
        {
            $paidAmount                     = (int) $this->getAllPaidAmountByInvoiceNumber($invoice['invoiceNumber']);
            $invoiceRemainingAmount         = $this->getTotalAmountByInvoiceNumber($invoice['invoiceNumber']) - (int) $this->getAllPaidAmountByInvoiceNumber($invoice['invoiceNumber']);
            $seller                         = $this->getSellerById($invoice['sellerId']);
            // $seller                         = $seller[0];
            $sellerImage                    = $seller['sellerImage'];
            if (empty($sellerImage))
                $sellerImage = WEBSITE_DOMAIN.'uploads/api/user.png';
            if (empty($paidAmount))
                $paidAmount = 0;
            if (empty($invoiceRemainingAmount ))
                $invoiceRemainingAmount  = 0;
            $inv['invoiceId']               = $invoice['invoiceId'];
            $inv['invoiceNumber']           = $invoice['invoiceNumber'];
            $inv['invoiceDate']             = $invoice['invoiceDate'];
            $inv['invoiceAmount']           = $this->getTotalAmountByInvoiceNumber($invoice['invoiceNumber']);
            $inv['invoiceTotalPrice']       = $this->getTotalPriceOfInvoiceByInvoiceNumber($invoice['invoiceNumber']);
            $inv['invoicePaidAmount']       = $paidAmount;
            $inv['invoiceRemainingAmount']  = $invoiceRemainingAmount;
            $inv['invoiceStatus']           = $this->isInvoicePaid($inv['invoiceNumber']);
            $inv['sellerName']              = $seller['sellerName'];
            $inv['sellerImage']             = $sellerImage;
            $inv['sellerId']     = $seller['sellerId'];
            $inv['sellerContactNumber']     = $seller['sellerContactNumber'];
            $inv['sellerContactNumber1']    = $seller['sellerContactNumber1'];
            $inv['sellerAddress']           = $seller['sellerAddress'];
            array_push($invoicess, $inv);
        }
        return $invoicess;
    }

    function getPaymentsByInvoiceNumber($invoiceNumber)
    {
        $invoice = array();
        $payments = array();
        $paymentss = array();
        $pro = array();
        $query = "SELECT payment_id,payment_date,payment_amount,invoice_number,seller_id FROM payments WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($paymentId,$paymentDate,$paymentAmount,$invoiceNumber,$sellerId);
        while($stmt->fetch())
        {
            $payment['paymentId']       = $paymentId;
            $payment['paymentDate']     = $paymentDate;
            $payment['paymentAmount']   = $paymentAmount;
            $payment['invoiceNumber']   = $invoiceNumber;
            $payment['sellerId']        = $sellerId;
            array_push($payments, $payment);
        }
        $stmt->close();
        foreach ($payments as  $payment)
        {
            $pay['paymentId']               = $payment['paymentId'];
            $pay['invoiceNumber']           = $payment['invoiceNumber'];
            $pay['paymentDate']             = $payment['paymentDate'];
            $pay['paymentAmount']           = $payment['paymentAmount'];
            $pay['sellerId']                = $payment['sellerId'];
            array_push($paymentss, $pay);
        }
        return $paymentss;
    }

    function getPaymentsByCreditId($creditId)
    {
        $invoice = array();
        $payments = array();
        $paymentss = array();
        $pro = array();
        $query = "SELECT paymentId,paymentDate,paymentAmount,creditId,creditorId FROM creditpayments WHERE creditId=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$creditId);
        $stmt->execute();
        $stmt->bind_result($paymentId,$paymentDate,$paymentAmount,$creditId,$creditorId);
        while($stmt->fetch())
        {
            $payment['paymentId']       = $paymentId;
            $payment['paymentDate']     = $paymentDate;
            $payment['paymentAmount']   = $paymentAmount;
            $payment['creditId']        = $creditId;
            $payment['creditorId']        = $creditorId;
            array_push($payments, $payment);
        }
        $stmt->close();
        foreach ($payments as  $payment)
        {
            $pay['paymentId']               = $payment['paymentId'];
            $pay['creditId']                = $payment['creditId'];
            $pay['paymentDate']             = $payment['paymentDate'];
            $pay['paymentAmount']           = $payment['paymentAmount'];
            $pay['creditorId']              = $payment['creditorId'];
            array_push($paymentss, $pay);
        }
        return $paymentss;
    }

    function getSellerSellProductsByInvoiceNumber($invoiceNumber)
    {
        $products = array();
        $productss = array();
        $query = "SELECT product_id, sell_quantity, sell_discount, sell_price FROM sellers_sells WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($productId,$saleQuantity,$sellDiscount,$sellPrice);
        while ($stmt->fetch())
        {
            $product['productId'] = $productId;
            $product['saleQuantity'] = $saleQuantity;
            $product['sellDiscount'] = $sellDiscount;
            $product['sellPrice'] = $sellPrice;
            array_push($products, $product);
        }
        $stmt->close();
        foreach ($products as $product)
        {
            $pro = $this->getProductById($product['productId']);
            $pro['productId']       = $product['productId'];
            $pro['saleQuantity']    = $product['saleQuantity'];
            $pro['sellDiscount']    = $product['sellDiscount'];
            $pro['sellPrice']       = $product['sellPrice'];
            array_push($productss, $pro);
        }
        return $productss;
    }

    function setInvoiceUrlByInvoiceNumber($invoiceUrl,$invoiceNumber)
    {
        $query = "UPDATE invoices SET invoice_url=? WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss',$invoiceUrl,$invoiceNumber);
        if($stmt->execute())
            return true;
        else
            return false;
    }

    // Working on this one function or from this ones function ok, first need to fetch the full details item of a product which is sold
    // whihch information should we have to return we will return it ok,
    function getInvoiceProductsByInvoiceNumber($invoiceNumber)
    {
        $products = array();
        $idAndQuantityArray = $this->getAllProductIdAndsaleQuantityByInvoiceNumber($invoiceNumber);
        foreach ($idAndQuantityArray as $idSelQuan)
        {
            $productss = $this->getProductById($idSelQuan['productId']);
            $product['productName'] = $productss['productName'];
            $product['productSize'] = $productss['productSize'];
            $product['productPrice'] = $productss['productPrice'];
            $product['saleQuantity'] = $idSelQuan['saleQuantity'];
            $product['productTotalPrice'] = $productss['productPrice']*$idSelQuan['saleQuantity'];
            $product['productDiscount']   = $this->getAllProductIdAndsaleQuantityByInvoiceNumber($productss['productId'],$invoiceNumber);
            // $product['productSellPrice']  = $this->decPercentage()
            array_push($products, $product);
        }
        return $products;
    }

    function getProductSellPercentageByProductIdAndInvoiceNumber($productId,$invoiceNumber)
    {
        $query = "SELECT sell_discount FROM sellers_sells WHERE product_id=? AND invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss',$productId,$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($sellPercentage);
        $stmt->fetch();
        return $sellPercentage;
    }

    function getPercentage($value,$values)
    {
        return 100 - ($value / $values) * 100;
    }

    function decPercentage($percent,$value)
    {
        return $value - ($percent / 100) * $value;
    }

    function getInvoicePDFByInvoiceNumber($invoiceNumber)
    {
        $invoice = $this->getInvoiceByInvoiceNumber($invoiceNumber);
    }

    function isInvoicePaid($invoiceNumber)
    {
        if ($this->getInvoiceStatus($invoiceNumber))
            return 'PAID';
        else
            return 'UNPAID';
    }

    function getInvoiceStatus($invoiceNumber)
    {
        $invoiceAmount = (int) $this->getTotalAmountByInvoiceNumber($invoiceNumber);
        $paidAmount = (int) $this->getAllPaidAmountByInvoiceNumber($invoiceNumber);
        if ($invoiceAmount-$paidAmount==0)
            return true;
        else
            return false;
    }

    function getProductById($productId)
    {
        $products = array();
        $pro = array();
        if (!$this->isProductExist($productId))
           return $pro;
        $query = "SELECT product_id,category_id,item_id,size_id,brand_id,product_price,location_id,product_manufacture,product_expire,barCode FROM products WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->bind_result($productId,$categoryId,$itemId,$sizeId,$brandId,$productPrice,$locationId,$productManufacture,$productExpire,$barCode);
        $stmt->fetch();
        $product['productId']           = $productId;
        $product['categoryId']          = $categoryId;
        $product['itemId']         = $itemId;
        $product['sizeId']              = $sizeId;
        $product['brandId']             = $brandId;
        $product['productPrice']        = $productPrice;
        $product['locationId']          = $locationId;
        $product['productManufacture']        = $productManufacture;
        $product['productExpire']        = $productExpire;
        $product['barCode']        = $barCode;
        array_push($products, $product);
        $stmt->close();
        foreach ($products as  $product)
        {
            $pro['productId']               = $product['productId'];
            $pro['saleId']                  = $this->getSaleId(); 
            $pro['saleQuantity']            = 1; 
            $pro['productCategory']         = $this->getCategoryById($product['categoryId']);
            $pro['productName']             = $this->getProductNameByItemId($product['itemId']);
            $pro['productSize']             = $this->getSizeById($product['sizeId']);
            $pro['productBrand']            = $this->getBrandById($product['brandId']);
            $pro['productPrice']            = $product['productPrice'];
            $pro['productLocation']         = $this->getLocationById($product['locationId']);
            $pro['productQuantity']         = $this->getProductCurrentQuantityById($product['productId']);
            $pro['productManufacture']      = substr($product['productManufacture'], 0, 7);
            $pro['productExpire']           = substr($product['productExpire'], 0, 7);
            $pro['barCode']                 = $product['barCode'];
        }
        return $pro;
    }

    function getProductBySlaeId($saleId)
    {
        $productId = $this->getProductIdBySaleId($saleId);
        $products = array();
        $pro = array();
        if (!$this->isProductExist($productId))
           return $pro;
        $query = "SELECT product_id,category_id,item_id,size_id,brand_id,product_price,location_id,product_manufacture,product_expire FROM products WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->bind_result($productId,$categoryId,$itemId,$sizeId,$brandId,$productPrice,$locationId,$productManufacture,$productExpire);
        $stmt->fetch();
        $product['productId']           = $productId;
        $product['categoryId']          = $categoryId;
        $product['itemId']         = $itemId;
        $product['sizeId']              = $sizeId;
        $product['brandId']             = $brandId;
        $product['productPrice']        = $productPrice;
        $product['locationId']          = $locationId;
        $product['productManufacture']        = $productManufacture;
        $product['productExpire']        = $productExpire;
        array_push($products, $product);
        $stmt->close();
        foreach ($products as  $product)
        {
            $pro['productId']               = $product['productId'];
            $pro['saleId']                  = $this->getSaleId(); 
            $pro['productCategory']         = $this->getCategoryById($product['categoryId']);
            $pro['productName']             = $this->getProductNameByItemId($product['itemId']);
            $pro['productSize']             = $this->getSizeById($product['sizeId']);
            $pro['productBrand']            = $this->getBrandById($product['brandId']);
            $pro['productPrice']            = $product['productPrice'];
            $pro['productLocation']         = $this->getLocationById($product['locationId']);
            $pro['productQuantity']         = $this->getProductCurrentQuantityById($product['productId']);
            $pro['productManufacture']      = substr($product['productManufacture'], 0, 7);
            $pro['productExpire']           = substr($product['productExpire'], 0, 7);
        }
        return $pro;
    }

    function getProductIdByBarCode($barCode)
    {
        $query = "SELECT product_id from products WHERE barCode=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$barCode);
        $stmt->execute();
        $stmt->bind_result($productId);
        $stmt->fetch();
        return $productId;
    }

    function updateSellProduct($saleId,$productQuantity,$sellDiscount,$productSalePrice)
    {
        if ($this->isSaleExist($saleId))
        {
            $productId = $this->getProductIdBySaleId($saleId);
            $currentSaleQuantity = $this->getSalesProductQuantityById($saleId);
            if ($this->getProductCurrentQuantityById($productId)+$currentSaleQuantity-$productQuantity>=0) 
            {
                 $query = "UPDATE sells SET sell_quantity=?, sell_discount=?, sell_price=? WHERE sell_id=?";
                $stmt = $this->con->prepare($query);
                $stmt->bind_param('ssss',$productQuantity,$sellDiscount,$productSalePrice,$saleId);
                if ($stmt->execute())
                {
                    return SALE_UPDATED;
                }
                else
                    return SALE_UPDATE_FAILED;
            }
            else
                return PRODUCT_QUANTITY_LOW;
        }
        else
            return SALE_NOT_EXIST;
    }

    function updateSellerSellProducts($saleId,$productQuantity,$sellDiscount,$productSalePrice)
    {
        if ($this->isSellerSaleExist($saleId))
        {
            $productId = $this->getProductIdBySellerSaleId($saleId);
            // $currentSaleQuantity = $this->getSalesProductQuantityById($saleId);
            $currentSellerSaleQuantity = $this->getSellerSalesProductQuantityById($saleId);
            if ($this->getProductCurrentQuantityById($productId)+$currentSellerSaleQuantity-$productQuantity>=0) 
            {
                 $query = "UPDATE sellers_sells SET sell_quantity=?, sell_discount=?, sell_price=? WHERE sellers_sell_id=?";
                $stmt = $this->con->prepare($query);
                $stmt->bind_param('ssss',$productQuantity,$sellDiscount,$productSalePrice,$saleId);
                if ($stmt->execute())
                {
                    return SALE_UPDATED;
                }
                else
                    return SALE_UPDATE_FAILED;
            }
            else
                return PRODUCT_QUANTITY_LOW;
        }
        else
            return SALE_NOT_EXIST;
    }

    function getProductCurrentQuantityById($productId)
    {
        $currentSaleQuantity = $this->getAllSalesQuantityOfProudctById($productId);
        $currentSellerSaleQuantity = $this->getAllSellerSalesQuantityOfProudctById($productId);
        $productQuantity = $this->getProductQuantityById($productId);
        return $productQuantity-$currentSaleQuantity-$currentSellerSaleQuantity;
    }

    function getSalesProductQuantityById($saleId)
    {
        $query = "SELECT sell_quantity from sells WHERE sell_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$saleId);
        $stmt->execute();
        $stmt->bind_result($saleQuanitty);
        $stmt->fetch();
        return $saleQuanitty;
    }

    function getSellerSalesProductQuantityById($saleId)
    {
        $query = "SELECT sell_quantity from sellers_sells WHERE sellers_sell_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$saleId);
        $stmt->execute();
        $stmt->bind_result($saleQuanitty);
        $stmt->fetch();
        return $saleQuanitty;
    }

    function getAllSalesQuantityOfProudctById($productId)
    {
        $allCount = 0;
        $query = "SELECT sell_quantity from sells WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->bind_result($saleQuanitty);
        while($stmt->fetch())
        {
            $allCount = $allCount+$saleQuanitty;
        }
        return $allCount;
    }

    function getAllSellerSalesQuantityOfProudctById($productId)
    {
        $allCount = 0;
        $query = "SELECT sell_quantity from sellers_sells WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->bind_result($saleQuanitty);
        while($stmt->fetch())
        {
            $allCount = $allCount+$saleQuanitty;
        }
        return $allCount;
    }

    function getProductIdBySellerSaleId($saleId)
    {
        $query = "SELECT product_id from sellers_sells WHERE sellers_sell_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$saleId);
        $stmt->execute();
        $stmt->bind_result($productId);
        $stmt->fetch();
        return $productId;
    }

    function getProductIdBySaleId($saleId)
    {
        $query = "SELECT product_id from sells WHERE sell_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$saleId);
        $stmt->execute();
        $stmt->bind_result($productId);
        $stmt->fetch();
        return $productId;
    }

    function getCreditorIdByCreditId($creditId)
    {
        $query = "SELECT creditorId from credits WHERE creditId=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$creditId);
        $stmt->execute();
        $stmt->bind_result($creditorId);
        $stmt->fetch();
        return $creditorId;
    }

    function getCreditorIdByMobileNumber($mobileNumber)
    {
        $query = "SELECT creditorId from creditors WHERE creditorMobile=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$mobileNumber);
        $stmt->execute();
        $stmt->bind_result($creditorId);
        $stmt->fetch();
        return $creditorId;
    }

    function addSize($sizeName)
    {
        $query = "INSERT INTO sizes (size_name) VALUES(?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$sizeName);
        return ($stmt->execute()) ? true : false;
    }

    function addCategory($categoryName)
    {
        $query = "INSERT INTO categories (category_name) VALUES(?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$categoryName);
        return ($stmt->execute()) ? true : false;
    }

    function addLocation($locationName)
    {
        $query = "INSERT INTO locations (location_name) VALUES(?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$locationName);
        return ($stmt->execute()) ? true : false;
    }

    function isEmailExist($email)
    {
        $query = "SELECT id FROM admin WHERE email=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows>0 ;
    }

    function isUpdateAvailable($version)
    {
        $result = array();
        $query = "SELECT updateUrl FROM updates WHERE updateVersion>?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$version);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows()>0)
            return true;
        else
            return false;
    }

    function getUpdateInfo()
    {
        $result = array();
        $query = "SELECT updateTitle,updateDescription,updateVersion,updateUrl FROM updates ORDER BY updateId DESC LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($updateTitle,$updateDescription,$updateVersion,$updateUrl);
        $stmt->fetch();
        $response['updateTitle'] = $updateTitle;
        $response['updateDescription'] = $updateDescription;
        $response['updateVersion'] = $updateVersion;
        $response['updateUrl'] = $updateUrl;
        return $response;
    }

    function isAdmin($adminId)
    {
        $query = "SELECT position FROM admin WHERE id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$adminId);
        $stmt->execute();
        $stmt->bind_result($position);
        $stmt->fetch();
        return ($position==1) ? true : false;
    }

    function isAdminExist($adminId)
    {
        $query = "SELECT email FROM admin WHERE id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$adminId);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows>0;
    }

    function isProductExist($productId)
    {
        $query = "SELECT product_id FROM products WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows>0;
    }

    function isItemExist($itemId)
    {
        $query = "SELECT itemId FROM items WHERE itemId=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$itemId);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows>0;
    }

    // function isBarCodeExist($itemId)
    // {
    //     $query = "SELECT product_id FROM products WHERE barCode=?";
    //     $stmt = $this->con->prepare($query);
    //     $stmt->bind_param('s',$itemId);
    //     $stmt->execute();
    //     $stmt->store_result();
    //     return $stmt->num_rows>0;
    // }

    function isBarCodeExist($barCode)
    {
        $query = "SELECT barCode FROM products WHERE barCode=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$barCode);
        $stmt->execute();
        $stmt->bind_result($dbBarCode);
        $stmt->fetch();
        return (strlen($dbBarCode)<2 || empty($dbBarCode)) ? false : true;
    }

    function getBrands()
    {
        $brands = array();
        $query = "SELECT brand_id,brand_name FROM brands ORDER BY brand_name ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($brandId,$brandName);
        while ($stmt->fetch())
        {
            $brand['brandId'] = $brandId;
            $brand['brandName'] = $brandName;
            array_push($brands, $brand);
        }
        return $brands;
    }

    // function getItems()
    // {
    //     $items = array();
    //     $query = "SELECT itemId,itemName,itemDescription FROM items ORDER BY itemName ASC";
    //     $stmt = $this->con->prepare($query);
    //     $stmt->execute();
    //     $stmt->bind_result($itemName,$itemDescription);
    //     while ($stmt->fetch())
    //     {
    //         $item['itemId'] = $itemId;
    //         $item['itemName'] = $itemName;
    //         $item['itemDescription'] = $itemDescription;
    //         array_push($items, $item);
    //     }
    //     return $items;
    // }

     function getItems()
    {
        $items = array();
        $query = "SELECT itemId,itemName,itemDescription FROM items";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($itemId,$itemName,$itemDescription);
        while ($stmt->fetch())
        {
          $item['itemId'] = $itemId;
          $item['itemName'] = $itemName;
          $item['itemDescription'] = $itemDescription;
          array_push($items, $item);
        }
        return $items;
    }


    function getSizes()
    {
        $sizes = array();
        $query = "SELECT size_id,size_name FROM sizes ORDER BY size_name ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sizeId,$sizeName);
        while ($stmt->fetch())
        {
            $size['sizeId'] = $sizeId;
            $size['sizeName'] = $sizeName;
            array_push($sizes, $size);
        }
        return $sizes;
    }

    function getCategories()
    {
        $categories = array();
        $query = "SELECT category_id,category_name FROM categories ORDER BY category_name ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($categoryId,$categoryName);
        while ($stmt->fetch())
        {
            $category['categoryId'] = $categoryId;
            $category['categoryName'] = $categoryName;
            array_push($categories, $category);
        }
        return $categories;
    }

    function getTodaysSalesRecord()
    {
        $products = array();
        $pr = array();
        date_default_timezone_set('Asia/Kolkata');
        $date = new DateTime();
        $date->setTime(00,00);
        $startDT = $date->format('Y-m-d H:i:s');
        $date->setTime(23,59);
        $endDT = $date->format('Y-m-d H:i:s');
        $query = "SELECT sell_id,product_id,sell_quantity,sell_discount,sell_price,created_at FROM sells where created_at between '$startDT' and '$endDT' ORDER By sell_id DESC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sellId,$productId,$saleQuantity,$saleDiscount,$sellPrice,$createdAt);
        while ($stmt->fetch()) 
        {
            $pro['sellId'] = $sellId;
            $pro['productId'] = $productId;
            $pro['saleQuantity'] = $saleQuantity;
            $pro['saleDiscount'] = $saleDiscount;
            $pro['sellPrice'] = $sellPrice;
            $pro['createdAt'] = $createdAt;
            array_push($products, $pro);
        }
        $stmt->close();
        foreach ($products as $product)
        {
            $pro = $this->getProductById($product['productId']);
            $pro['saleId'] = $product['sellId'];
            $pro['saleQuantity'] = $product['saleQuantity'];
            $pro['saleDiscount'] = $product['saleDiscount'];
            $pro['salePrice'] = $product['sellPrice'];
            $pro['createdAt'] = $product['createdAt'];
            array_push($pr, $pro);
        }
        return $pr;
    }

    function getSalesRecordByDate($fromDate,$toDate)
    {
        $products = array();
        $pr = array();
        date_default_timezone_set('Asia/Kolkata');
        $date = new DateTime($fromDate);
        $date->setTime(00,00);
        $fromDate = $date->format('Y-m-d H:i:s');
        $date = new DateTime($toDate);
        $date->setTime(23,59);
        $toDate = $date->format('Y-m-d H:i:s');
        $query = "SELECT sell_id,product_id,sell_quantity,sell_discount,sell_price,created_at FROM sells where created_at between '$fromDate' and '$toDate' ORDER By sell_id DESC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sellId,$productId,$saleQuantity,$saleDiscount,$sellPrice,$createdAt);
        while ($stmt->fetch()) 
        {
            $pro['sellId'] = $sellId;
            $pro['productId'] = $productId;
            $pro['saleQuantity'] = $saleQuantity;
            $pro['saleDiscount'] = $saleDiscount;
            $pro['sellPrice'] = $sellPrice;
            $pro['createdAt'] = $createdAt;
            array_push($products, $pro);
        }
        $stmt->close();
        foreach ($products as $product)
        {
            $pro = $this->getProductById($product['productId']);
            $pro['saleId'] = $product['sellId'];
            $pro['saleQuantity'] = $product['saleQuantity'];
            $pro['saleDiscount'] = $product['saleDiscount'];
            $pro['salePrice'] = $product['sellPrice'];
            $pro['createdAt'] = $product['createdAt'];
            array_push($pr, $pro);
        }
        return $pr;
    }

    function getSalesRecordBySalesIds($sales)
    {
        $products = array();
        $pr = array();
        $saless = implode(",",$sales);
        $query = "SELECT sell_id,product_id,sell_quantity,sell_discount,sell_price,created_at FROM sells where sell_id IN ($saless) ORDER By sell_id DESC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sellId,$productId,$saleQuantity,$saleDiscount,$sellPrice,$createdAt);
        while ($stmt->fetch()) 
        {
            $pro['sellId'] = $sellId;
            $pro['productId'] = $productId;
            $pro['saleQuantity'] = $saleQuantity;
            $pro['saleDiscount'] = $saleDiscount;
            $pro['sellPrice'] = $sellPrice;
            $pro['createdAt'] = $createdAt;
            array_push($products, $pro);
        }
        $stmt->close();
        foreach ($products as $product)
        {
            $pro = $this->getProductById($product['productId']);
            $pro['saleId'] = $product['sellId'];
            $pro['saleQuantity'] = $product['saleQuantity'];
            $pro['saleDiscount'] = $product['saleDiscount'];
            $pro['salePrice'] = $product['sellPrice'];
            $pro['createdAt'] = $product['createdAt'];
            array_push($pr, $pro);
        }
        return $pr;
    }

    function getInvoices()
    {
        $invoice = array();
        $invoices = array();
        $invoicess = array();
        $seller = array();
        $pro = array();
        $query = "SELECT invoice_id,invoice_number,seller_id,invoice_date FROM invoices";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($invoiceId,$invoiceNumber,$sellerId,$invoiceDate);
        while($stmt->fetch())
        {
            $invoice['invoiceId']           = $invoiceId;
            $invoice['invoiceNumber']       = $invoiceNumber;
            $invoice['sellerId']            = $sellerId;
            $invoice['invoiceDate']         = $invoiceDate;
            array_push($invoices, $invoice);
        }
        $stmt->close();
        foreach ($invoices as  $invoice)
        {
            $seller                         = $this->getSellerById($invoice['sellerId']);
            // $seller                         = $seller[0];
            $inv['invoiceId']               = $invoice['invoiceId'];
            $inv['invoiceNumber']           = $invoice['invoiceNumber'];
            $inv['invoiceDate']             = $invoice['invoiceDate'];
            $inv['invoiceAmount']           = $this->getTotalAmountByInvoiceNumber($invoice['invoiceNumber']);
            $inv['invoicePaidAmount']       = $this->getAllPaidAmountByInvoiceNumber($invoice['invoiceNumber']);
            $inv['invoiceRemainingAmount']  = $this->getTotalAmountByInvoiceNumber($invoice['invoiceNumber']) - $this->getAllPaidAmountByInvoiceNumber($invoice['invoiceNumber']);
            $inv['invoiceStatus']           = $this->isInvoicePaid($inv['invoiceNumber']);
            $inv['sellerName']              = $seller['sellerName'];
            $inv['sellerImage']             = $seller['sellerImage'];
            $inv['sellerContactNumber']     = $seller['sellerContactNumber'];
            $inv['sellerContactNumber1']    = $seller['sellerContactNumber1'];
            $inv['sellerAddress']           = $seller['sellerAddress'];
            array_push($invoicess, $inv);
        }
        return $invoicess;
    }

    function getSalesCountByProductId($productId)
    {
        $productQuantity = 0;
        $query = "SELECT sell_quantity FROM sells WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->bind_result($quantity);
        while ($stmt->fetch())
        {
            $productQuantity = $productQuantity+$quantity;
        }
        return $productQuantity;
    }

    function getSellerSalesCountByProductId($productId)
    {
        $productQuantity = 0;
        $query = "SELECT sell_quantity FROM sellers_sells WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->bind_result($quantity);
        while ($stmt->fetch())
        {
            $productQuantity = $productQuantity+$quantity;
        }
        return $productQuantity;
    }

    function getAllSalesRecord()
    {
        $products = array();
        $pr = array();
        $pro = array();
        date_default_timezone_set('Asia/Kolkata');
        $date = new DateTime();
        $date->setTime(00,00);
        $startDT = $date->format('Y-m-d H:i:s');
        $date->setTime(23,59);
        $endDT = $date->format('Y-m-d H:i:s');
        $query = "SELECT sell_id,product_id,sell_quantity,sell_discount,sell_price,created_at FROM sells ORDER By sell_id DESC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sellId,$productId,$saleQuanitty,$saleDiscount,$sellPrice,$createdAt);
        while ($stmt->fetch()) 
        {
            $pro['sellId'] = $sellId;
            $pro['productId'] = $productId;
            $pro['saleQuanitty'] = $saleQuanitty;
            $pro['saleDiscount'] = $saleDiscount;
            $pro['sellPrice'] = $sellPrice;
            $pro['createdAt'] = $createdAt;
            array_push($products, $pro);
        }
        $stmt->close();
        foreach ($products as $product)
        {
            $pro = $this->getProductById($product['productId']);
            $pro['saleId'] = $product['sellId'];
            $pro['saleQuanitty'] = $product['saleQuanitty'];
            $pro['saleDiscount'] = $product['saleDiscount'];
            $pro['salePrice'] = $product['sellPrice'];
            $pro['createdAt'] = $product['createdAt'];
            array_push($pr, $pro);
        }
        return $pr;
    }

    function getLocations()
    {
        $locations = array();
        $query = "SELECT location_id,location_name FROM locations ORDER BY location_name ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($locationId,$locationName);
        while ($stmt->fetch())
        {
            $location['locationId'] = $locationId;
            $location['locationName'] = $locationName;
            array_push($locations, $location);
        }
        return $locations;
    }

    function getProducts()
    {
        $products = array();
        $productss = array();
        $query = "SELECT product_id,category_id,item_id,size_id,brand_id,product_price,product_quantity,location_id,product_manufacture,product_expire FROM products ORDER by item_id ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$categoryId,$itemId,$sizeId,$brandId,$productPrice,$productQuantity,$locationId,$productManufacture,$productExpire);
        while ($stmt->fetch())
        {
            $product['productId']           = $productId;
            $product['categoryId']          = $categoryId;
            $product['itemId']              = $itemId;
            $product['sizeId']              = $sizeId;
            $product['brandId']             = $brandId;
            $product['productPrice']        = $productPrice;
            $product['productQuantity']     = $productQuantity;
            $product['locationId']          = $locationId;
            $product['productManufacture']  = $productManufacture;
            $product['productExpire']       = $productExpire;
            array_push($products, $product);
        }
        foreach ($products as  $product)
        {
            $pro['productId']               = $product['productId'];
            $pro['productCategory']         = $this->getCategoryById($product['categoryId']);
            $pro['productName']             = $this->getProductNameByItemId($product['itemId']);
            $pro['productSize']             = $this->getSizeById($product['sizeId']);
            $pro['productBrand']            = $this->getBrandById($product['brandId']);
            $pro['productPrice']            = $product['productPrice'];
            $pro['productQuantity']         = $this->getProductCurrentQuantityById($pro['productId']);
            $pro['productLocation']         = $this->getLocationById($product['locationId']);
            $pro['productManufacture']      = substr($product['productManufacture'], 0, 7);
            $pro['productExpire']           = substr($product['productExpire'], 0, 7);
            array_push($productss, $pro);
        }
        return $productss;
    }

    function getAvailableProducts()
    {
        $products = array();
        $productss = array();
        $query = "SELECT product_id,category_id,item_id,size_id,brand_id,product_price,product_quantity,location_id,product_manufacture,product_expire FROM products ORDER by item_id ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$categoryId,$itemId,$sizeId,$brandId,$productPrice,$productQuantity,$locationId,$productManufacture,$productExpire);
        while ($stmt->fetch())
        {
            $product['productId']           = $productId;
            $product['categoryId']          = $categoryId;
            $product['itemId']              = $itemId;
            $product['sizeId']              = $sizeId;
            $product['brandId']             = $brandId;
            $product['productPrice']        = $productPrice;
            $product['productQuantity']     = $productQuantity;
            $product['locationId']          = $locationId;
            $product['productManufacture']  = $productManufacture;
            $product['productExpire']       = $productExpire;
            array_push($products, $product);
        }
        foreach ($products as  $product)
        {
            $salesQuantity = $this->getAllSalesQuantityOfProudctById($product['productId']);
            $productQuantity = $product['productQuantity']-$this->getsaleQuantityByProductId($product['productId']);
            if ($productQuantity>0)
            {
                $pro['productId']               = $product['productId'];
                $pro['productCategory']         = $this->getCategoryById($product['categoryId']);
                $pro['productName']             = $this->getProductNameByItemId($product['itemId']);
                $pro['productSize']             = $this->getSizeById($product['sizeId']);
                $pro['productBrand']            = $this->getBrandById($product['brandId']);
                $pro['productPrice']            = $product['productPrice'];
                $pro['productQuantity']         = $this->getProductCurrentQuantityById($pro['productId']);
                $pro['productLocation']         = $this->getLocationById($product['locationId']);
                $pro['productManufacture']      = substr($product['productManufacture'], 0, 7);
                $pro['productExpire']           = substr($product['productExpire'], 0, 7);
                array_push($productss, $pro);
            }
        }
        return $productss;
    }

    function getProductsRecord()
    {
        $products = array();
        $productss = array();
        $query = "SELECT product_id,category_id,item_id,size_id,brand_id,product_price,product_quantity,location_id,product_manufacture,product_expire FROM products_record ORDER by created_at DESC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$categoryId,$itemId,$sizeId,$brandId,$productPrice,$productQuantity,$locationId,$productManufacture,$productExpire);
        while ($stmt->fetch())
        {
            $product['productId']           = $productId;
            $product['categoryId']          = $categoryId;
            $product['itemId']              = $itemId;
            $product['sizeId']              = $sizeId;
            $product['brandId']             = $brandId;
            $product['productPrice']        = $productPrice;
            $product['productQuantity']     = $productQuantity;
            $product['locationId']          = $locationId;
            $product['productManufacture']  = $productManufacture;
            $product['productExpire']       = $productExpire;
            array_push($products, $product);
        }
        foreach ($products as  $product)
        {
            $pro['productId']               = $product['productId'];
            $pro['productCategory']         = $this->getCategoryById($product['categoryId']);
            $pro['productName']             = $this->getProductNameByItemId($product['itemId']);
            $pro['productSize']             = $this->getSizeById($product['sizeId']);
            $pro['productBrand']            = $this->getBrandById($product['brandId']);
            $pro['productPrice']            = $product['productPrice'];
            $pro['productQuantity']         = $product['productQuantity'];
            $pro['productLocation']         = $this->getLocationById($product['locationId']);
            $pro['productManufacture']      = substr($product['productManufacture'], 0, 7);
            $pro['productExpire']           = substr($product['productExpire'], 0, 7);
            array_push($productss, $pro);
        }
        return $productss;
    }

    function getNoticeProducts()
    {
        $products = array();
        $productss = array();
        $productsss = array();
        $productNoticeCount = $this->getProductNoticeCount();
        $query = "SELECT product_id,category_id,item_id,size_id,brand_id,product_price,SUM(product_quantity),location_id,product_manufacture,product_expire FROM products WHERE product_expire >= DATE_ADD(CURDATE(), INTERVAL 1 DAY) group by (product_id),(item_id),(brand_id),(category_id),(size_id) ORDER by product_expire DESC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$categoryId,$itemId,$sizeId,$brandId,$productPrice,$productQuantity,$locationId,$productManufacture,$productExpire);
        while ($stmt->fetch())
        {
            $product['productId']           = $productId;
            $product['categoryId']          = $categoryId;
            $product['itemId']              = $itemId;
            $product['sizeId']              = $sizeId;
            $product['brandId']             = $brandId;
            $product['productPrice']        = $productPrice;
            $product['productQuantity']     = $productQuantity;
            $product['locationId']          = $locationId;
            $product['productManufacture']  = $productManufacture;
            $product['productExpire']       = $productExpire;
            array_push($products, $product);
        }
        foreach ($products as  $product)
        {
            $salesQuantity = $this->getAllSalesQuantityOfProudctById($product['productId']);
            $sellerSalesQuantity = $this->getAllSellerSalesQuantityOfProudctById($product['productId']);
            if ($product['productQuantity']-$salesQuantity-$sellerSalesQuantity<=$productNoticeCount)
            {
                $pro['productId']               = $product['productId'];
                $pro['productCategory']         = $this->getCategoryById($product['categoryId']);
                $pro['productName']             = $this->getProductNameByItemId($product['itemId']);
                $pro['productSize']             = $this->getSizeById($product['sizeId']);
                $pro['productBrand']            = $this->getBrandById($product['brandId']);
                $pro['productPrice']            = $product['productPrice'];
                $pro['productQuantity']         = $product['productQuantity']-$this->getsaleQuantityByProductId($pro['productId'])-$this->getAllSellerSalesQuantityOfProudctById($pro['productId']);
                $pro['productLocation']         = $this->getLocationById($product['locationId']);
                $pro['productManufacture']      = substr($product['productManufacture'], 0, 7);
                $pro['productExpire']           = substr($product['productExpire'], 0, 7);
                array_push($productss, $pro);
            }
        }
        return $productss;
    }

    function getNoticeProductsCount()
    {
        $count = 0;
        $products = array();
        $productss = array();
        $productNoticeCount = $this->getProductNoticeCount();
        // $query = "SELECT product_id,product_quantity FROM products WHERE product_expire >= DATE_ADD(CURDATE(), INTERVAL 1 DAY) ORDER by product_expire DESC";
        $query = "SELECT product_id,SUM(product_quantity) FROM products WHERE product_expire >= DATE_ADD(CURDATE(), INTERVAL 1 DAY) group by (product_id),(item_id),(brand_id),(category_id),(size_id)";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$productQuantity);
        while ($stmt->fetch())
        {
            $product['productId']           = $productId;
            $product['productQuantity']     = $productQuantity;
            array_push($products, $product);
        }
        foreach ($products as  $product)
        {
            $salesQuantity = $this->getAllSalesQuantityOfProudctById($product['productId']);
            $sellerSalesQuantity = $this->getAllSellerSalesQuantityOfProudctById($product['productId']);
            if ($product['productQuantity']-$salesQuantity-$sellerSalesQuantity<=$productNoticeCount)
            {
                $count++;
            }
        }
        return $count;
    }

    function getExpiringProducts()
    {
        $products = array();
        $productss = array();
        $query = "SELECT product_id,category_id,item_id,size_id,brand_id,product_price,product_quantity,location_id,product_manufacture,product_expire FROM products WHERE product_expire <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH) && product_expire >= DATE_ADD(CURDATE(), INTERVAL 1 DAY) ORDER by product_expire ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$categoryId,$itemId,$sizeId,$brandId,$productPrice,$productQuantity,$locationId,$productManufacture,$productExpire);
        while ($stmt->fetch())
        {
            $product['productId']           = $productId;
            $product['categoryId']          = $categoryId;
            $product['itemId']         = $itemId;
            $product['sizeId']              = $sizeId;
            $product['brandId']             = $brandId;
            $product['productPrice']        = $productPrice;
            $product['productQuantity']     = $productQuantity;
            $product['locationId']          = $locationId;
            $product['productManufacture']  = $productManufacture;
            $product['productExpire']       = $productExpire;
            array_push($products, $product);
        }
        foreach ($products as  $product)
        {
            $salesQuantity = $this->getAllSalesQuantityOfProudctById($product['productId']);
            $productQuantity = $product['productQuantity']-$this->getsaleQuantityByProductId($product['productId']);
            if ($productQuantity>0)
            {
                $pro['productId']               = $product['productId'];
                $pro['productCategory']         = $this->getCategoryById($product['categoryId']);
                $pro['productName']             = $this->getProductNameByItemId($product['itemId']);
                $pro['productSize']             = $this->getSizeById($product['sizeId']);
                $pro['productBrand']            = $this->getBrandById($product['brandId']);
                $pro['productPrice']            = $product['productPrice'];
                $pro['productQuantity']         = $productQuantity;
                $pro['productLocation']         = $this->getLocationById($product['locationId']);
                $pro['productManufacture']      = substr($product['productManufacture'], 0, 7);
                $pro['productExpire']           = substr($product['productExpire'], 0, 7);
                array_push($productss, $pro);
            }
        }
        return $productss;
    }

    function getExpiringProductsCount()
    {
        $count = 0;
        $products = array();
        $productss = array();
        // $query = "SELECT COUNT(*) FROM ( SELECT product_id FROM `products` WHERE product_expire <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH) && product_expire >= DATE_ADD(CURDATE(), INTERVAL 1 DAY) GROUP BY (item_id),(brand_id),(category_id),(size_id) ) AS num";
        $query = "SELECT product_id,product_quantity FROM `products` WHERE product_expire <= DATE_ADD(CURDATE(), INTERVAL 6 MONTH) && product_expire >= DATE_ADD(CURDATE(), INTERVAL 1 DAY) GROUP BY (product_id),(item_id),(brand_id),(category_id),(size_id)";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$productQuantity);
        while ($stmt->fetch())
        {
            $pro['productId'] = $productId;
            $pro['productQuantity'] = $productQuantity;
            array_push($products, $pro);
        }
        $stmt->close();
        foreach ($products as $product)
        {
            $productQuantity = $product['productQuantity']-$this->getsaleQuantityByProductId($product['productId']);
            if ($productQuantity>0)
                $count++;
        }
        return $count;
    }

    function getExpiredProducts()
    {
        $products = array();
        $productss = array();
        $query = "SELECT product_id,category_id,item_id,size_id,brand_id,product_price,product_quantity,location_id,product_manufacture,product_expire FROM products WHERE product_expire<CURDATE() ORDER by product_expire ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$categoryId,$itemId,$sizeId,$brandId,$productPrice,$productQuantity,$locationId,$productManufacture,$productExpire);
        while ($stmt->fetch())
        {
            $product['productId']           = $productId;
            $product['categoryId']          = $categoryId;
            $product['itemId']         = $itemId;
            $product['sizeId']              = $sizeId;
            $product['brandId']             = $brandId;
            $product['productPrice']        = $productPrice;
            $product['productQuantity']     = $productQuantity;
            $product['locationId']          = $locationId;
            $product['productManufacture']  = $productManufacture;
            $product['productExpire']       = $productExpire;
            array_push($products, $product);
        }
        foreach ($products as  $product)
        {
            // $salesQuantity = $this->getAllSalesQuantityOfProudctById($product['productId']);
            // if ($product['productQuantity']-$salesQuantity<1)
            // {
                $productQuantity = $product['productQuantity']-$this->getsaleQuantityByProductId($product['productId']);
                if ($productQuantity>0)
                {
                    $pro['productId']               = $product['productId'];
                    $pro['productCategory']         = $this->getCategoryById($product['categoryId']);
                    $pro['productName']             = $this->getProductNameByItemId($product['itemId']);
                    $pro['productSize']             = $this->getSizeById($product['sizeId']);
                    $pro['productBrand']            = $this->getBrandById($product['brandId']);
                    $pro['productPrice']            = $product['productPrice'];
                    $pro['productQuantity']         = $productQuantity;
                    $pro['productLocation']         = $this->getLocationById($product['locationId']);
                    $pro['productManufacture']      = substr($product['productManufacture'], 0, 7);
                    $pro['productExpire']           = substr($product['productExpire'], 0, 7);
                    array_push($productss, $pro);
                }
            // }
        }
        return $productss;
    }

    function getExpiredProductsCount()
    {
        $count = 0;
        $products = array();
        $productss = array();
        $query = "SELECT product_id,product_quantity FROM products WHERE product_expire<CURDATE() GROUP BY (product_id),(item_id),(brand_id),(category_id),(size_id)";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$productQuantity);
        // $stmt->fetch();
        while ($stmt->fetch())
        {
            $pro['productId'] = $productId;
            $pro['productQuantity'] = $productQuantity;
            array_push($products, $pro);
        }
        $stmt->close();
        foreach ($products as $product)
        {
            $productQuantity = $product['productQuantity']-$this->getsaleQuantityByProductId($product['productId']);
            if ($productQuantity>0)
                $count++;
        }
        return $count;
    }

    function getProductsCount()
    {
        $query = "SELECT COUNT(*) FROM ( SELECT product_id FROM `products` GROUP BY (product_id),(item_id),(brand_id),(category_id),(size_id) ) AS num";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productsCount);
        $stmt->fetch();
        return $productsCount;
    }

    function getAvaliableProductsCount()
    {
                $products = array();
        $productss = array();
        $query = "SELECT product_id,category_id,item_id,size_id,brand_id,product_price,product_quantity,location_id,product_manufacture,product_expire FROM products ORDER by item_id ASC";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$categoryId,$itemId,$sizeId,$brandId,$productPrice,$productQuantity,$locationId,$productManufacture,$productExpire);
        while ($stmt->fetch())
        {
            $product['productId']           = $productId;
            $product['productQuantity']     = $productQuantity;
            array_push($products, $product);
        }
        $counts = 0;
        foreach ($products as  $product)
        {
            $salesQuantity = $this->getAllSalesQuantityOfProudctById($product['productId']);
            $productQuantity = $product['productQuantity']-$this->getsaleQuantityByProductId($product['productId']);
            if ($productQuantity>0)
            {
                $counts++;
            }
        }
        return $counts;
    }

    function getBrandsCount()
    {
        $query = "SELECT COUNT(brand_id) FROM brands";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($brandsCount);
        $stmt->fetch();
        return $brandsCount;
    }

    function getTodaysSalesCount()
    {
        date_default_timezone_set('Asia/Kolkata');
        $date = new DateTime();
        $date->setTime(00,00);
        $startDT = $date->format('Y-m-d H:i:s');
        $date->setTime(23,59);
        $endDT = $date->format('Y-m-d H:i:s');
        $query = "SELECT COUNT(sell_id) FROM sells where created_at between '$startDT' and '$endDT'";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($salesCount);
        $stmt->fetch();
        return $salesCount;
    }

    function getCategoryById($categoryId)
    {
        $query = "SELECT category_name FROM categories WHERE category_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$categoryId);
        $stmt->execute();
        $stmt->bind_result($categoryName);
        $stmt->fetch();
        return $categoryName;
    }

    function getSellerIdByInvoiceNumber($invoiceNumber)
    {
        $query = "SELECT seller_id FROM invoices WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($sellerId);
        $stmt->fetch();
        return $sellerId;
    }

    function getSizeById($sizeId)
    {
        $query = "SELECT size_name FROM sizes WHERE size_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$sizeId);
        $stmt->execute();
        $stmt->bind_result($sizeName);
        $stmt->fetch();
        return $sizeName;
    }

    function getBarCodeByProductId($productId)
    {
        $query = "SELECT barCode FROM products WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->bind_result($barCode);
        $stmt->fetch();
        return $barCode;
    }

    function getSaleInfoBySaleId($saleId)
    {
        $simpleSaleInfo = $this->getSimpleSaleInfoBySaleId($saleId);
        $product = $this->getProductById($simpleSaleInfo['productId']);
        $products['productId'] = $product['productId'];
        $products['productCategory']    =   $product['productCategory'];
        $products['productName']        =   $product['productName'];
        $products['productSize']        =   $product['productSize'];
        $products['productBrand']       =   $product['productBrand'];
        $products['productPrice']       =   $product['productPrice'];
        $products['saleQuantity']       =   $simpleSaleInfo['saleQuantity'];
        $products['saleDiscount']       =   $simpleSaleInfo['saleDiscount'];
        $products['salePrice']          =   $simpleSaleInfo['salePrice'];
        $products['productManufacture'] =   $product['productManufacture'];
        $products['productExpire']      =   $product['productExpire'];
        return $products;
    }

    function getSimpleSaleInfoBySaleId($saleId)
    {
        $record = array();
        $query = "SELECT product_id,sell_quantity,sell_discount,sell_price FROM sells WHERE sell_id=? ";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$saleId);
        $stmt->execute();
        $stmt->bind_result($productId,$saleQuantity,$saleDiscount,$salePrice);
        $stmt->fetch();
        $record['productId'] =  $productId;
        $record['saleQuantity'] =  $saleQuantity;
        $record['saleDiscount'] =  $saleDiscount;
        $record['salePrice'] =  $salePrice;
        return $record;
    }

    function getsaleQuantityByProductId($productId)
    {
        $query = "SELECT SUM(sell_quantity) FROM sells WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->bind_result($productQuantity);
        $stmt->fetch();
        return $productQuantity;
    }

    function getBrandById($brandId)
    {
        $query = "SELECT brand_name FROM brands WHERE brand_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$brandId);
        $stmt->execute();
        $stmt->bind_result($brandName);
        $stmt->fetch();
        return $brandName;
    }

    function getProductPriceById($productId)
    {
        $query = "SELECT product_price FROM products WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->bind_result($productPrice);
        $stmt->fetch();
        return $productPrice;
    }

    function getAllProductIdAndsaleQuantityByInvoiceNumber($invoiceNumber)
    {
        $details = array();
        $query = "SELECT product_id,sell_quantity FROM sellers_sells WHERE invoice_number=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$invoiceNumber);
        $stmt->execute();
        $stmt->bind_result($productId,$saleQuantity);
        while($stmt->fetch())
        {
            $result['productId'] = $productId;
            $result['saleQuantity'] = $saleQuantity;
            array_push($details, $result);
        }
        return $details;
    }

    function getTotalPriceOfInvoiceByInvoiceNumber($invoiceNumber)
    {
        $productPrice = 0;
        $details = $this->getAllProductIdAndsaleQuantityByInvoiceNumber($invoiceNumber);   
        foreach ($details as $det)
        {
            $productPrice = $productPrice+ $this->getProductPriceById($det['productId'])*$det['saleQuantity'];
        }
        return $productPrice;
    }

    function getLastSaleId()
    {
        $query = "SELECT sale_id FROM sales ORDER by sale_id DES LIMIT 1";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($saleId);
        $stmt->fetch();
        return $saleId;
    }

    function getProductQuantityById($productId)
    {
        $query = "SELECT product_quantity FROM products WHERE product_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$productId);
        $stmt->execute();
        $stmt->bind_result($productQuantity);
        $stmt->fetch();
        return $productQuantity;
    }

    function getProductNameByItemId($itemId)
    {
        $query = "SELECT itemName FROM items WHERE itemId=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$itemId);
        $stmt->execute();
        $stmt->bind_result($productName);
        $stmt->fetch();
        return $productName;
    }

    function getLocationById($locationId)
    {
        $query = "SELECT location_name FROM locations WHERE location_id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$locationId);
        $stmt->execute();
        $stmt->bind_result($locationName);
        $stmt->fetch();
        return $locationName;
    }

    function checkUserById($id)
    {
        $query = "SELECT email FROM admin WHERE id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $stmt->store_result();
        return ($stmt->num_rows>0) ? true : false;
    }

    function getPasswordByEmail($email)
    {
        $query = "SELECT password FROM admin WHERE email=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->bind_result($password);
        $stmt->fetch();
        return $password;
    }

     function getPasswordById($userId)
    {
        $query = "SELECT password FROM admin WHERE id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$userId);
        $stmt->execute();
        $stmt->bind_result($password);
        $stmt->fetch();
        return $password;
    }

    function getUserIdByEmail($email)
    {
        $query = "SELECT id FROM users WHERE email=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        return $id;
    }

    function getCode($codeType)
    {
        $tokenId = $this->getUserId();
        $query = "SELECT code FROM codes WHERE userId=? AND codeType=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss',$tokenId,$codeType);
        $stmt->execute();
        $stmt->bind_result($code);
        $stmt->fetch();
        return $code;
    }

    function verifyCode($code,$codeType)
    {
        $dbCode = $this->decrypt($this->getCode($codeType));
        if ($code==$dbCode)
            return true;
        else
            return false;
    }

    function getUserByEmail($email)
    {
        $query = "SELECT id,name,email,image FROM admin WHERE email=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->bind_result($id,$name,$email,$image);
        $stmt->fetch();
        $user = array();
        $user['id'] = $id;
        $user['name'] = $name;
        $user['email'] = $email;
        if (empty($image))
            $image = DEFAULT_USER_IMAGE;
        $user['image'] = WEBSITE_DOMAIN.$image;
        return $user;
    }

    function getAdminById($adminId)
    {
        $query = "SELECT id,name,email,password,image,position FROM admin WHERE id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$adminId);
        $stmt->execute();
        $stmt->bind_result($id,$name,$email,$password,$image,$position);
        $stmt->fetch();
        $user = array();
        $user['adminId'] = $id;
        $user['adminName'] = $name;
        $user['adminEmail'] = $email;
        $user['adminPassword'] = $password;
        if (empty($image))
            $image = DEFAULT_USER_IMAGE;
        $user['adminImage'] = WEBSITE_DOMAIN.$image;
        $user['adminPosition'] = $adminPosition;
        return $user;
    }

    function getCurrentUser()
    {
        $tokenId = $this->getUserId();
        $query = "SELECT id,name,email,image FROM admin WHERE id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$tokenId);
        $stmt->execute();
        $stmt->bind_result($id,$name,$email,$image);
        $stmt->fetch();
        $user = array();
        $user['id'] = $id;
        $user['name'] = $name;
        $user['email'] = $email;
        if (empty($image))
            $image = DEFAULT_USER_IMAGE;
        $user['image'] = WEBSITE_DOMAIN.$image;
        return $user;
    }

    function updateAndroidToken($androidToken)
    {
        $userId = $this->getUserId();
        $query = "UPDATE admin SET androidToken=? WHERE id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss',$androidToken,$userId);
        return ($stmt->execute()) ? true : false;
    }

    function updateWebToken($webToken)
    {
        $userId = $this->getUserId();
        $query = "UPDATE admin SET webToken=? WHERE id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss',$webToken,$userId);
        return ($stmt->execute()) ? true : false;
    }

    // function getFirebaseToken()
    // {
    //     $position = 1;
    //     $userId = $this->getUserId();
    //     $ft = array();
    //     $query = "SELECT androidToken,webToken FROM admin WHERE position=? AND id!=?";
    //     $stmt = $this->con->prepare($query);
    //     $stmt->bind_param('ss',$position,$userId);
    //     $stmt->execute();
    //     $stmt->bind_result($androidToken,$webToken);
    //     while ($stmt->fetch()) {
    //         array_push($ft, $androidToken,$webToken);
    //     }
    //     return $ft;

    // }
    function getFirebaseToken()
    {
        $position = 1;
        $ft = array();
        $query = "SELECT androidToken,webToken FROM admin WHERE position=? ";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$position);
        $stmt->execute();
        $stmt->bind_result($androidToken,$webToken);
        while ($stmt->fetch()) {
            array_push($ft, $androidToken,$webToken);
        }
        return $ft;
    }


    function isAndroidTokenAlreadyExist($androidToken)
    {
        $query = "SELECT id FROM admin WHERE androidToken =?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$androidToken);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows()>0;
    }

    function isWebTokenAlreadyExist($webToken)
    {
        $query = "SELECT id FROM admin WHERE webToken =?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$webToken);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows()>0;
    }

    function isEmailValid($email)
    {
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
            return true;
        else
            return false;
    }

    function validateToken($token)
    {
        try 
        {
            $key = JWT_SECRET_KEY;
            $payload = JWT::decode($token,$key,['HS256']);
            $id = $payload->userId;
            if ($this->checkUserById($id)) 
            {
                $this->setUserId($payload->userId);
                return JWT_TOKEN_FINE;
            }
            return JWT_USER_NOT_FOUND;
        } 
        catch (Exception $e) 
        {
            return JWT_TOKEN_ERROR;    
        }
    }

    function encrypt($data)
    {
        $email = openssl_encrypt($data,"AES-128-ECB",null);
        $email = str_replace('/','socialcodia',$email);
        $email = str_replace('+','mufazmi',$email);
        return $email; 
    }

    function decrypt($data)
    {
        $mufazmi = str_replace('mufazmi','+',$data);
        $email = str_replace('socialcodia','/',$mufazmi);
        $email = openssl_decrypt($email,"AES-128-ECB",null);
        return $email; 
    }
}