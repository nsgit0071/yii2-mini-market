<?php
/** @var array $items */
?>
<div class="card">
    <div class="card-header">
    Sizning savatingiz
    </div>
</div>
<div class="card-body p-0">
    <table>
        <thead>
        <tr>
            <th>Product</th>
            <th>Image</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($items as $item):?>
            <tr data-id="<?= $item['id']?>" data-url="<?= \yii\helpers\Url::to(['/cart/change-quantity'])?>">
                <td><?= $item['name']?></td>
                <td><img src="<?php echo Yii::$app->params['backendUrl'].'/uploads/'.$item['image']; ?>" style="width: 50px" alt=""> </td>
                <td><?= $item['price']?></td>
                <td><input type="number" value="<?= $item['quantity']?>" class="form-control item-quantity" style="width:60px;"> </td>
                <td><?= $item['total_price']?></td>
                <td class="delete">
                    <?php echo \yii\helpers\Html::a('Delete', ['/cart/delete','id'=>$item['id']],[
                        'class' => 'btn btn-outline-danger  btn-sm',
                        'data-method' => 'post',
                        'data-confirm' => 'karzinkadan chiqarishga ishonchingiz komolmi'
                    ])?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <div class=" card-body text-right">
        <a href="<?php echo \yii\helpers\Url::to(['/cart/checkout'])?>" class="btn-primary btn btn-primary active btn-group">Checkout</a>

    </div>
</div>


<style type="text/css">
    table{
        width: 900px;
    }
</style>
