<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form frontend\models\ContactUsForm */
?>

Thank you, <?= Html::encode($form->firstName . ' '  . $form->lastName) ?>.  We appreciate your submission.<br><?= "\n" ?>
We will contact you within two (2) business days, if necessary.<br><?= "\n" ?>
For your records, these are the contents of your message:<br><?= "\n" ?>
<hr>
<table border="0" cellspacing="5" cellpadding="5"><?= "\n" ?>
<tr><td><strong>Name:     </strong></td><td><?= Html::encode($form->firstName . ' ' . $form->lastName) ?></td></tr><?= "\n" ?>
<tr><td><strong>Email:    </strong></td><td><?= Html::encode($form->email) ?></td></tr><?= "\n" ?>
<tr><td><strong>Telephone:</strong></td><td><?= Html::encode($form->telephone) ?></td></tr><?= "\n" ?>
<tr><td><strong>City:     </strong></td><td><?= Html::encode($form->city) ?></td></tr><?= "\n" ?>
<tr><td><strong>State:    </strong></td><td><?= Html::encode($form->state) ?></td></tr><?= "\n" ?>
<tr><td><strong>ZIP Code: </strong></td><td><?= Html::encode($form->zipCode) ?></td></tr><?= "\n" ?>
<tr><td><strong>Country:  </strong></td><td><?= Html::encode($form->country) ?></td></tr><?= "\n" ?>
<tr><td><strong>Subject:  </strong></td><td><?= Html::encode($form->subject) ?></td></tr><?= "\n" ?>
<tr><td><strong>Category: </strong></td><td><?= Html::encode($form->helpCategory) ?></td></tr><?= "\n" ?>
<tr><td><strong>Message:  </strong></td><td><?= Html::encode($message) ?></td></tr><?= "\n" ?>
<tr><td><strong>Product Serial Numbers:</strong></td><td><?= Html::encode($form->productSerialNumbers) ?></td></tr><?= "\n" ?>
<tr><td><strong>IP Address:</strong></td><td><?= Yii::$app->request->userIP ?></td></tr><?= "\n" ?>
</table><?= "\n" ?>






