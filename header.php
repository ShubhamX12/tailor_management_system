<?php
$_POST = array_map('strip_tags', $_POST);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="images/favicon.png" type="image/png">

  <title>TAILOR MANAGEMENT SYSTEM</title>

  <link href="css/style.default.css" rel="stylesheet"> 


 <link rel="stylesheet" href="css/bootstrap-timepicker.min.css" />
  <link rel="stylesheet" href="css/jquery.tagsinput.css" />
  <link rel="stylesheet" href="css/colorpicker.css" />
  <link rel="stylesheet" href="css/dropzone.css" />
  <script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery-migrate-1.2.1.min.js"></script>
<script src="js/jquery-ui-1.10.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/toggles.min.js"></script>
<script src="js/retina.min.js"></script>
<script src="js/jquery.cookies.js"></script>
<!------------------------Chat JS Files ------------------------------------------------------>
<script type="text/javascript" src="js/Chart.js"></script>
<script type="text/javascript" src="js/Chart.min.js"></script>
 

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
  <![endif]-->

    

 <script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>

 <script>
$(function() {
$( "#datepicker1" ).datepicker();
});
</script>

 <script>
$(function() {
$( "#datepicker2" ).datepicker();
});
</script>
<style>
.page-header {
    border-bottom: 0px solid #FFF;
	color: #1D2939;
	
}
h1 {
  text-transform: uppercase;
}
.icon{
  border:none;
  border-radius:20px;
}
</style>

 
</head>

<body>



<!-- Preloader -->
<div id="preloader">
    <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
</div>
<?php   
		$pdo->exec("set names utf8");
		$dd = $pdo->query("SELECT currency, sitename FROM general_setting WHERE id='1'");
		$dd = $dd->fetch(PDO::FETCH_ASSOC);
		$currency = $dd['currency'];
 ?>
<section style="background-color:black">

  <div class="leftpanel">

    <div class="logopanel">
        <h1>TAILOR SOFTWARE</h1>
    </div><!-- logopanel -->

    <div class="leftpanelinner">

        <!-- This is only visible to small devices -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg" id="leftpanel2" style="background-color:black">

            <h5 class="sidebartitle actitle" style="background-color:black">Account</h5>
            <ul class="nav nav-pills nav-stacked nav-bracket mb30">
              <li><a href="changepass"><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>
              <li><a href="signout"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
            </ul>
        </div>
 
      <ul class="nav nav-pills  nav-stacked nav-bracket" id="slide1">
	  
        <li><a href="home" class="icon"><i class="fa fa-home"></i> <span class="icon">Dashboard</span></a></li>
        
    	<li><a href="orderadd" class="icon"><i class="fa fa-shopping-cart"></i><span>Add Order</span></a></li>
        <li><a href="orderlist" class="icon"><i class="fa fa-shopping-cart"></i><span>View/Edit Orders</span></a></li>
        
        <li><a href="customeradd"  class="icon"><i class="fa fa-user"></i><span>Add Customer</span></a></li>
        <li><a href="customerview" class="icon"><i class="fa fa-user"></i><span>View/Edit Customer</span></a></li>
        <li><a href="sms" class="icon"><i class="fa fa-envelope-o"></i><span>Messsage</span></a></li>
	  
        <li class="nav-parent"><a href="#"><i class="fa fa-th-list"></i> <span>Staff Management</span></a>
          <ul class="children">
            <li><a href="staffadd" class="icon"><i class="fa fa-caret-right"></i>Add Staff</a></li>
            <li><a href="staffview" class="icon"><i class="fa fa-caret-right"></i>View/Edit Staff</a></li>
            <li><a href="paysalary" class="icon"><i class="fa fa-caret-right"></i> Pay Salary</a></li>
            <li><a href="staffcatadd" class="icon"><i class="fa fa-caret-right"></i>Add Designation</a></li>
            <li><a href="staffcatview" class="icon"><i class="fa fa-caret-right"></i>View/Edit Designations</a></li>
          </ul>
        </li>
        
        <li class="nav-parent"><a href="#"><i class="fa fa-th-list"></i> <span>Income Management</span></a>
          <ul class="children">
          	<li><a href="incadd"><i class="fa fa-caret-right"></i>Add Income</a></li>
            <li><a href="incview"><i class="fa fa-caret-right"></i>View/Edit Income</a></li>
            <li><a href="inccatadd"><i class="fa fa-caret-right"></i>Add Income Category</a></li>
            <li><a href="inccatview"><i class="fa fa-caret-right"></i>View/Edit Income Category</a></li>
          </ul>
        </li>
        
        <li class="nav-parent"><a href="#"><i class="fa fa-th-list"></i> <span>Measurement Settings</span></a>
          <ul class="children">
            <li><a href="typeadd"><i class="fa fa-caret-right"></i>Add Cloth Type</a></li>
            <li><a href="typeview"><i class="fa fa-caret-right"></i>View/Edit Cloth Type</a></li>
            <li><a href="partadd"><i class="fa fa-caret-right"></i>Set Mesurement Parts</a></li>
            <li><a href="partview"><i class="fa fa-caret-right"></i>View/Edit Mesurement Parts</a></li>
          </ul>
        </li>
        
        <li class="nav-parent"><a href="#"><i class="fa fa-cog"></i> <span> General Setting</span></a>
          <ul  class="children">  
            <li><a href="document"><i class="fa fa-caret-right"></i> Shop document</a></li>
			 
          </ul>
        </li>




      </ul>

      

    </div><!-- leftpanelinner -->
  </div><!-- leftpanel -->

  <div class="mainpanel">

    <div class="headerbar">

      <a class="menutoggle"><i class="fa fa-bars"></i></a>

        
      <div class="header-right">
        <ul class="headermenu">
          <li>
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">

<?php
echo "<img src='images/user.png' alt='' />";
echo " $user";
?>
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
              <li><a href="changepass"><i class="fa fa-cog"></i> <span>Account Settings</span></a></li>
              <li><a href="signout"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
              </ul>
            </div>
          </li>

        </ul>
      </div><!-- header-right -->

    </div><!-- headerbar -->


    <div class="contentpanel">