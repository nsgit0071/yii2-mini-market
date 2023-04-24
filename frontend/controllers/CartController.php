<?php


namespace frontend\controllers;


use common\models\CartItems;
use common\models\Order;
use common\models\OrderAddress;
use common\models\OrderAddresses;
use common\models\Orders;
use common\models\Products;
use common\models\query\CartItemsQuery;
use common\models\query\ProductsQuery;
use Yii as YiiAlias;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class  CartController extends \frontend\base\Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]

            ]
        ];
    }

    public function actionIndex()
    {
        if (\Yii::$app->user->isGuest) {
            //Guest the items from session
        } else {
           $cartItems = CartItems::getItemsForUser(currUserId());
        }

        return $this->render('index', ['items' => $cartItems]);
    }

    /**
     * @param $userId
     * @return \common\models\query\CartItemsQuery
     */
    public function userId($userId)
    {
        return $this->andWhere(['created_by' => $userId]);
    }

    public function actionAdd()
    {
        $id = \Yii::$app->request->post('id');
        $product = Products::find()->id($id)->published($id)->one();
        if (!$product) {
            throw new NotFoundHttpException("Productda xatolik");
        }
        if (\Yii::$app->user->isGuest) {
            // todo Save in session
        } else {
            $userId = \Yii::$app->user->id;
            $cartItem = CartItems::find()->userId($userId)->productId($id)->one();
            if ($cartItem) {
                $cartItem->quantity++;
            } else {
                $cartItem = new CartItems();
                $cartItem->product_id = $id;
                $cartItem->created_by = \Yii::$app->user->id;
                $cartItem->quantity = 1;
            }
            if ($cartItem->save()) {
                return [
                    'success' => true
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => $cartItem->errors
                ];
            }

        }
    }

    public function actionDelete($id)
    {

        if (isGuest()) {
            $cartItems = \Yii::$app->session->get(CartItems::SEESSION_KEY, []);
            foreach ($cartItem['id'] as $i => $cartItem) {
                if ($cartItem['id'] == $id) {
                    array_splice($cartItem, $i, 1);
                    break;
                }
            }
            \Yii::$app->session->set(CartItems::SEESSION_KEY, $cartItems);
        } else {
            CartItems::deleteAll(['product_id' => $id, 'created_by' => currUserId()]);
        }
        return $this->redirect(['index']);
    }

    public function actionChangeQuantity()
    {
        $id = \Yii::$app->request->post('id');
        $product = Products::find()->id($id)->published($id)->one();
        if (!$product) {
            throw new NotFoundHttpException("Productda xatolik");
        }
        $quantity = \Yii::$app->request->post('quantity');
        if (isGuest()) {
            $cartItems = \Yii::$app->session->get(CartItems::SESSION_KEY, []);
            foreach ($cartItems as &$cartItem) {
                if ($cartItem['id'] === $id) {
                    $cartItem['quantity'] = $quantity;
                    break;
                }
            }
            \Yii::$app->session->set(CartItems::SESSION_KEY, $cartItems);
        } else {
            $cartItem = CartItems::find()->userId(currUserId())->productId($id)->one();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
            }
        }
    }
public function actionCheckout()
{
    /** @var common\models\User $user */
    $user = \Yii::$app->user->identity;
    $userAddress = $user->getAddress();
    $order = new Orders();
    $orderAddress = new OrderAddresses();
    if (!isGuest()){

        $order->email = $user->email;
        $order->status = Orders::STATUS_DRAFT;

        $orderAddress->address = $userAddress->address;
        $orderAddress->city = $userAddress->city;
        $orderAddress->state = $userAddress->state;
        $orderAddress->country = $userAddress->country;
        $orderAddress->zipcode = $userAddress->zipcode;
        $cartItems = CartItems::getItemsForUser(currUserId());
    }
    else{
        $cartItems = \Yii::$app->session->set(CartItems::SESSION_KEY,[]);
    }
    $productQuantity = CartItems::getTotalQuantityForUser(currUserId());
    $totalPrice = CartItems::getTotalPriceForUser(currUserId());
    return $this->render('checkout' ,[
        'order' => $order,
        'orderAddress' => $orderAddress,
        'cartItems' => $cartItems,
        'productQuantity' => $productQuantity,
        'totalPrice' => $totalPrice,
        ]);
}
}
