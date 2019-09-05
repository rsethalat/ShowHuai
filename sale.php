<?php
require("db-config.inc");

$text=<<<OK
<form action='sale.php' method='post'>
<table>
<tr>
	<td>PRODUCT ID  : </td>
	<td><input type='text' name='id' size='4' maxlength='4' required></td>
</tr>
<tr>
	<td>QUANTITY : </td>
	<td><input type='number' name='qty' placeholder='0' min='0' size='5' required	></td>
</tr>
<tr>
	<td>PAYMENT : </td>
	<td><select name='payment' required>
		<option value='CASH'>CASH</option>
		<option value='VISA'>VISA</option>
		<option value='MC'>MASTERCARD</option>
	</td>
</tr>
<tr><td colspan=2><input type='submit' value='RECORD'> <input type='reset' value='CLEAR'></td></tr>
</table>
</form>
OK;
echo $text;
if( !empty($_REQUEST['id']) && !empty($_REQUEST['qty']) ) {
	echo '<hr>';
	if(($_REQUEST['id']<0) || ($_REQUEST['qty']<0) || !is_numeric($_REQUEST['id']) || !is_numeric($_REQUEST['qty']) ) {
		die("<span style='color:red'>Error Value!!!</span>");
	}

	$sql="SELECT * FROM product WHERE id='{$_REQUEST['id']}'";
	if (($result = mysqli_query($cid, $sql)) && mysqli_affected_rows($cid)) {
		$row=mysqli_fetch_array($result);
		$total=strval($row['price'])*$_REQUEST['qty'];
		if($total<50 && $_REQUEST['payment']!='CASH')
			die("<span style='color:red'>Invalid Payment Method!!!</span>");
		$datetime=date("Y-m-d H:i:s");
		$sql="INSERT INTO sale(datetime,id,qty,amount,payment)
			VALUES ('{$datetime}','{$_REQUEST['id']}',{$_REQUEST['qty']},{$total},'{$_REQUEST['payment']}')";
		$result = mysqli_query($cid, $sql);

		$new_qty=intval($row['qty'])-$_REQUEST['qty'];
		$sql="UPDATE product SET qty={$new_qty} WHERE id='{$_REQUEST['id']}'";
		$result = mysqli_query($cid, $sql);	
		if($result && mysqli_affected_rows($cid)>0)	{
			echo "=== STOCK ===<br>";
			echo "Product ID : {$row['id']}<br>";
			echo "Product Name : {$row['name']}<br>";
			echo "Price : ".number_format($row['price'],2)."<br>";
			echo "Quantity : {$_REQUEST['qty']}<br>";
			echo "Total Price : ".number_format($total,2)."<br>";		
			echo "<hr>";
			echo "Done: Recording sale transaction.";
		} else
			echo "Failed: " . mysqli_error($cid);
	} else   
		echo "Not Found: Product ID ({$_REQUEST['id']}).";

	mysqli_close($cid);
}
	echo '<hr><a href="./"><input type="button" value="HOME"></a>';
?>
