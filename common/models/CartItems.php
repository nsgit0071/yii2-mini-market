<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cart_items".
 *
 * @property int $id
 * @property int $product_id
 * @property int $quantity
 * @property int|null $created_by
 *
 * @property User $createdBy
 * @property Products $product
 */
class CartItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart_items';
    }

    public static function getItemsForUser($currUserId)
    {
        return   CartItems::findBySql("
SELECT
    c.product_id as id,
    p.image,
   p.name,
   p.price,
   c.quantity,
   p.price * c.quantity as total_price
FROM cart_items c LEFT JOIN products p on p.id = c.product_id
WHERE c.created_by = :userId",
            ['userId' => $currUserId])
            ->asArray()
            ->all();

    }

    public static function getTotalQuantityForUser($currUserId)
    {
        if(isGuest()){
            $cartItems = \Yii::$app->session->get(CartItems::SESSION_KEY, []);
       $sum = 0;
       foreach ($cartItems as $cartItem){
           $sum += $cartItem['quantity'];
       }
        }
       else{
           $sum = CartItems::findBySql("
           SELECT SUM(quantity) FROM cart_items WHERE created_by = :userId", ['userId' => $currUserId ]
           )->scalar();
return $sum;
        }
    }
    public static function getTotalPriceForUser($currUserId)
    {
        if(isGuest()){
            $cartItems = \Yii::$app->session->get(CartItems::SESSION_KEY, []);
            $sum = 0;
            foreach ($cartItems as $cartItem){
                $sum += $cartItem['quantity'] * $cartItem['price'];
            }
        }
        else{
            $sum = CartItems::findBySql("
           SELECT SUM(c.quantity * p.price) 
FROM cart_items c
LEFT JOIN products p on p.id = c.product_id
WHERE c.created_by = :userId", ['userId' => $currUserId ]
            )->scalar();

            return $sum;
        }
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity'], 'required'],
            [['product_id', 'quantity', 'created_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'quantity' => 'Quantity',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\ProductsQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\CartItemsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\CartItemsQuery(get_called_class());
    }
}
