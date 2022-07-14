<?php require_once dirname(__FILE__).'/api.php';
session_start();
if(!isset($_SESSION['id']))
  header("LOCATION:login"); ?>
<!DOCTYPE html>
<html>
<head>
  <!--Import Google Icon Font-->
  <link href="css/icons.css" rel="stylesheet">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="css/materialize.min.css">
  <link rel="stylesheet" href="css/toast.css">
  <link href="https://fonts.googleapis.com/css?family=Rajdhani:400,500,600,700&display=swap" rel="stylesheet">
  <link rel="icon" href="src/icons/home.png" type="image/gif" sizes="16x16">
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css"> -->
  <link rel="stylesheet" type="text/css" href="css/datatables.min.css">
  <link rel="stylesheet" type="text/css" href="css/materialize.min.css">
  <link rel="stylesheet" type="text/css" href="css/select2.css">
  <link rel="stylesheet" href="css/socialcodia.css">
  <link rel="stylesheet" href="css/jquery.tablesorter.pager.min.css">
  <!-- SELECT 2 CSS -->
  <link href="css/select2.min.css" rel="stylesheet"/>
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <!--------------------------------------FIREBASE START-------------------------------------------->
  <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-analytics.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-messaging.js"></script>
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/firebase.js"></script>
</script>
<!----------------------------------------FIREBASE END------------------------------------------>
</head>  
<body class="" style="font-family: Rajdhani,sans-serif; background-color: #f5f5f7; word-break: break-all;">