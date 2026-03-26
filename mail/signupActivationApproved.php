<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$link = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
?>

Hello <?= Html::encode($user->first_name) ?>, <br><?= "\n" ?>
<p>
You recently signed up for a website account at <?= Yii::$app->params['companyName'] ?> <br> 
Your account is active now. For your records, your username is <?= Html::encode($user->username) ?>.
<p><?= "\n" ?>
Do you want visit our website?  Click on the link below: <br><?= "\n" ?>
[ <?= Html::a('Website', $link) ?> ]





