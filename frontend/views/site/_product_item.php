<?php
/** @var \common\models\Products $model */
?>


    <!-- Blog post-->
    <div class="card mb-4" style="width:400px;margin:0 60px;" >
        <a href="#"><img style="height: 300px; width: 100%;"  class="card-img-top" src="<?php echo $model->getImageUrl() ?>" alt="..."></a>
        <div class="card-body">
            <div class="small text-muted">January 1, 2021</div>
            <h2 class="card-title h4"><?php echo $model->name   ?></h2>
            <div class="card-text">
                <?php echo \yii\helpers\StringHelper::truncate(strip_tags($model->description),100)?>
            </div>
            <a class="btn btn-primary btn-add-to-cart" href="<?php echo \yii\helpers\Url::to(['/cart/add'])?>">Add to Cart  →</a>
        </div>
    </div>


