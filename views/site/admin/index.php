<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

/* @var $this yii\web\View */

$this->title = Yii::$app->params['companyNameShort'] . ' Intranet';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><span class="glyphicon glyphicon-cloud"></span> Intranet</h1>

        <p class="lead">Available intranet systems.</p>

        <!--<p><a class="btn btn-lg btn-success" href="#">Learn more</a></p>-->
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3">
                <h2><?= Yii::$app->params['companyNameShort'] ?> Website</h2>

                <p>Access frontend portal.</p>

                <p>
                <?= Html::a('<i class="glyphicon glyphicon-clip d-icon"></i>' . ' View &raquo;', 
                     Yii::$app->urlManager->createUrl(['site/index']), 
                     ['class'=>'btn btn-default', 'target' => '_blank']) 
                ?>
                <?php if(\Yii::$app->user->can('createContent')) : ?>
                <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon"></i>' . ' Admin Dashboard &raquo;', 
                     ['site/admin-dashboard'], ['class'=>'btn btn-default', /* 'target' => '_blank' */]) 
                ?>
                <?php endif; ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h2>Product Catalog</h2>

                <p>Access products & specifications.</p>

                <p>
                <?= Html::a('<i class="glyphicon glyphicon-clip d-icon"></i>' . ' View &raquo;', 
                     Yii::$app->urlManager->createUrl(['professional/product-specs']), 
                     ['class'=>'btn btn-default', 'target' => '_blank']) 
                ?></p>
                <?php if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)): ?>
                    <p><?= Yii::$app->params['companyNameShort'] ?>: Manage products & specifications.</p>
                    <p>
                       <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/catalog/catalog-review.php" target="_blank">View &raquo;</a>
                       <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/catalog/build.php" target="_blank">Build &raquo;</a>
                       <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/catalog/filemgr" target="_blank">Manage Files &raquo;</a>
                    </p>
                    <p>Auditiva: Manage products & specifications.</p>
                    <p>
                       <a class="btn btn-default" href="http://www.auditiva.us/catalog/catalog-review.php" target="_blank">View &raquo;</a>
                       <a class="btn btn-default" href="http://www.auditiva.us/catalog/build.php" target="_blank">Build &raquo;</a>
                       <a class="btn btn-default" href="http://www.auditiva.us/catalog/filemgr" target="_blank">Manage Files &raquo;</a>
                    </p>
                <?php endif; ?>
            </div>
            
            <div class="col-lg-3">
                <h2>Workshops</h2>

                <p>Manage registrations & reports.</p>

                <p>
                   <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/workshopmgr/workshops" target="_blank">Manage &raquo;</a>
                   <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/workshopmgr/registrations/add" target="_blank">Register &raquo;</a>
                   <?php if (YII_ENV_DEV): ?>
                   <a class="btn btn-warning" href="http://localhost:8080/workshopmanager" target="_blank">Dev &raquo;</a>
                   <?php endif; ?>
                   <?php if (YII_ENV_DEV): ?>
                   <a class="btn btn-warning" href="http://localhost:8080/audina/site/api/web/v1/distributors/3" target="_blank">API Dev &raquo;</a>
                   <?php endif; ?>
                </p>
            </div>
            
            <div class="col-lg-3">
                <h2>Tech Support Log</h2>

                <p>Track technical support issues.</p>

                <p>
                  <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/techsupportlog/" target="_blank">Access &raquo;</a>
                  <?php if (YII_ENV_DEV): ?>
                  <a class="btn btn-warning" href="http://localhost:8080/techsupportlog/site/" target="_blank">Dev &raquo;</a>
                  <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <h2>Digital Assets</h2>

                <p>Manage shared images, videos, documents and other digital assets.</p>

                <p><a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/dam/" target="_blank">Access &raquo;</a></p>
            </div>
            <div class="col-lg-3">
                <h2>Company Cloud</h2>

                <p>Local cloud for easy document storage and sharing.</p>

                <p><a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/owncloud/" target="_blank">Access &raquo;</a></p>
            </div>

            <div class="col-lg-3">
                <h2>Payroll Timeclock</h2>

                <p>Punch in and out in Payroll Timeclock (Paychex).</p>

                <p><a class="btn btn-default" href="http://timeclockserver/timeclock/#" target="_blank">Access &raquo;</a></p>
            </div>
            <div class="col-lg-3">
                <h2>Online Store</h2>

                <p>Sell/Buy stock products online.</p>

                <p><a class="btn btn-default" href="https://secure.audina.net/store" target="_blank">Access &raquo;</a>
                <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon"></i>' . ' Manage &raquo;', 
                     'https://secure.audina.net/store/admin', ['class'=>'btn btn-default', 'target' => '_blank']) 
                ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <h2>Barcode Generator</h2>
                <p>View and manage product barcodes.</p>
                <p>
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/barcodes" target="_blank">Manage &raquo;</a>
                    <?php if (YII_ENV_DEV) : ?>
                    <a class="btn btn-warning" href="http://localhost:8080/barcodegen/site/web/" target="_blank">Dev &raquo;</a>
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h2>Label Generator</h2>

                <p>Generate labels for items/name tags and CD-ROMs.</p>

                <p> 
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/labels/web/" target="_blank">Manage &raquo;</a>
                    <?php if (YII_ENV_DEV) : ?>
                    <a class="btn btn-warning" href="http://localhost:8080/labels/site/web/" target="_blank">Dev &raquo;</a>
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h2>Nano-coating Log</h2>

                <p>Add entries or query P2i nano-coating log entries.</p>

                <p> 
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/p2ilog/web/" target="_blank">Manage &raquo;</a>
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/p2ilog/web/entry/summary" target="_blank">Summary &raquo;</a>
                    <?php if (YII_ENV_DEV) : ?>
                    <a class="btn btn-warning" href="http://localhost:8080/p2ilog/site/web/" target="_blank">Dev &raquo;</a>
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-lg-3">
                <h2>Production Build Log</h2>

                <p>Add entries or query product build log entries.</p>

                <p> 
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/production-log/web/" target="_blank">Manage &raquo;</a>
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/production-log/web/entry/summary" target="_blank">Summary &raquo;</a>
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/production-log/api/web/v1/entries" target="_blank">API &raquo;</a>
                    <?php if (YII_ENV_DEV) : ?>
                    <a class="btn btn-warning" href="http://localhost:8080/production-log/web/" target="_blank">Dev &raquo;</a>
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <h2>Sys36 Print Log</h2>

                <p>Query print log entries.</p>

                <p> 
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/print-log/web/" target="_blank">Manage &raquo;</a>
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/print-log/web/entry/summary" target="_blank">Summary &raquo;</a>
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/print-log/web/api-raws?printed=0" target="_blank">API &raquo;</a>
                    <?php if (YII_ENV_DEV) : ?>
                    <a class="btn btn-warning" href="http://localhost:8080/system36-printlog/site/web/" target="_blank">Dev &raquo;</a>
                    <a class="btn btn-warning" href="http://localhost:8080/system36-printlog/site/web/api-raws?RawSearch[printed]=0" target="_blank">API &raquo;</a>
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="col-lg-3">
                <h2>Phone Log</h2>

                <p>Query phone log entries.</p>

                <p> 
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/phone-log/web/" target="_blank">Manage &raquo;</a>
                    <?php if (YII_ENV_DEV) : ?>
                    <a class="btn btn-warning" href="http://localhost:8080/phone-log/site/web/" target="_blank">Dev &raquo;</a>
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="col-lg-3">
                <h2>Shipping Inventory</h2>

                <p>Manage supplies required for Shipping.</p>

                <p> 
                    <a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/shipping-inv/web/" target="_blank">Manage &raquo;</a>
                    <?php if (YII_ENV_DEV) : ?>
                    <a class="btn btn-warning" href="http://localhost:8080/shipping-inventory/site/web/" target="_blank">Dev &raquo;</a>
                    <?php endif; ?>
                </p>
            </div>
            
            <div class="col-lg-3">
                <h2>Export Customers</h2>

                <p>Customer relations manager.</p>

                <p><a class="btn btn-default" href="<?= Yii::$app->params['companyWebsite'] ?>/support/crm-export/web/" target="_blank">Manage &raquo;</a>
                    <?php if (YII_ENV_DEV) : ?>
                        <a class="btn btn-warning" href="http://localhost:8080/crm-export/site/web/" target="_blank">Dev &raquo;</a>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <?php if (YII_ENV_DEV) : ?>
        <div class="row  btn-warning">
            <div class="col-lg-3">
                <h2>Orders</h2>

                <p>Manage orders and generate barcode labels.</p>

                <p>
                   <a class="btn btn-default disabled" href="#">Manage &raquo;</a>
                   <a class="btn btn-default disabled" href="#">Reports &raquo;</a>
                </p>
            </div>
            <div class="col-lg-3">
                <h2>Customers</h2>

                <p>Customer relations manager.</p>

                <p><a class="btn btn-default disabled" href="#" target="_blank">Manage &raquo;</a></p>
            </div>
            <div class="col-lg-3">
                <h2>Complaints</h2>

                <p>Customer complaints manager.</p>

                <p><a class="btn btn-default" href="http://localhost:8080/complaintlog/site/web/" target="_blank">Manage &raquo;</a></p>
            </div>
            <div class="col-lg-3">
                <h2>Property Maint.</h2>

                <p>View and manage property maintenance actions and schedule.</p>

                <p><a class="btn btn-default" href="http://localhost:8080/propertymaint/site/web/" target="_blank">Manage &raquo;</a></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
