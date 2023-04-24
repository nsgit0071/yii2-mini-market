<?php
/** @var \common\models\UserAddresses $userAddress */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>

<?php if(isset($success) && $success):?>
    <div class="alert alert-success">
        Your address was successfully updated
    </div>
<?php endif;?>

<?php $adressForm = ActiveForm::begin([
        'action' => ['/profile/update-address'],
        'options' => [
            'data-pjax' => 1
        ]
    ]
); ?>
<?= $adressForm->field($userAddress,'address')?>
<?= $adressForm->field($userAddress,'city')?>
<?= $adressForm->field($userAddress,'state')?>
<?= $adressForm->field($userAddress,'country')?>
<?= $adressForm->field($userAddress,'zipcode')?>

<div class="form-group">
    <?= Html::submitButton('Update', ['class' => 'btn btn-primary',]) ?>
</div>
<?php ActiveForm::end(); ?>

