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
				<td class="pdf_headBg" > Payment-Type Name </td>
				<td class="pdf_headBg" > Payment-Type Description </td>
				<td class="pdf_headBg" > Date Created </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr >
				<td ><?php echo $row['id']; ?></td>
				<td ><?php echo $row['name']; ?></td>
				<td ><?php echo $row['description']; ?></td>
				<td ><?php echo date('M-d-Y', strtotime($row['created_at'])); ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

