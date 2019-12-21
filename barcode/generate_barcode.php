<?php
if(isset($_POST['generate_barcode']))
{
 $text=$_POST['barcode_text'];
 echo "<img alt='testing' src='barcode.php?codetype=Code128&size=50&text=".$text. "&print=true' style='max-width: 150px;'/>";
// echo '<img alt="testing" src="barcode.php?text=testing&print=true" />';
}
?>