<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

use app\models\User;
use app\models\UtilsProvider;

//use app\assets\DistributorAsset;
//DistributorAsset::register($this);  // $this represents the view object

/* @var $this yii\web\View */
/* @var $searchModel app\models\DistributorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Distributors');
$this->params['breadcrumbs'][] = ['label'=> Yii::t('app', 'About Us'), 'url' => Url::toRoute(['site/about'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distributor-index">

    <a name="top"></a>
    <h1>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()): ?>
            <?= Html::a('<span class="glyphicon glyphicon-edit"></span>',  
                ['distributor/admin-index'], ['class'=>'', 'target' => '_self'] 
            ) ?>
         <?php endif; ?>
        <?= Html::encode($this->title) ?>
    </h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <a href="#distributors" class="btn btn-default"><i class="glyphicon glyphicon-th d-icon"></i> View All Distributors</a>
    
    <!-- <img src="<?= Yii::$app->homeUrl; ?>img/aboutus/international.jpg" align="center" width="1140"> -->

    <div class="col-lg-12 col-md-12 col-sm-12">
        <div id="world-map" class="img-responsive col-md-12" style="height: 600px;"></div>
    </div>
<?php 
  //<div id="world-map" style="width: 1140px; height: 600px"></div>
  //$jsBlock = '$(function(){
  //    $("#world-map").vectorMap();
  //});';
  
  $jsBlock = '
  var markerList = [' . getMarkers($models) . '];
  
  var data = '.getCountryData($models).';
  
  $("#world-map").vectorMap({
      map: "world_mill_en",
      backgroundColor: "#ffffff", //"#C8EEFF", // light blue
      zoomOnScroll: true,
      zoomOnScrollSpeed: 10,
      zoomStep: 3,
      series: {
        regions: [{
          //values: gdpData,
          values: data,
          //scale: ["#C8EEFF", "#0071A4"],    // blues
          scale: ["#90C3D4", "#003768"],      // blues
          //scale: ["#EEFFC8", "#71A400"],    // greens
          //scale: ["#71A400", "#a41071"],    // green, red
          normalizeFunction: "polynomial",
        }]
      },
      // regionStyle: {
      //   initial: {
      //     fill: "white",
      //     "fill-opacity": 1,
      //     stroke: "black",      // default "none"
      //     "stroke-width": 0.5,  // default 0
      //     "stroke-opacity": 0.5 // default 1
      //   },
      //   hover: {
      //     "fill-opacity": 0.8,
      //     cursor: "pointer",
      //     fill: "yellow"
      //   },
      //   selected: {
      //     fill: "yellow"
      //   },
      //   selectedHover: {
      //   }
      // },
      markerStyle: {
          initial: {
            //fill: "#F8E23B",  // yellow
            fill: "#F06D9B",    // pink
            stroke: "#383f47"
          }
      },
      markers: markerList,
      onRegionTipShow: function(events, el, code){
        //el.html(el.html()+" (GDP - "+gdpData[code]+")");
        el.html(el.html() /* country name */);
      },
      onMarkerClick: function(event, index) {
        //alert(markersList[index].weburl);
        jumptoUrl(markerList[index].weburl);
      },
      onRegionClick: function(event, code, region) {
        //alert("Code: " + code + ", Region:" + region);
        jumptoUrl("#"+code);
      },
      onRegionOver:function(event, code, region){
        //alert("Code: " + code + ", Region:" + region);
        //document.body.style.cursor ="pointer";
      },
      onRegionOut:function(element, code, region){
        //alert("Code: " + code + ", Region:" + region);  
        //document.body.style.cursor ="default";
      }
    });
    
    function jumptoUrl(url){
        window.location.href = url;
    }
  ';
  echo $this->registerJs($jsBlock, \yii\web\View::POS_END);
?>
<?php
echo "<a name='distributors'></a>\n";  // create anchor to distributor list

$lastCountry = '';
foreach($models as $model)
{
    // Edit button (for Admin only)
    $curAction = Yii::$app->controller->action->id;
    if (isset(Yii::$app->user->identity) && (Yii::$app->user->identity->role == User::ROLE_ADMIN)) {
        $btnEdit = Html::a('<span class="glyphicon glyphicon-edit"></span>',  
            Yii::$app->urlManager->createUrl(['distributor/update', 'id'=>$model['id']], ['class'=>'btn btn-default', 'target' => '_self']) 
        ) . ' ';
    } else {
        $btnEdit = '';
    }

    echo "<p>\n";
    echo "<a name='".$model['dist_country']."'></a>\n";  // create anchor to country
    echo "<a name='" . strtoupper(UtilsProvider::getCountry_ISO3166_alpha2FromName($model['dist_country'])) . "'></a>\n";  // create anchor to country
    if ($model['dist_country'] != $lastCountry) {
        $btnTop = Html::a('<span class="glyphicon glyphicon-chevron-up"></span>',  '#top', ['class'=>'btn btn-default', 'target' => '_self']);
        echo "<h3>" . $model['dist_country'] . ' ' . $btnTop . "</h3>\n";
    }
    
    $services = ( ( $model['services'] != 'Other') ? $model['services'] . '. ' : '' );
    if (!empty($model['website'])) {
        // company name with hyperlink
        $company_name = Html::a($model['company_name'], urldecode($model['website']), ['target' => '_blank']);
    } else {
        // company name plain
        $company_name = $model['company_name'];
    }
    echo '<b>'.$btnEdit.$company_name.'</b>, ' . $services .  $model['city'] . ', ' . $model['country']. "<br/>\n";
    echo '<b>Address:</b> ' . 
            $model['address']. ', ' . 
            $model['city'] . ', ' . 
            ( !empty($model['state_prov'])  ? $model['state_prov']  . ' ' : '' ) . 
            ( !empty($model['postal_code']) ? $model['postal_code'] . ', ' : '' ) . 
            $model['country'] . "<br/>\n";
    if (!empty($model['phone'])) {
        echo '<b>Telephone:</b> ' . $model['phone'] . "<br/>\n";
    }
    if (!empty($model['fax'])) {
        echo '<b>Fax:</b> ' . $model['fax'] . "<br/>\n";
    }
    if (!empty($model['email'])) {
        echo '<b>E-mail:</b> ' . Html::mailto($model['email'], $model['email']) . "<br/>\n";
    }
    if (!empty($model['website'])) {
        echo '<b>Web:</b> ' . Html::a($model['website'], urldecode($model['website']), ['target' => '_blank']) . "<br/>\n";
    }
    if (!empty($model['instructions'])) {
        echo '<b>Note:</b> ' . $model['instructions'] . "<br/>\n";
    }
    echo "</p>\n";
    
    $lastCountry = $model['dist_country'];
}
?>
    

</div>

<?php
function getMarkers($models)
{
    $data = array();
    foreach($models as $model) {
        // Format: {latLng: [41.90, 12.45], name: "Rome, Italy", weburl : "/blah/foo"}
        $data[] = '{' . 
          'latLng: [' .  $model['latitude'] . ', ' . $model['longitude'] . '], ' . 
          'name: "' .    $model['city']     . ', ' . $model['country'] . '", ' . 
          'weburl: "#' . $model['country']  . '"' . 
        '}';
    }
    $str = implode(', ', $data);  // comma separated
    return $str;
}

function getCountryData($models)
{
    // Sample javascript array containing country data:
    // var data = {
    //      "AR": 1000,
    //      "ZW": 1000
    // };
    $data = array();
    $data[] = '"_0": 1000, "_1": 1000, "UNDEFINED": 1000';   // "_0" = Kosovo (temp code is XK), "_1" = Somaliland
    
    // Get all countries
    $countries = UtilsProvider::$countries_ISO3166_alpha2;
    foreach($countries as $countryCode => $countryName) {
        $data[] = '"' .  strtoupper($countryCode) . '": 1000';
    }
    
    // Get active countries
    foreach($models as $model) {
        $data[] = '"' .  strtoupper(UtilsProvider::getCountry_ISO3166_alpha2FromName($model['dist_country'])) . '": 15000';
    }
    
    $str = '{' . implode(', ', $data) . '}';  // comma separated contained in a javascript array
    return $str;
}
?>
