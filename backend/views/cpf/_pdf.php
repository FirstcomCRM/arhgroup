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
				<td class="pdf_headBg" > Age-From </td>
				<td class="pdf_headBg" > Age-To </td>
				<td class="pdf_headBg" > Employee Cpf(% of wage) </td>
				<td class="pdf_headBg" > Employer Cpf(% of wage) </td>
				<td class="pdf_headBg" > Description </td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($result as $row ){ ?>
			<tr>
				<td><?php echo $row['id']; ?></td>
				<td><?php echo $row['from_age']; ?></td>
				<td><?php echo $row['to_age']; ?></td>
				<td><?php echo $row['employee_cpf']; ?></td>
				<td><?php echo $row['employer_cpf']; ?></td>
				<td><?php echo $row['description']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>