<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Yii::$app->params['companyNameShort'];
?>

<div class="site-index">
    <!-- Carousel -->
    <?php
        $images = ArrayHelper::getColumn($modelsCarousel, function ($slide) {
            return [
                'content' => (!empty($slide['full_text']))
                     ? Html::a(Html::img(Yii::$app->formatter->asS3Url($slide['intro_image'])), $slide['full_text'])
                     : Html::img(Yii::$app->formatter->asS3Url($slide['intro_image'])),
            ];
        });

        echo yii\bootstrap\Carousel::widget([
            'items'=>$images,
            'showIndicators' => true,
            //'controls' => ['&lsaquo;', '&rsaquo;'],
            'controls' => [
                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', 
                '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
            ],
        ]);
    ?>
    <!-- Featured Articles -->
    <div class="jumbotron">
        <div class="row">
            <?php
            $cntModels = count($modelsFeatured);
            $i = 0;
            foreach ($modelsFeatured as $model) {
                $i++;
                // Image Data
                $imgData = '';
                if (!empty($model['intro_image'])) {
                    $imgData .= "<div class='col-lg-6 col-md-6 col-sm-6'>\n";
                    $imgData .= '<div class="media-' . $model['main_image_float'] . '">';

                    // Link intro image to article (if available)
                    $imgThumb = Html::img(Yii::$app->formatter->asS3Url($model['intro_image']), [
                        //'align' => $model['intro_image_float'], 
                        'style' => "margin: 10px; width: 67%; float: " . $model['intro_image_float'],
                        //'class' => "img-thumbnail", // "img-rounded", "img-circle", or comment out for None
                        'class' => "img-responsive"
                    ]);
                    if (!empty($model['full_text'])) {
                        $imgData .= Html::a($imgThumb, ['content/view', 'id'=>$model['id']]);  // thumbnail with hyperlink
                    } else {
                        $imgData .= $imgThumb;  // thumbnail with no hyperlink
                    }
                    $imgData .= '</div></div>';
                }

                // Image (Left)
                if ($model['intro_image_float'] === 'left') {
                    echo $imgData;
                }
    
                // Text Content
                echo '<div class="col-lg-6 col-md-6 col-sm-6" style="text-align: left;">';
                if ($model['show_title']) {
                    echo "  <h2>".$model['title']."</h2>\n";
                }
                echo "  <h2>".$model['intro_text']."</h2>\n";
                if (!empty($model['full_text'])) {
                    echo Html::a('Read More...', 
                         ['content/view', 'id'=>$model['id']], ['class'=>'btn btn-lg btn-success']
                     );
                }
                echo "</div>\n";
                
                // Image (Right)
                if ($model['intro_image_float'] === 'right') {
                    echo $imgData;
                }
                if ($cntModels > $i) {
                    echo '<div class="col-lg-12 col-md-12 col-sm-12"><hr class="featurette-divider"></div>';
                }
            }
            ?>
        </div>
    </div>
    
    <div style="margin-bottom: 5px;"></div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <img class="img-circle" src="https://cdn.auditiva.us/frontpage/frontpage-consumers.png" alt="Hearing aid usrs getting coffee" style="width: 350px;">
                <h2>For Consumers</h2>

                <p>Available Treatment and Care</p>

                <p><a class="btn btn-success" href="<?= Url::to(['content/index', 'category' => 'consumers']); ?>">Learn More</a></p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <img class="img-circle" src="https://cdn.auditiva.us/frontpage/frontpage-products.png" alt="Assorted hearing aids" style="width: 350px;">
                <h2>Our Products</h2>

                <p>From Custom to Open Fit</p>

                <p><a class="btn btn-success" href="<?= Url::to(['content/index', 'category' => 'products']); ?>">Learn More</a></p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <img class="img-circle" src="https://cdn.auditiva.us/frontpage/frontpage-professionals.png" alt="Dispenser using computer" style="width: 350px;">
                <h2>For Professionals</h2>

                <p>Experience the <?= Yii::$app->params['companyNameShort'] ?> Difference</p>

                <p><a class="btn btn-success" href="<?= Url::to(['professional/index']); ?>">Learn More</a></p>
            </div>
        </div>

    </div>
</div>
