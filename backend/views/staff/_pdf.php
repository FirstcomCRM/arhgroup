<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table class="pdfTable" >
		<thead>
			<tr>
				<td class="pdf_number" > # </td>
				<td class="pdf_headBg" > Staff Code </td>
				<td class="pdf_headBg" > Fullname </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['staff_code']; ?></td>
				<td><?php echo $row['fullname']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>