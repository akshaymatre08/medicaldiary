<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';
    $message = "Add Admin";

    $api = new API;

    if (isset($_POST['btnAddAdmin'])) 
    {
        $adminName = $_POST['adminName'];
        $adminEmail = $_POST['adminEmail'];
        $adminPassword = $_POST['adminPassword'];
        $adminPosition = $_POST['adminPosition'];
        $adminImage = $_FILES['adminImage'];
        $result = $api->addAdmin($adminName,$adminEmail,$adminPassword,$adminPosition,$adminImage);
        $message = $result->message;
    }

?>

        <div class="socialcodia">
        <div class="row">
            <div class="col l10 offset-l1 s12 m12" style="padding: 30px 0px 30px 10px;">
                <div class="card z-depth-0" style="border: 10px solid #2196F3; padding: 0px; margin: 0px">
                   <h5 style="font-weight: bold; padding: 15px; margin: 0px;" class="center blue white-text">
                        <?php
                            if (isset($message) && !empty($message))
                                echo $message;
                        ?>
                    </h5>
                    <div class="card-content">           
                        <div class="row">
                              <form id="formAddAdmin" method="post" enctype="multipart/form-data">
                                <div class="col s12 center">
                                    <input id="adminImage" type="file" onchange="previewAdminImage(this);" name="adminImage" class="hide">
                                    <label for="adminImage"><img src="src/img/user.png" style="height: 160px; width: 160px; object-fit: cover; border: 2px solid blue; cursor: pointer;" id="adminImagePreview" class="responsive-img circle" width="110" alt=""></label>
                                </div>
                                <div class="input-field col s12 l12 m12">
                                    <i class="material-icons prefix">person</i>
                                    <input required="required"  id="adminName" type="text" name="adminName" class="validate">
                                    <label for="adminName">Enter Admin Name</label>
                                </div>
                                <div class="input-field col s12 l12 m6">
                                    <i class="material-icons prefix">email</i>
                                    <input  id="adminEmail" type="email"  name="adminEmail" class="validate">
                                    <label for="adminEmail">Enter Email Address</label>
                                </div>
                                <div class="input-field col s12 l6 m6">
                                    <i class="material-icons prefix">lock</i>
                                    <input  id="adminPassword" type="password"  name="adminPassword" class="validate">
                                    <label for="adminPassword">Enter Password</label>
                                </div>
                                  <div class="input-field col s12 m6 l6">
                                      <select name="adminPosition">
                                        <option value="" disabled selected>Select Position</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Manager</option>
                                        <option value="3">Helper</option>
                                      </select>
                                  </div>
                                <div class="input-field center col s12 l12 m6">
                                    <button type="submit" class="btn blue btn-large" style="width: 50%; min" name="btnAddAdmin" id="btnAddAdmin">Add Admin</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php require_once dirname(__FILE__).'/include/sidenav.php'; ?>
<?php require_once dirname(__FILE__).'/include/footer.php'; ?>