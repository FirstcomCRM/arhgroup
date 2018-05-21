<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\SearchUser;
use yii\web\UploadedFile;

class SettingsController extends \yii\web\Controller
{
    public function actionIndex()
    {
    	$id = Yii::$app->user->identity->id;
        $model = User::findOne($id);

        if( Yii::$app->request->post() ) {
            $uploadedFile= UploadedFile::getInstance($model,'photo');
            $fileName = "{$uploadedFile}";  // random number + file name
            
            $model->fullname = Yii::$app->request->post('User')['fullname'];
            $model->email = Yii::$app->request->post('User')['email'];
            $model->username = Yii::$app->request->post('User')['username'];
            $model->photo = $fileName;

            if( Yii::$app->request->post('newPassword') <> '' ) {
                $model->password = Yii::$app->request->post('newPassword');
                
                $model->updated_by = Yii::$app->user->identity->id;
                $currentDateTime = new \yii\db\Expression('NOW()');
                $model->updated_at = $currentDateTime;

                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                $model->generateAuthKey();
         

            }else{
                $model->password = Yii::$app->request->post('User')['password'];

                $model->updated_by = Yii::$app->user->identity->id;
                $currentDateTime = new \yii\db\Expression('NOW()');
                $model->updated_at = $currentDateTime;

                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                $model->generateAuthKey();
            
            }
            
            if( $model->save() ){
                $uploadedFile->saveAs('assets/bootstrap/photos/'.$fileName);
            }

            Yii::$app->getSession()->setFlash('success', 'Your account was successfully updated.');
            return $this->redirect(['index']);
        
        }else{
            return $this->render('index', [
                            'model' => $model,
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);
        }

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
