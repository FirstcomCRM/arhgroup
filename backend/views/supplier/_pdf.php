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
				<td class="pdf_headBg" > Address </td>
				<td class="pdf_headBg" > Contact Number </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr >
				<td ><?php echo $row['id']; ?></td>
				<td ><?php echo $row['supplier_code']; ?></td>
				<td ><?php echo $row['supplier_name']; ?></td>
				<td ><?php echo $row['address']; ?></td>
				<td ><?php echo $row['contact_number']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

