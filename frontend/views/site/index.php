<?php

/* @var $this yii\web\View */
/** @var \yii\data\ActiveDataProvider $dataProvider */

$this->title = 'ns';
?>

<div class="site-index">

    <div class="row">
        <?php echo \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'layout'=> '{summary}<div class="row">{items}</div>{pager}',
            'itemView' => '_product_item',
            'options' => [
                    'class' => 'row'
],
            'itemOptions' =>[
                    'class' => 'col-lg-6 col-md-6 mb-4 product-item',
            ],
                'pager' => [
                        'class' => \yii\bootstrap4\LinkPager::class

],

        ])?>

    </div>
</div>