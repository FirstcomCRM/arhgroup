<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use common\models\Branch;
 ?>

<div class="row form-container">
  <br>
  <div class="col-md-12"><!--Search-->
      <div class="form-title-container">
          <span class="form-header"><h4><i class="fa fa-car" aria-hidden="true"></i> CarPlate Report </h4></span>
      </div>
      <hr/>
  </div>

  <div class="col-md-12">
    <div class="form-search-container">
      <?php  echo $this->render('_search-carplate', ['model' => $searchModel]); ?>
    </div>
  </div>
</div>


<div class="row form-container">
  <div class="col-md-12">
    <br>
    <p class="text-right">
      <?php echo Html::a('<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download PDF', ['carplate-pdf'], ['class'=>'btn btn-warning','target'=>'_blank']) ?>
    </p>

    <?= GridView::widget([
           'dataProvider' => $dataProvider,
           'emptyCell'=>'-',
        //   'filterModel' => $searchModel,
           'columns' => [
               ['class' => 'yii\grid\SerialColumn'],
            //  'ids',
              'invoice_no',
              'name',
            //  'company_name',
              [
                'attribute'=>'company_name',
                'value'=>function($model){
                  if (!is_null($model['company_name']) ) {
                    return $model['company_name'];
                  }else{
                    return '';
                  }

                }
              ],
              'carplate',
              'date_issue',
              [
              'attribute'=>'user_id',
               'label'=>'User',
               'value'=>function($model){
                  $user = User::find()->where(['id'=>$model['user_id']])->one();
                  if (!empty($user)) {
                    return $user->fullname;
                  }else{
                    return $user = null;
                  }
                },
              ],
              [
                'attribute'=>'branch_id',
                 'label'=>'Branch',
                 'value'=>function($model){
                    $br = Branch::find()->where(['id'=>$model['branch_id']])->one();
                    if (!empty($br)) {
                      return $br->code;
                    }else{
                      return $br = null;
                    }
                  },
              ],
           ],
       ]); ?>

  </div>
</div>
