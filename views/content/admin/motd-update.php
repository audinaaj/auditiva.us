<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = Yii::t('app', 'Update "Message of the Day"');
$shortTitle = getStrEllipsis($model->title, 50);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contents'), 'url' => ['admin-index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '"Message of the Day"'), 'url' => ['motd-index']];
$this->params['breadcrumbs'][] = ['label' => $shortTitle, 'url' => ['motd-view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="content-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('motd-form', [
        'model' => $model,
    ]) ?>

</div>

<?php
function getStrEllipsis($str, $len)
{
    // Get a string of max $len characters; either $len (or less) normal characters or $len-3 characters followed by '...'
    return (strlen($str) > $len) ? mb_substr($str, 0, ($len-3), Yii::$app->charset).'...' : $str;
}
?>
