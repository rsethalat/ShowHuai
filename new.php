<?php
require("db-config.inc");

$text=<<<OK
<form action='new.php' method='post'>
<table>
<tr>
	<td>PRODUCT ID  : </td>
	<td><input type='text' name='id' size='4' maxlength='4' required></td>
</tr>
<tr>
	<td>NAME : </td>
	<td><input type='text' name='name' size='50' maxlength='50' required></td>
</tr>
<tr>
	<td>PRICE : </td>
	<td><input type='number' name='price' placeholder='0.00' min='0' step='0.01' size='5' required	></td>
</tr>
<tr><td colspan=2><input type='submit' value='ADD NEW PRODUCT'> <input type='reset' value='CLEAR'></td></tr>
</table>
</form>
OK;
echo $text;
if( !empty($_REQUEST['id']) && !empty($_REQUEST['name']) && !empty($_REQUEST['price']) ) {
	echo '<hr>';
	if(($_REQUEST['id']<0) || ($_REQUEST['price']<0) || !is_numeric($_REQUEST['id']) || !is_numeric($_REQUEST['price']) ) {
		die("<span style='color:red'>Error Value!!!</span>");
	}

	$sql="INSERT INTO product(id, name, price) VALUES ('{$_REQUEST['id']}', '{$_REQUEST['name']}', {$_REQUEST['price']})";
	$result = mysqli_query($cid, $sql );
	if($result)
		echo "Done: Adding new product.";
	else
		echo "Failed: " . mysqli_error($cid);
	mysqli_close($cid);
}
	echo '<hr><a href="./"><input type="button" value="HOME"></a>';
?>
