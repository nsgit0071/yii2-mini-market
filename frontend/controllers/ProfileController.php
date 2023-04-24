<?php


namespace frontend\controllers;


use common\models\UserAddresses;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class ProfileController extends \frontend\base\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','update-address','update-account'],
                'rules' => [
                    [
                        'actions' => ['index','update-address','update-account'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
    ]
                ];
    }
    public function actionIndex(){
        /** @var \common\models\User $user */
        $user = Yii::$app->user->identity;
        $userAdress = new UserAddresses();
        $userAddress = $user->getAddress();
        return $this->render('index',[
            'user' => $user,
            'userAdress' => $userAddress
        ]);
    }
    public function actionUpdateAddress()
    {
        $user = Yii::$app->user->identity;
        $userAddress = $user->getAddress();
        $success = false;
        if($userAddress->load(Yii::$app->request->post()) && $userAddress->save()){
            $success = true;
        }
        return $this->renderAjax('user_address' , [
            'userAddress' => $userAddress,
            'success' => $success
        ]);
    }
    public function actionUpdateAccount()
    {
        if(!Yii::$app->request->isAjax){
            throw new ForbiddenHttpException("Siz xatolik qildingiz");
        }
        $user = Yii::$app->user->identity;
        $success = false;
        if ($user->load(Yii::$app->request->post()) && $user->save()){
            $success = true;
        }
        return $this->renderAjax('user_account' , [
            'user' => $user,
            'success' => $success
        ]);

    }
}