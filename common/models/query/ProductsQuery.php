<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Products]].
 *
 * @see \common\models\Products
 * @method static find()
 */
class ProductsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Products[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Products|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function  published(): ProductsQuery
    {
        return $this->andWhere(['status' => 1]);
    }
    public function id($id){
        return $this->andWhere([
           'id' => $id
        ]);
    }

    public function userid($id)
    {
        return $this->andWhere([
            'id' => $id
        ]);
    }
}
