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
				<td class="pdf_headBg" > Service Category </td>
				<td class="pdf_headBg" > Service Name </td>
				<td class="pdf_headBg" > Description </td>
				<td class="pdf_headBg" > Price </td>
				<td class="pdf_headBg" > Date Created </td>
				<td class="pdf_headBg" > Status </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['service_name']; ?></td>
				<td><?php echo $row['description']; ?></td>
				<td>$ <?php echo number_format($row['default_price'],2); ?></td>
				<td><?php echo date('m-d-Y', strtotime($row['created_at']) ); ?></td>
				<td><?php echo ( $row['status'] == 1 ) ? 'Active' : 'Inactive'; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>