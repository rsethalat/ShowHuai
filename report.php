<?php
require("db-config.inc");

$text=<<<OK
<form action='report.php' method='post'>
<table>
<tr>
	<td>PRODUCT ID  : </td>
	<td><input type='text' name='id' size='4' maxlength='4' required></td>
</tr>
<tr><td colspan=2><input type='submit' value='REPORT'> <input type='reset' value='CLEAR'></td></tr>
</table>
</form>
OK;
echo $text;
if( !empty($_REQUEST['id']) ) {
	echo '<hr>';
	if(($_REQUEST['id']<0) || !is_numeric($_REQUEST['id']) ) {
		die("<span style='color:red'>Error Value!!!</span>");
	}

	$sql="SELECT product.name,product.price,sale.* FROM sale,product WHERE sale.ID='{$_REQUEST['id']}' AND sale.ID=product.ID";

	if (($result = mysqli_query($cid, $sql)) && mysqli_affected_rows($cid)) {
		$row=mysqli_fetch_assoc($result);
		echo "=== REPORT SALE ===<br>";
		echo "Product ID : {$row['id']}<br>";
		echo "Product Name : {$row['name']}<br>";
		echo "<hr>";
		$sum_qty=0; $sum_amount=0;
		do{
			echo $row['datetime'].' Qty='.number_format($row['qty']).' Amount='.number_format($row['amount'],2).' ('.$row['payment'].')';
			echo '<br>';
			$sum_qty+=$row['qty'];
			$sum_amount+=$row['amount'];
		} while($row=mysqli_fetch_array($result));
		echo "<hr>Total Qty=".number_format($sum_qty)." Amount=".number_format($sum_amount,2);
	} else   
		echo "Not Found: Product ID ({$_REQUEST['id']}).";

	mysqli_close($cid);
}
	echo '<hr><a href="./"><input type="button" value="HOME"></a>';
?>
