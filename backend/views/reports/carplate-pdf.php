<?php

use yii\helpers\Html;
 ?>

 <style>
 body{
   font-size: 14px;
   font-family: "Tahoma", sans-serif;
 }
 table{
   width:100%;
   border-collapse: collapse;
 }
 .breaker{
   page-break-inside: avoid;
 }
 </style>


<h1 style="text-align:center; font-weight:bold">Carplate Report</h1>
<p><strong><?php echo date('Y-m-d') ?></strong> </p>
<p><strong><?php echo date('H:i:s') ?></strong> </p>

<!---<pre><?php print_r($dataProvider->getModels()) ?></pre>-->
<!---<pre><?php print_r($dataProvider->query->all()) ?></pre>--->

<table border=1 cellpadding="8">
  <thead>
    <tr>
      <th>Customer Name</th>
      <th>Company Name</th>
      <th>Date & Time-in</th>
      <th>Date & Time-out</th>
      <th>Invoice No</th>
      <th>Amount Total</th>
      <th>Authorized By</th>
      <th>Location</th>
      <th>Remarks</th>
    </tr>
  </thead>

  <?php if ($dataProvider->query->count()!=0 ): ?>
    <?php foreach ($dataProvider->query->all() as $key => $value): ?>
      <tr>
        <td><?php echo $value['name'] ?></td>
        <td><?php echo $value['company_name'] ?></td>
        <td><?php echo $value['come_in'] ?></td>
        <td><?php echo $value['come_out'] ?></td>
        <td><?php echo $value['invoice_no'] ?></td>
        <td><?php echo $value['grand_total'] ?></td>
        <td><?php echo $value['fullname'] ?></td>
        <td><?php echo $value['branch_name'] ?><br><?php echo $value['code'] ?></td>
        <td><?php echo nl2br($value['remarks'] ) ?></td>
      </tr>
    <?php endforeach; ?>

  <?php endif; ?>

</table>
