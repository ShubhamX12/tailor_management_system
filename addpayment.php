<?php
require_once('function.php');
dbconnect();
session_start();

if (!is_user()) {
	redirect('index.php');
}

?>

		

<?php
 $user = $_SESSION['username'];
$usid = $pdo->query("SELECT id FROM users WHERE username='".$user."'");
$usid = $usid->fetch(PDO::FETCH_ASSOC);
 $uid = $usid['id'];
 include ('header.php');
 ?>



 
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add Payment</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                
                <div class="col-md-10 col-md-offset-1">
				
				
	

		<?php
if(isset($_GET["id"])){
$order = $_GET["id"];
}
if($_POST)
{

$inccat = $_POST["inccat"];
$desc = $_POST["desc"];
$date = $_POST["date"];
$amount = $_POST["amount"];


///////////////////////-------------------->> Catid  ki 0??
$error = 0;

 if($inccat==0)
      {
$err1=1;
}
 


if(isset($err1))
 $error = $err1;;


if (!isset($error) || $error == 0){

$res = $pdo->exec("INSERT INTO income SET inccat='".$inccat."', description='".$desc."', date='".$date."', amount='".$amount."'");
$res2 = $pdo->exec("UPDATE `order` SET paid = paid + '$amount' WHERE `id` = '$order'");
if($res){

echo "<div class='alert alert-success alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	

Payment Received Successfully!

</div>
<meta http-equiv='refresh' content='2; url=orderlist' />
";

}else{
	echo "<div class='alert alert-danger alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	

Some Problem Occurs, Please Try Again. 

</div>";
}
} else {
	
	
if (!isset($err1) || $err1 == 1){
echo "<div class='alert alert-danger alert-dismissable'>
<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>	

Please select a Category!!!!

</div>";
}	
}



} 
	?>
		


	 <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>		
				
				
				
				
				
			<form action="" method="post">
		        
			<div class="card" style="width:500px;height:600px;background-color:white;padding: 40px;border-radius:10px;box-shadow: 2px 4px 14px 12px rgba(0,0,0,0.12);
-webkit-box-shadow: 2px 4px 14px 12px rgba(0,0,0,0.12);
-moz-box-shadow: 2px 4px 14px 12px rgba(0,0,0,0.12);">     
                <div class="form-group">
					
					<label>Amount</label><br/>
					<i class="fa fa-rupee"></i> <input id="amount" type="text" name="amount" style="width:100%; height: 40px;" /><br/><br/>
				</div>
				<div class="form-group">
					
					<label>Date</label><br/>
                 	<input type="date"style="width:100%"  name="date" style="width:200px; height: 40px;" value="<?php echo date("Y-m-d"); ?>" /><br/><br/>
				</div>

				<div class="form-group">
					
					<label>Description</label><br/>
                 	<input type="text" style="width:100%" value="Payment for Order: <?php echo $order; ?>" name="desc" style="width:200px; height: 40px;" /><br/><br/>
				</div>
				
				<div class="form-group">
					
					<label>Payment Category</label>
					
					<select name="inccat" class="form-control" style="width:100%">
					<?php

					$ddaa = $pdo->query("SELECT id, title FROM inccat ORDER BY id");
						while ($data = $ddaa->fetch(PDO::FETCH_ASSOC))
						{									
					 echo "<option value='$data[id]'>$data[title]</option>";
						}
					?>
										
										</select><br/>

					</div>
					<input type="submit" style="width:100%" class="btn btn-lg btn-success btn-block" value="ADD">
			    	</form>
                </div>
						
						
						
						
						
				
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
	    



<script src="js/bootstrap-timepicker.min.js"></script>


<script>
jQuery(document).ready(function(){
    
  
  jQuery("#ssn").mask("999-99-9999");
  
  // Time Picker
  jQuery('#timepicker').timepicker({defaultTIme: false});
  jQuery('#timepicker2').timepicker({showMeridian: false});
  jQuery('#timepicker3').timepicker({minuteStep: 15});

  
});
</script>







<?php
 include ('footer.php');
 ?>