<?php
use yii\helpers\Html;
use common\models\Payment;

/* @var $this yii\web\View */
/* @var $form frontend\models\Payment */

date_default_timezone_set('America/New_York');
?>

Thank you, <?= Html::encode($model->full_name) ?>.  We appreciate your payment.<br><?= "\n" ?>
For your records, this is your receipt:<br><?= "\n" ?>
<hr>
<h1>Payment</h1>
<h3>Payee / Billing Address</h3>
<table border="0" cellspacing="5" cellpadding="5"><?= "\n" ?>
<tr><td><strong>Full Name:         </strong></td><td><?= Html::encode($model->full_name) ?></td></tr><?= "\n" ?>
<tr><td><strong>Company Name:      </strong></td><td><?= Html::encode($model->company_name) ?></td></tr><?= "\n" ?>
<tr><td><strong>Account Number:    </strong></td><td><?= Html::encode($model->account_number) ?></td></tr><?= "\n" ?>
<tr><td><strong>Email:             </strong></td><td><?= Html::encode($model->email) ?></td></tr><?= "\n" ?>
<tr><td><strong>Telephone:         </strong></td><td><?= Html::encode($model->phone) ?></td></tr><?= "\n" ?>
<tr><td><strong>Address:           </strong></td><td><?= Html::encode($model->address) ?></td></tr><?= "\n" ?>
<tr><td><strong>City:              </strong></td><td><?= Html::encode($model->city) ?></td></tr><?= "\n" ?>
<tr><td><strong>State/Province:    </strong></td><td><?= Html::encode($model->state_prov) ?></td></tr><?= "\n" ?>
<tr><td><strong>ZIP / Postal Code: </strong></td><td><?= Html::encode($model->postal_code) ?></td></tr><?= "\n" ?>
<tr><td><strong>Country:           </strong></td><td><?= Html::encode($model->country) ?></td></tr><?= "\n" ?>
</table><?= "\n" ?>

<p>&nbsp;</p>

<h3>Transaction Details</h3>
<table border="1" cellspacing="5" cellpadding="5"><?= "\n" ?>
<tr><td><strong>Amount:                   </strong></td><td>&nbsp;$<?= Html::encode($model->amount) ?></td></tr><?= "\n" ?>
<tr><td><strong>Description:              </strong></td><td>&nbsp;<?= Html::encode($model->description) ?></td></tr><?= "\n" ?>
<tr><td><strong>Payment Date:             </strong></td><td>&nbsp;<?= Html::encode($model->payment_date) ?></td></tr><?= "\n" ?>
<tr><td><strong>Payment Status:           </strong></td><td>&nbsp;<?= ($model->payment_status ? "Paid": "Unpaid") ?></td></tr><?= "\n" ?>
<tr><td><strong>Credit Card Type:         </strong></td><td>&nbsp;<?= Html::encode($model->crcard_type) ?></td></tr><?= "\n" ?>
<tr><td><strong>Credit Card Num:          </strong></td><td>&nbsp;<?= Html::encode($model->crcard_number) ?></td></tr><?= "\n" ?>
<tr><td><strong>Transaction ID:           </strong></td><td>&nbsp;<?= Html::encode($model->trans_id) ?></td></tr><?= "\n" ?>
<tr><td><strong>Transaction Invoice:      </strong></td><td>&nbsp;<?= Html::encode($model->trans_invoice_num) ?></td></tr><?= "\n" ?>
<tr><td><strong>Transaction Description:  </strong></td><td>&nbsp;<?= Html::encode($model->trans_description) ?></td></tr><?= "\n" ?>
<tr><td><strong>Transaction Response:     </strong></td><td>&nbsp;<?= Html::encode($model->trans_response) ?></td></tr><?= "\n" ?>
</table><?= "\n" ?>








