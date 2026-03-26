<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

$type = (!empty($type) ? $type : 'info');
?>
<div class="site-message">

    <h1><?= Html::encode($title) ?></h1>

    <div class="alert alert-<?= $type ?>">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>&nbsp;</p>
    <?php if (!empty($button_name) && !empty($button_url)): ?>
        <?= Html::a($button_name, [$button_url], ['class'=>'btn btn-'.$type]) ?>
    <?php endif; ?>
</div>

