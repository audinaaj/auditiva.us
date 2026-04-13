<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

use app\models\User;

/* @var $this yii\web\View */
$this->title = 'Technical Manual';
$this->params['breadcrumbs'][] = ['label'=> 'Professionals', 'url' => Url::toRoute(['professional/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);

    $documents = [
        'Drawings' => [
            'title' => 'Drawings',
            'order' => '1',
            'document_data' => [
                ['label' => 'Ligero FC', 'url' => 'techman/10LIGEROFC.pdf'],
                ['label' => 'BTE D55', 'url' => 'techman/BTED55.pdf'],
                ['label' => 'BTE D55P', 'url' => 'techman/BTED55P.pdf'],
                ['label' => 'BTE D60P', 'url' => 'techman/BTED60P.pdf'],
                ['label' => 'BTE 65HP', 'url' => 'techman/BTED65HP_RevC.pdf'],
                ['label' => 'Intuir 4+ (CIC)', 'url' => 'techman/CICINTUIR4+.pdf'],
                ['label' => 'Intuir 4+ (Mini Canal)', 'url' => 'techman/MINCANALINTUIR4+.pdf'],
                ['label' => 'Intuir 4+ (Canal)', 'url' => 'techman/CANALINTUIR4+.pdf'],
                ['label' => 'Intuir 4+ (FSS)', 'url' => 'techman/FSSINTUIR4+.pdf'],
                ['label' => 'Intuir 12 (CIC)', 'url' => 'techman/CICINTUIR12.pdf'],
                ['label' => 'Intuir 12 (Mini Canal)', 'url' => 'techman/MINICANALINTUIR12.pdf'],
                ['label' => 'Intuir 12 (Canal)', 'url' => 'techman/CANALINTUIR12.pdf'],
                ['label' => 'Intuir 12 (FSS)', 'url' => 'techman/FSSINTUIR12.pdf'],
                ['label' => 'Ligero (CIC)', 'url' => 'techman/CICLIGERO.pdf'],
                ['label' => 'Ligero (Mini Canal)', 'url' => 'techman/MINICANALLIGERO.pdf'],
                ['label' => 'Ligero (Canal)', 'url' => 'techman/CANALLIGERO.pdf'],
            ]
        ],
        'OTE Instructions' => [
            'title' => 'OTE Instructions',
            'order' => '2',
            'document_data' => [
                ['label' => 'OTE CU10 Preparation B', 'url' => 'techman/OTE_CU10PREP_B.pdf'],
                ['label' => 'OTE Door Frame Installation B', 'url' => 'techman/OTE_DOORFRAME INSTALL.pdf'],
                ['label' => 'OTE Door Frame 2 RevA', 'url' => 'techman/OTE_DOORFRAME2_RevA.pdf'],
                ['label' => 'OTE Final Assembly B', 'url' => 'techman/OTE_FINALASSM_B.pdf'],
                ['label' => 'OTE Microphone Preparation B', 'url' => 'techman/OTE_MICPREP_B.pdf'],
                ['label' => 'OTE Receiver Preparation C', 'url' => 'techman/OTE_RECPREP_C.pdf'],
                ['label' => 'OTE Briza Door Replacement', 'url' => 'techman/OTE-BRIZA_DOOR REPL.pdf'],
            ]
        ],
    ];

    ArrayHelper::multisort($documents, 'order');

    $s3 = Yii::$app->get('s3');
?>
<div class="site-technical-manual">
    <h1><?= $this->title; ?></h1>

    <h4>Schematics for Modular Units</h4>

    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->role <= User::ROLE_MODULE): ?>
    <div class="row">
        <?php foreach ($documents as $category => $properties): ?>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <a name="<?= $category ?>"></a>
                <div class="panel panel-default" id="panel-<?= $category ?>">
                    <div class="panel-heading panel-title"><?= $properties['title'] ?></div>
                    <div class="panel-body">
                        <ul>
                        <?php
                            foreach ($properties['document_data'] as $document) {
                                $signedUrl = $s3->commands()->getPresignedUrl($document['url'])->execute();
                                echo '<li><a href="'.$signedUrl.'" target="_blank">'.$document['label'].'</a></li>';
                            }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
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
