<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

/* @var $this yii\web\View */
$this->title = 'Technical Manual';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="site-software">
       
    <h1><?= $this->title; ?></h1>
    
    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role <= User::ROLE_MODULE): //if (\Yii::$app->user->can('viewTechnicalManual')): ?>
        <div class="contentpane">
        <iframe id="blockrandom"
            name="iframe"
            src="<?= Yii::$app->params['companyWebsiteSecure'] ?>/techman/"
            width="100%"
            height="800"
            scrolling="auto"
            frameborder="1"
            class="wrapper">
            This option will not work correctly. Unfortunately, your browser does not support inline frames.</iframe>
        </div>
    <?php else: ?>
        <?php //echo '<pre>' . print_r(Yii::$app->user->identity, true) . '</pre>'; ?>
        <h4>
            <table>
            <tr>
                <td><i class="fa fa-ban fa-3x" aria-hidden="true"></i></td><td>&nbsp;</td>
                <td>Not authorized to view <code><?= $this->title; ?></code>. <br/>
                    Please <?= Html::a('contact', ['site/contact-us']) ?> your Sales Representative to request access. 
                    
                </td>
            </tr>
            </table>
        </h4>
    <?php endif; ?>

</div>
