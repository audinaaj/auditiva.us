<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset-password', 'token' => $user->password_reset_token]);
?>

Hello <?= Html::encode($user->username) ?>, <br><?= "\n" ?>

Follow the link below to reset your password: <br><?= "\n" ?>

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
