<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Content */

$this->title = $model->title;
if (!empty($model->category) && ($model->category->alias == 'home')) {
    // no extra breadcrumbs for Home article
} else if (!empty($model->category)) {
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('app', $model->category->title), 
        'url'   => ['index', 'category' => $model->category->alias]
    ];
} else {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Content'), 'url' => ['index']];
}    
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-view">

<?php

    // Edit button (for Admin only)
    $curAction = Yii::$app->controller->action->id;
    if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) {
        $btnEdit = Html::a('<span class="glyphicon glyphicon-edit"></span>',  
            Yii::$app->urlManager->createUrl(['content/update', 'id'=>$model['id']], ['class'=>'btn btn-default', 'target' => '_self']) 
        ) . ' ';
    } else {
        $btnEdit = '';
    }

    // Introduction Text
    if ($model['show_title']) {
        echo '<h1>' . $btnEdit . Html::encode($this->title) . '</h1>';
    } else {
        echo '<h1>' . $btnEdit . '</h1>';
    }
    
    // Intro Text
    //echo '<div class="media-body">';
    echo '<div>';
    echo '  <div style="margin: 10px;">';
    
    // Introduction Text
    if ($model['show_intro']) {
        echo '  <hr>';
        echo '    <h3 class="media-heading"><small>' . $model['intro_text'] . '</small></h3>';
        echo '  <hr>';
    }
    
    // Image (Left/Right)
    if (!empty($model['main_image']) && $model['show_image']) {
        //echo Html::img(Yii::$app->homeUrl.'media/'.$model['main_image'], [
        echo Html::img(Yii::$app->urlManager->createUrl('').'media/'.$model['main_image'], [
            'align' => $model['main_image_float'], 
            //'width' => '1100', 
            'style' => "margin: 20px; max-width: 1100px",
            'class' => "img-thumbnail"
        ]);
    }
    
    // Content Full Text
    //echo HtmlPurifier::process($model->full_text);
    echo $model['full_text'] . "\n";
    
    echo "<hr>";
    
    //-----------------------------------
    // Social Networks support
    //-----------------------------------
    enableSocialMediaSupport($this, $model);
    
    //// Twitter: Share a link
    //echo '<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>';
    //echo Html::script("!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');");
    //echo "\n\n";
    //
    //// OpenGraph tags used for Facebook sharing
    ////<meta property="og:url"         content="http://www.nytimes.com/2015/02/19/arts/international/when-great-minds-dont-think-alike.html" />
    ////<meta property="og:type"        content="article" />
    ////<meta property="og:title"       content="When Great Minds Don’t Think Alike" />
    ////<meta property="og:description" content="How much does culture influence creative thinking?" />
    ////<meta property="og:image"       content="http://static01.nyt.com/images/2015/02/19/arts/international/19iht-btnumbers19A/19iht-btnumbers19A-facebookJumbo-v2.jpg" />
    //
    //$curUri = Html::encode(Yii::$app->params['companyWebsite'].Yii::$app->request->getUrl());
    //$this->registerMetaTag(['property' => 'og:url',         'content' => $curUri]);
    //$this->registerMetaTag(['property' => 'og:type',        'content' => 'article']);
    //$this->registerMetaTag(['property' => 'og:title',       'content' => Html::encode($this->title)]);
    //$this->registerMetaTag(['property' => 'og:description', 'content' => strip_tags($model['intro_text'])]);
    //$this->registerMetaTag(['property' => 'og:image',       'content' => Html::encode(Yii::$app->params['companyWebsite'].Yii::$app->urlManager->createUrl('').'media/'.$model['main_image'])]);
    //echo "\n\n";
    //
    //// Load Facebook SDK for JavaScript
    //echo '<!-- Load Facebook SDK for JavaScript -->
    //        <div id="fb-root"></div>
    //        <script>(function(d, s, id) {
    //          var js, fjs = d.getElementsByTagName(s)[0];
    //          if (d.getElementById(id)) return;
    //          js = d.createElement(s); js.id = id;
    //          js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
    //          fjs.parentNode.insertBefore(js, fjs);
    //        }(document, "script", "facebook-jssdk"));
    //        </script>';
    //echo "\n\n";
    //
    //// Facebook 'Like' button code
    //echo '<!-- Facebook Like button code -->
    //        <div class="fb-like" 
    //           data-href="' . $curUri . '" 
    //           data-layout="button_count" 
    //           data-action="like" 
    //           data-show-faces="true" 
    //           data-share="true">
    //        </div>';
    //echo "\n\n";
    
    echo "  </div>\n";
    echo "</div>\n";
    
    
?>

</div>

<?php
function enableSocialMediaSupport($curView, $model)
{
    //-----------------------------------
    // Social Networks support
    //-----------------------------------
    $curUri = Yii::$app->params['companyWebsite'].Yii::$app->request->getUrl();
    //$curUri = Yii::$app->params['companyWebsite'] . Url::to([Yii::$app->controller->id . '/' . Yii::$app->controller->action->id, 'id' => $model['id'] ]);
    $curUriImg = Html::encode(Yii::$app->params['companyWebsite'].Yii::$app->urlManager->createUrl('').'media/'.$model['main_image']);
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
          href="https://www.pinterest.com/pin/create/button/?url='.$curUri.'&media='.$curUriImg.'&description='.strip_tags($model['title']).'">
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
    //<meta property="og:url"         content="http://acme.com/en/content/view?id=19" />
    //<meta property="og:type"        content="article" />
    //<meta property="og:title"       content="Acme - When Great Minds Don’t Think Alike" />
    //<meta property="og:description" content="How much does culture influence creative thinking?" />
    //<meta property="og:image"       content="http://acme.com/en/backend/web/media/products/bte.png" />
    
    $curView->registerMetaTag(['property' => 'og:url',         'content' => $curUri]);
    $curView->registerMetaTag(['property' => 'og:type',        'content' => 'article']);
    //$curView->registerMetaTag(['property' => 'og:title',       'content' => Html::encode(Yii::$app->params['companyWebsite'].' - '.$curView->title)]);
    $curView->registerMetaTag(['property' => 'og:title',       'content' => Html::encode(Yii::$app->params['companyNameShort'].' - '.$model['title'])]);
    $curView->registerMetaTag(['property' => 'og:description', 'content' => strip_tags($model['intro_text'])]);
    $curView->registerMetaTag(['property' => 'og:image',       'content' => $curUriImg]);
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
