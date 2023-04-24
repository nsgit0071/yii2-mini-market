<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\CartItems]].
 *
 * @see \common\models\CartItems
 */
class CartItemsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\CartItems[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\CartItems|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param int $userId
     * @return \common\models\query\CartItemsQuery
     */
    public function userId(int $userId)
    {
        return $this->andWhere(['created_by' => $userId]);
    }
    /**
     * @param int $productId
     * @return \common\models\query\CartItemsQuery
     */
    public function productId(int $productId)
    {
        return $this->andWhere(['product_id' => $productId]);
    }
}
