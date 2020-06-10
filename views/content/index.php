<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
/* @var $form ActiveForm */

$this->title = 'Content';
if (count($models) > 0) {
    $this->title = $models[0]['category']['title'];  //'Content';
    $content = '';
} else {
    $content = '<H3>No articles available</H3>';   
}
//if (!empty($section)) {
//    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content'), 'url' => [$section]];
//}    
$this->params['breadcrumbs'][] = Html::encode($this->title);

//echo '<pre>'.print_r($models[0]['category']['title'], true).'</pre>';
?>
<div class="content-index">

<?= $content ?>

<?php
//--------------------------------
// Admin 
//--------------------------------
if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
    echo $btnViewAdminIndex = Html::a('<span class="glyphicon glyphicon-edit"></span> ' . Yii::t('app', 'Manage Content'),  
        [   'content/admin-index',
            'category' => $category,
             'tags'    => $tags,
             'ord'     => $ord,
             'by'      => $by,
        ], 
        ['class'=>'btn btn-default', 'target' => '_self'] 
    );
} 
    
foreach ($models as $model) {
    // Display $model here
    // echo '<div style="clear: both; padding-top: 10px;">';
    // if (!empty($model['intro_image'])) {
    //    $imgmain  = Yii::$app->homeUrl.'media/'.$model['main_image'];
    //    $imgthumb = Html::img(Yii::$app->homeUrl.'media/'.$model['intro_image'], ['align' => $model['intro_image_float']]);
    //    echo Html::a($imgthumb, $imgmain);
    // }
    // echo "<h3>" . $model['title'] . "</h3>";
    // echo "<p>" . $model['intro_text'] . "</p>";
    // if (!empty($model['full_text'])) {
    //    echo Html::a('Read More...', 
    //       ['content/view', 'id'=>$model['id']], ['class'=>'btn btn-default']
    //    );
    // }
    // echo "</div>";
    
    echo '<div class="media">';
   
    // Image Data
    $hasImage = (!empty($model['intro_image']));
    $imgData = '';
    if (!empty($model['intro_image'])) {
        $imgData = '<div class="media-' . $model['main_image_float'] . ' col-lg-4 col-xs-12">';
        // Link intro image to main article image
        //if (!empty($model['main_image'])) {
        //    $imgMain  = Yii::$app->homeUrl.'media/'.$model['main_image'];
        //} else {
        //    $imgMain  = '#';
        //}
        //$imgThumb = Html::img(Yii::$app->homeUrl.'media/'.$model['intro_image'], ['align' => $model['intro_image_float'], 'width' => '250']);
        //$imgData .= Html::a($imgThumb, $imgMain);

        // Link intro image to article (if available)
        $imgThumb = Html::img(Yii::$app->homeUrl.'media/'.$model['intro_image'], [
            'align' => $model['intro_image_float'], 
            'style' => "margin: 10px; width: 100%",
            'class' => "img-responsive img-thumbnail" // "img-rounded", "img-circle"
        ]);
        if (!empty($model['full_text'])) {
            $imgData .= Html::a($imgThumb, ['content/view', 'id'=>$model['id']]);  // thumbnail with hyperlink
        } else {
            $imgData .= $imgThumb;  // thumbnail with no hyperlink
        }
        $imgData .= '</div>';
    }
    
    // Edit button (for Admin only)
    $curAction = Yii::$app->controller->action->id;
    if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) {
        $btnEdit = Html::a('<span class="glyphicon glyphicon-edit"></span>',  
            Yii::$app->urlManager->createUrl(['content/update', 'id'=>$model['id']], ['class'=>'btn btn-default', 'target' => '_self']) 
        ) . ' ';
    } else {
        $btnEdit = '';
    }

    echo '<div class="row">';
    // Image (Left)
    if ($model['intro_image_float'] === 'left') {
        echo $imgData;
    }
    
    // Intro Text
    if ($hasImage) {
        //echo '<div class="media-body col-lg-8 col-xs-12">';
        echo '<div class="col-lg-8 col-xs-12">';
    } else {
        //echo '<div class="media-body col-lg-12 col-xs-12">';
        echo '<div class="col-lg-12 col-xs-12">';
    }
    echo '<div style="margin: 10px;">';
    echo '<h3 class="media-heading">' . $btnEdit . $model['title'] . '</h3>';
    echo "<p>" . $model['intro_text'] . "</p>";
    if (!empty($model['full_text'])) {
        echo Html::a('Read More...', 
             ['content/view', 'id'=>$model['id']], ['class'=>'btn btn-default']
         );
    }
    
    if (Html::encode($this->title) == 'News') {
        //enableSocialMediaSupport($this, $model);
    }
    
    echo "</div>";
    echo "</div>";
    
    // Image (Right)
    if ($model['intro_image_float'] === 'right') {
        echo $imgData;
    }
    
    echo "</div>";  // end row
    echo "</div>";  // end class-media
}

//// display pagination
//echo LinkPager::widget([
//    'pagination' => $pages,
//]); 
?>

</div><!-- content-index -->

<?php
function enableSocialMediaSupport($curView, $model)
{
    //-----------------------------------
    // Social Networks support
    //-----------------------------------
    $curUri = Yii::$app->params['companyWebsite'].Yii::$app->request->getUrl();
    //$curUriImg = Html::encode(Yii::$app->params['companyWebsite'].Yii::$app->urlManager->createUrl('').'media/'.$model['main_image']);
    $curUriImg = '';
    echo "<p>&nbsp;</p>\n\n";
    
    // Twitter: Share a link
    echo '<a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$curUri.'">Tweet</a>';
    echo Html::script("!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');");
    echo "\n\n";
    
    // LinkedIn Share button
    echo '<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>';
    echo '<script type="IN/Share" data-url="'.$curUri.'" data-counter="right"></script>';
    
    // Pinterest Pin-it button
    echo '<a data-pin-do="buttonPin" data-pin-color="red" data-pin-count="beside" 
          href="https://www.pinterest.com/pin/create/button/?url='.$curUri.'&media='.$curUriImg.'&description='.strip_tags(Html::encode(Yii::$app->params['companyNameShort'].' - '.$curView->title)).'">
          <img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png" /></a>';
    echo '<script async defer src="//assets.pinterest.com/js/pinit.js"></script>';
    
    // Google+ G+1 button
    //echo '<!-- Google+ G+1 button (STATIC) -->';
    //echo '<script src="https://apis.google.com/js/platform.js" async defer></script>';                  // Place this tag in your head or just before your close body tag.
    //echo '<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="100"></div>';  // Place this tag where you want the +1 button to render. 
    
    echo '<!-- Google+ G+1 button (DYNAMIC) -->';
    echo '<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="100" data-href="'.$curUri.'"></div>'; // Place this tag where you want the +1 button to render.
    echo Html::script("
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/platform.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();");  // Place this tag after the last +1 button tag
    
    // OpenGraph tags used for Facebook sharing
    //<meta property="og:url"         content="http://acme.com/en/content/index?category=news&section=site%2Fabout&ord=desc&by=created_at" />
    //<meta property="og:type"        content="article" />
    //<meta property="og:title"       content="Acme - News" />
    //<meta property="og:description" content="Content Index" />
    //<meta property="og:image"       content="N/A" />
    
    $curView->registerMetaTag(['property' => 'og:url',         'content' => $curUri], 'og:url');
    $curView->registerMetaTag(['property' => 'og:type',        'content' => 'article'], 'og:type');
    $curView->registerMetaTag(['property' => 'og:title',       'content' => Html::encode(Yii::$app->params['companyNameShort'].' - '.$curView->title)], 'og:title');
    $curView->registerMetaTag(['property' => 'og:description', 'content' => 'Content Index'], 'og:description');
    //$curView->registerMetaTag(['property' => 'og:image',       'content' => $curUriImg], 'og:image');
    echo "\n\n";

    // Load Facebook SDK for JavaScript
    echo '<!-- Load Facebook SDK for JavaScript -->
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, "script", "facebook-jssdk"));
            </script>';
    echo "\n\n";

    // Facebook 'Like' button code
    echo '<!-- Facebook Like button code -->
            <div class="fb-like" 
               data-href="' . $curUri . '" 
               data-layout="button_count" 
               data-action="like" 
               data-show-faces="true" 
               data-share="true">
            </div>';
    echo "\n\n";
}
?>
