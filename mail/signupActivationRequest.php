<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$activateLink   = Yii::$app->urlManager->createAbsoluteUrl(['user/activate',   'id' => $user->id, 'token' => $token]);
$deactivateLink = Yii::$app->urlManager->createAbsoluteUrl(['user/deactivate', 'id' => $user->id, 'token' => $token]);
$banLink        = Yii::$app->urlManager->createAbsoluteUrl(['user/ban',        'id' => $user->id, 'token' => $token]);
?>

<table border="0" cellspacing="5" cellpadding="5">
<tr><th><strong>Details for New Website User: </th><th></th></tr><?= "\n" ?>
<tr><td><strong>Username:          </strong></td><td><?= Html::encode($user->username) ?></td></tr><?= "\n" ?>
<tr><td><strong>Name:              </strong></td><td><?= Html::encode("{$user->first_name} {$user->last_name}") ?></td></tr><?= "\n" ?>
<tr><td><strong>Email:             </strong></td><td><?= Html::encode($user->email) ?></td></tr><?= "\n" ?>
<tr><td><strong>Phone:             </strong></td><td><?= Html::encode($user->phone) ?></td></tr><?= "\n" ?>
<?php
//<tr><td><strong>Company:           </strong></td><td><?= Html::encode($user->company_name) ? ><?= "\n" ? >
//<tr><td><strong>Address:           </strong></td><td><?= Html::encode($user->address1 . ', ' . $user->address2) ? ></td></tr><?= "\n" ? >
//<tr><td><strong>City:              </strong></td><td><?= Html::encode($user->city) ? ></td></tr><?= "\n" ? >
//<tr><td><strong>State / Province:  </strong></td><td><?= Html::encode($user->state_prov) ? ></td></tr><?= "\n" ? >
//<tr><td><strong>ZIP / Postal Code: </strong></td><td><?= Html::encode($user->postal_code) ? ></td></tr><?= "\n" ? >
//<tr><td><strong>Country:           </strong></td><td><?= Html::encode($user->country) ? ></td></tr><?= "\n" ? >
//<tr><td><strong>Job Title:         </strong></td><td><?= Html::encode($user->job_title) ? ></td></tr><?= "\n" ? >
//<tr><td><strong>Acount Number:     </strong></td><td><?= Html::encode($user->account_number) ? ></td></tr><?= "\n" ? >
?>
</table><?= "\n" ?>
Activate User Account?  Click on the link to activate and notify user: <br><?= "\n" ?>
[ <?= Html::a('Activate & Notify Now', $activateLink) ?> ][ <?= Html::a('Deactivate', $deactivateLink) ?> ][ <?= Html::a('Ban', $banLink) ?> ]





