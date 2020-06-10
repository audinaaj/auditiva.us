<?php

use yii\helpers\Html;
use app\widgets\Alert;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Create User');
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin'), 'url' => ['site/admin-dashboard']];
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
} else {
    $this->params['breadcrumbs'][] = Yii::t('app', 'Users');
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= Alert::widget() ?>
    
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
