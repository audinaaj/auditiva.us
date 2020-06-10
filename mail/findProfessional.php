<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form frontend\models\FindProfessionalForm */
?>

Thank you, <?= Html::encode($form->firstName . ' '  . $form->lastName) ?>.  We appreciate your submission.<br><?= "\n" ?>
We will contact you within two (2) business days.<br><?= "\n" ?>
For your records, these are the contents of your message:<br><?= "\n" ?>
<hr>
Please find a Professional in my area.  My contact information is:
<table border="0" cellspacing="5" cellpadding="5"><?= "\n" ?>
<tr><td><strong>Name:     </strong></td><td><?= Html::encode($form->firstName . ' ' . $form->lastName) ?></td></tr><?= "\n" ?>
<tr><td><strong>Email:    </strong></td><td><?= Html::encode($form->email) ?></td></tr><?= "\n" ?>
<tr><td><strong>Telephone:</strong></td><td><?= Html::encode($form->telephone) ?></td></tr><?= "\n" ?>
<tr><td><strong>City:     </strong></td><td><?= Html::encode($form->city) ?></td></tr><?= "\n" ?>
<tr><td><strong>State:    </strong></td><td><?= Html::encode($form->state) ?></td></tr><?= "\n" ?>
<tr><td><strong>ZIP Code: </strong></td><td><?= Html::encode($form->zipCode) ?></td></tr><?= "\n" ?>
<tr><td><strong>Country:  </strong></td><td><?= Html::encode($form->country) ?></td></tr><?= "\n" ?>
<tr><td><strong>Currently wear hearing aids?</strong></td><td><?= Html::encode($form->isProductUser) ?></td></tr><?= "\n" ?>
<tr><td><strong>Products interested in?</strong></td><td>-<?= implode(", ", $form->productInterests) ?></td></tr><?= "\n" ?>
<tr><td><strong>Type of help</strong></td><td><?= Html::encode($form->helpType) ?></td></tr><?= "\n" ?>
<tr><td><strong>Product Serial Numbers:</strong></td><td><?= Html::encode($form->productSerialNumbers) ?></td></tr><?= "\n" ?>
</table><?= "\n" ?>






