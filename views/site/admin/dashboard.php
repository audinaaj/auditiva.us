<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

//$btnFullWidth = '';         // regular width
$btnFullWidth = 'btn-block';  // full width

$this->title = 'Admin';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-index">
    <h1><span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span> System Administration</h1>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><h3><i class="glyphicon glyphicon-folder-open d-icon" aria-hidden="true"></i> Content</h3>
                      <p>Manage content (articles, news, carousel, etc.).</p></h3>
                    </div>
                    <div class="panel-body">
                    
                        <div class="list-group">
                            <?= Html::a('<i class="glyphicon glyphicon-paperclip d-icon" aria-hidden="true"></i>' . ' Articles', 
                                 ['content/admin-index'], ['class' => "list-group-item"]) 
                            ?>
                            <?= Html::a('<i class="glyphicon glyphicon-paperclip d-icon" aria-hidden="true"></i>' . ' Carousel', 
                                 ['content/carousel-index'], ['class' => "list-group-item"]) 
                            ?>
                            <?= Html::a('<i class="glyphicon glyphicon-paperclip d-icon" aria-hidden="true"></i>' . ' MOTD', 
                                 ['content/motd-index'], ['class' => "list-group-item"]) 
                            ?>
                            <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon" aria-hidden="true"></i>' . ' Categories', 
                                 ['content-category/admin-index'], ['class' => "list-group-item"]) 
                            ?>
                            <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon" aria-hidden="true"></i>' . ' Types', 
                                 ['content-type/admin-index'], ['class' => "list-group-item"]) 
                            ?>
                        </div>
                        
                    </div>
                </div>

            </div>
            
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><h3><i class="glyphicon glyphicon-globe d-icon" aria-hidden="true"></i> Distributors</h3>
                      <p>Manage distributors and branches.</p></h3>
                    </div>
                    <div class="panel-body">
                        <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon" aria-hidden="true"></i>' . ' Manage &raquo;', 
                             ['distributor/admin-index'], ['class'=>'btn btn-default']) 
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><h3><i class="glyphicon glyphicon-thumbs-up d-icon" aria-hidden="true"></i> Testimonials</h3>
                      <p>Manage testimonials.</p></h3>
                    </div>
                    <div class="panel-body">
                        <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon" aria-hidden="true"></i>' . ' Manage &raquo;',  
                            ['testimonial/admin-index'], ['class'=>'btn btn-default']) 
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><h3><i class="glyphicon glyphicon-usd d-icon" aria-hidden="true"></i> Payments</h3>
                      <p>Manage payments by users.</p></h3>
                    </div>
                    <div class="panel-body">
                        <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon" aria-hidden="true"></i>' . ' Manage &raquo;',  
                            ['payment/admin-index'], ['class'=>'btn btn-default']) 
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><h3><i class="glyphicon glyphicon-th-list d-icon" aria-hidden="true"></i> Settings</h3>
                      <p>Manage application settings.</p></h3>
                    </div>
                    <div class="panel-body">
                        <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon" aria-hidden="true"></i>' . ' Manage &raquo;',  
                            ['app-setting/admin-index'], ['class'=>'btn btn-default']) 
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><h3><i class="glyphicon glyphicon-user d-icon" aria-hidden="true"></i> Users</h3>
                      <p>Manage site users.</p></h3>
                    </div>
                    <div class="panel-body">
                        <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon"></i>' . ' Manage', 
                             ['user/index'], ['class'=>'btn btn-default', 'target' => '_self']) 
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><h3><i class="glyphicon glyphicon-envelope d-icon" aria-hidden="true"></i> Spam Filter</h3>
                      <p>Manage site spam filters.</p></h3>
                    </div>
                    <div class="panel-body">
                        <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon"></i>' . ' Manage', 
                             ['spam-filter/admin-index'], ['class'=>'btn btn-default', 'target' => '_self']) 
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"></h3><h3><i class="glyphicon glyphicon-picture d-icon" aria-hidden="true"></i> Media Gallery</h3>
                      <p>Manage images, videos and documents.</p>
                    </div>
                    <div class="panel-body">
                        <?= Html::a('<i class="glyphicon glyphicon-dashboard d-icon"></i>' . ' Manage', 
                             ['/s3manager'], ['class'=>'btn btn-default', 'target' => '_self']) 
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h3 class="panel-title"><h3><i class="glyphicon glyphicon-cog d-icon" aria-hidden="true"></i> Tools</h3><p>External tools.</p></h3>
                    </div>
                    <div class="panel-body">
                        
                        <div class="list-group">
                            <?= '';//Html::a('<i class="glyphicon glyphicon-dashboard d-icon" aria-hidden="true"></i>' . ' Database &raquo;', 
                                // '/support/phpmyadmin', ['class'=>'list-group-item', 'target' => '_blank']) 
                            ?>
                            <?= Html::a('<i class="glyphicon glyphicon-save d-icon" aria-hidden="true"></i>' . ' Backup Database &raquo;',  
                                ['site/backup-database'], ['class'=>'list-group-item']) 
                            ?>
                            <?= '';//Html::a('<i class="glyphicon glyphicon-stats d-icon" aria-hidden="true"></i>' . ' Analytics &raquo;', 
                                // '/webanalytics', ['class'=>'list-group-item', 'target' => '_blank']) 
                            ?>
                            <?php //Html::a('Clear Cache &raquo;', ['site/clear-cache'], ['class'=>'btn btn-default'])  ?>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            
        </div>

    </div>
</div>
