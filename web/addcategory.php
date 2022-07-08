<?php

    require_once dirname(__FILE__).'/include/header.php';
    require_once dirname(__FILE__).'/include/api.php';
    require_once dirname(__FILE__).'/include/navbar.php';
    require_once dirname(__FILE__).'/Migration.php';



    $m = new Migration;
    $m->makeToast();


    require_once dirname(__FILE__).'/include/sidenav.php';
    require_once dirname(__FILE__).'/include/footer.php'; 


?>