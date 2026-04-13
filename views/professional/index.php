<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = Yii::$app->params['companyNameShort'];

$s3Url = 'https://cdn.auditiva.us';
?>


<div class="site-index">

    <div style="margin-bottom: 20px;"></div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-6">
                <img class="img-thumbnail" src="<?= $s3Url ?>/professionals/about-people-bw.png" alt="Generic placeholder image" style="width: 350px;">
                <h2>Testimonials</h2>
                <p>We have many customers sharing their happy experiences with us. Here are some of their comments.</p>
                <p><a class="btn btn-default" href="<?= Url::to(['/professional/testimonials']); ?>">Learn More</a></p>
                <br/>
            </div>
            <div class="col-lg-6">
                <img class="img-thumbnail" src="<?= $s3Url ?>/professionals/product-specs-banner.png" alt="Generic placeholder image" style="width: 350px;">
                <h2>Product Specifications</h2>
                <p>Access the different products and their specifications.</p>
                <p><a class="btn btn-default" href="<?= Url::to(['/professional/product-specs']); ?>">Learn More</a></p>
                <br/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <img class="img-thumbnail" src="<?= $s3Url ?>/professionals/techman-banner.png" alt="Generic placeholder image" style="width: 350px;">
                <h2>Technical Manual</h2>
                <p> This is a restricted area for Module Accounts only.
                    Please contact your sales representative for access.
                </p>
                <p><a class="btn btn-default" href="<?= Url::to(['/professional/technical-manual']); ?>">Module Login</a></p>
                <br/>
            </div>
            <div class="col-lg-6">
                <img class="img-thumbnail" src="<?= $s3Url ?>/professionals/programingSoftware.jpg" alt="Generic placeholder image" style="width: 350px;">
                <h2>Software</h2>
                <p>Download software for fitting and programming all the latest <?= Yii::$app->params['companyNameShort'] ?> products. It includes HI-PRO, NOAHlink, and EMiniTec drivers.</p>
                <p>
                   <a class="btn btn-default" href="<?= Url::to(['/professional/software']); ?>">Learn More</a>
                </p>
                <br/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <img class="img-thumbnail" src="<?= $s3Url ?>/professionals/printableForms.jpg" alt="Generic placeholder image" style="width: 350px;">
                <h2>Printable Forms</h2>
                <p><a class="btn btn-default" href="<?= Url::to(['/professional/printable-forms']); ?>">Learn More</a></p>
                <br/>
            </div>
            <div class="col-lg-6">
                <img class="img-thumbnail" src="<?= $s3Url ?>/professionals/marketingDownloads.jpg" alt="Generic placeholder image" style="width: 350px;">
                <h2>Marketing Materials</h2>
                <p><a class="btn btn-default" href="<?= Url::to(['/professional/marketing-materials']); ?>">Learn More</a></p>
                <br/>
            </div>
        </div>

    </div>
</div>
