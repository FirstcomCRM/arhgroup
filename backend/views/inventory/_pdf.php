<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table class="pdfTable" >
		<thead>
			<tr >
				<td class="pdf_number" > # </td>
				<td class="pdf_headBg" > Supplier Code </td>
				<td class="pdf_headBg" > Supplier Name </td>
				<td class="pdf_headBg" > Product Code </td>
				<td class="pdf_headBg" > Product Name </td>
				<td class="pdf_headBg" > Unit of Measure </td>
				<td class="pdf_headBg" > Old Quantity </td>
				<td class="pdf_headBg" > New Quantity </td>
				<td class="pdf_headBg" > Invoice No. </td>
				<td class="pdf_headBg" > Inventory Type </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr >
				<td ><?php echo $row['id']; ?></td>
				<td ><?php echo $row['supplier_code']; ?></td>
				<td ><?php echo $row['supplier_name']; ?></td>
				<td ><?php echo $row['product_code']; ?></td>
				<td ><?php echo $row['product_name']; ?></td>
				<td ><?php echo $row['unit_of_measure']; ?></td>
				<td ><?php echo $row['old_quantity']; ?></td>
				<td ><?php echo $row['new_quantity']; ?></td>
				<td ><?php echo ($row['invoice_no'])? $row['invoice_no']: 'N/A'; ?></td>
				<td >
					<?php 
						if($row['new_quantity'] == 1){ 
							echo 'Stock-In';

						}elseif($row['new_quantity'] == 2){
							echo 'Stock-Out';

						}else{
							echo 'Stock-Adjustment';

						}
					?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

