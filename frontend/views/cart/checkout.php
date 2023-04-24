<?php
/** @var \common\models\Orders $order */
/** @var \common\models\OrderAddresses $orderAddress */
/** @var array $cartItems */
//To quantity
/** @var int $productQuantity */
//Price
/** @var float $totalPrice */

use yii\bootstrap4\ActiveForm;


?>
<?php $form = ActiveForm::begin([
    'action' => [''],

]); ?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Address Information
            </div>

            <?= $form->field($orderAddress,'address')?>
            <?= $form->field($orderAddress,'city')?>
            <?= $form->field($orderAddress,'state')?>
            <?= $form->field($orderAddress,'country')?>
            <?= $form->field($orderAddress,'zipcode')?>

            <div class="card">
                <div class="card-header">
                    Account information
                </div>



                <?= $form->field($order, 'email') ?>

            </div>
        </div>
    </div>



    <div class="col">
      <div class="card">
          <div class="card-header">
              Order Sumary
          </div>
          <div class="card-body">
              <table class="table ">
                  <tr>
                      <td> <b> <?php echo $productQuantity?></b> Product</td>
                  </tr>
                  <tr>
                      <td>Total Price</td>
                      <td> <b><?= $totalPrice ?></b></td>
                  </tr>
              </table>

          </div>
          <p class="text-right mt-3">
          <div id="smart-button-container">
              <div style="text-align: center;">
                  <div id="paypal-button-container"></div>
              </div>
          </div>
          <script src="https://www.paypal.com/sdk/js?client-id=sb&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
          <script>
              function initPayPalButton() {
                  paypal.Buttons({
                      style: {
                          shape: 'rect',
                          color: 'gold',
                          layout: 'vertical',
                          label: 'paypal',

                      },

                      createOrder: function(data, actions) {
                          return actions.order.create({
                              purchase_units: [{"amount":{"currency_code":"USD","value":1}}]
                          });
                      },

                      onApprove: function(data, actions) {
                          return actions.order.capture().then(function(orderData) {

                              // Full available details
                              console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                              // Show a success message within this page, e.g.
                              const element = document.getElementById('paypal-button-container');
                              element.innerHTML = '';
                              element.innerHTML = '<h3>Thank you for your payment!</h3>';

                              // Or go to another URL:  actions.redirect('thank_you.html');

                          });
                      },

                      onError: function(err) {
                          console.log(err);
                      }
                  }).render('#paypal-button-container');
              }
              initPayPalButton();
          </script>

              <button class="btn btn-success" >Continue</button>
          </p>
      </div>
    </div>
</div>
    <code><?= __FILE__ ?></code>

<?php ActiveForm::end(); ?>