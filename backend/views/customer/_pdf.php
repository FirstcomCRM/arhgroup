<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<div>
	<table class="pdfTable" >
		<thead>
			<tr>
				<td class="pdf_headBg" > CUstomer Name </td>
				<td class="pdf_headBg" > Address </td>
				<td class="pdf_headBg" > Race </td>
				<td class="pdf_headBg" > Contact Number </td>
				<td class="pdf_headBg" > Expiry Date </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo ($row['type'] == 1)? $row['company_name'] : $row['fullname']; ?></td>
				<td><?php echo $row['address']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['hanphone_no']; ?></td>
				<td><?php echo date('m-d-Y', strtotime($row['member_expiry'])); ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>