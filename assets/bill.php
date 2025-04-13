<?php 
if (sizeOf($_SESSION['bill']) == '0') 
{
	$display = 'display:none';
}else
$display ='';
 ?>


<div class="well well-sm" id="bill" style="top: 55px;width: 300px; height:50px;margin-left: 1050px; <?php echo $display ?>">
	
	<span class="badge"><input type="text" id="counter" value="<?php echo sizeOf($_SESSION['bill']); ?>" readonly style='width: 33px;color: black;padding:2px;border-radius: 5px;'></span>selected <a href="billing.php" ><button class="btn btn-primary btn-xs" style="width: 70px;margin-left: 20px;">View Bill</button></a>
<a href='clear.php?url=<?php echo $_SERVER['PHP_SELF']; ?>'><button class="btn btn-danger btn-xs" style="width: 60px;margin-left: 40px;">Clear</button></a>
</div>