<?php 
    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';
    $message = "Change Password";

    if (isset($_POST['btnChangePassword']))
    {
        $password = $_POST['inputPassword'];
        $newPassword = $_POST['inputNewPassword'];
        $confirmPassword = $_POST['inputConfirmPassword'];

        if ($newPassword!=$confirmPassword)
        {
            $message = "New Password Not Matched";
        }
        elseif (strlen($password)<8)
            $message = "Wrong Password";
        elseif (strlen($newPassword)<8 || strlen($confirmPassword)<8)
            $message = "Password Should Be Greater Than 8 Character";
        else
        {
            $api = new Api;
            $response = $api->updatePassword($password,$newPassword);
            $message = $response->message;
        }
    }

?>


    <div class="socialcodia">
        <div class="row">
            <div class="col l12 s12 m12" >
                <div class="row">
                    <div class="col s12 l3 m4">
                         <div class="collection">
                            <a href="settings" class="collection-item ">Home</a>
                            <a href="changepassword" class="collection-item active blue">Change Password</a>
                            <a href="#!" class="collection-item">Comming Soon</a>
                            <a href="#!" class="collection-item">Comming Soon</a>
                            <a href="#!" class="collection-item">Comming Soon</a>
                            <a href="#!" class="collection-item">Comming Soon</a>
                          </div>
                    </div>
                    <div class="col s12 l9 m8">
                        <div class="card z-depth-0">
                            <div class="card-title center blue white-text" style="padding: 14px; font-weight: bold">
                                <?php echo $message; ?>
                            </div>
                            <div class="card-content">
                                <form method="POST" action="">
                                    <div class="input-field">
                                        <i class="material-icons prefix red-text"><img src="src/icons/password.png"  width="35" height="35"></i>
                                        <input type="password" required="required" name="inputPassword" id="inputPassword">
                                        <label for="inputPassword">Enter Old Password</label>
                                    </div>
                                    <div class="input-field">
                                        <i class="material-icons prefix red-text"><img src="src/icons/password.png"  width="35" height="35"></i>
                                        <input type="password" required="required" name="inputNewPassword" id="inputNewPassword">
                                        <label for="inputNewPassword">Enter New Password</label>
                                    </div>
                                    <div class="input-field">
                                        <i class="material-icons prefix red-text"><img src="src/icons/password.png"  width="35" height="35"></i>
                                        <input type="password" required="required" name="inputConfirmPassword" id="inputConfirmPassword">
                                        <label for="inputConfirmPassword">Enter Confirm Password</label>
                                    </div>
                            </div>
                                <div class="card-action blue" style="padding: 0px; margin: 0px; height: 60px;">
                                    <input class="btn blue" style="width:100%; height: 100%" value="Change Password" type="submit" name="btnChangePassword" id="btnChangePassword">
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