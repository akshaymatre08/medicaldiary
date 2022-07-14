<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';
?>


    <div class="socialcodia">
        <div class="row">
            <div class="col l12 s12 m12" >
                <div class="row">
                    <div class="col s12 l3 m4">
                         <div class="collection">
                            <a href="settings" class="collection-item active blue">Home</a>
                            <a href="changepassword" class="collection-item ">Change Password</a>
                             <a href="#!" class="collection-item">Comming Soon</a>
                            <a href="#!" class="collection-item">Comming Soon</a>
                            <a href="#!" class="collection-item">Comming Soon</a>
                            <a href="#!" class="collection-item">Comming Soon</a>
                          </div>
                    </div>
                    <div class="col s12 l9 m8" >
                        <div class="card z-depth-0" style="margin:20px; padding: 0px;">
                            <div class="card-content" style="padding: 0px; margin: 0px;">
                                <p class="center card-title white-text blue" style="font-weight:bold; padding: 10px">Update Product Notice Count</p>
                                <div style="padding: 30px 30px 0px 30px;">
                                    <span class="">Here you can pass the notice product quantity, when the quantity is less or equal to entered value. The product will show in notice tab. The default notice count is 6. You can change it any time.</span>
                                    <div class="input-field" style="margin-top: 10px">
                                        <input type="number" style="text-transform:uppercase" name="productNoticeCount" id="productNoticeCount" placeholder="Default Notice Quantity 6">
                                        <label for="productNoticeCount">Enter Product Notice Quantity</label>
                                    </div>
                                </div>
                                <div class="card-action blue" style="padding: 0px; margin: 0px; height:55px;">
                                    <input class="btn blue" style="width:100%; height: 100%" value="Update Product Notice Count" type="submit" name="btnUpdateProductNoticeCount" onclick="alertUpdateProductNoticeCount()" id="btnUpdateProductNoticeCount">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>