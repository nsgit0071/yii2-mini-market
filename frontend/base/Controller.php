<?php


namespace frontend\base;



use common\models\CartItems;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->view->params['cartItemCount'] = CartItems::findBySql("
        SELECT SUM(quantity) FROM cart_items WHERE created_by = :userId",
            ['userId' => \Yii::$app->user->id])->scalar();
        return parent::beforeAction($action);
    }
}







