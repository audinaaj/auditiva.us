<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'International');
$this->params['breadcrumbs'][] = ['label'=> Yii::t('app', 'About Us'), 'url' => Url::toRoute(['site/about'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-international">

<h1><?= Html::encode($this->title) ?></h1>

<div id="world-map" style="width: 1140px; height: 400px"></div>
<?php 
  $jsBlock = '$("#world-map").vectorMap({
      map: "world_mill_en",
      backgroundColor: "#C8EEFF",
      series: {
        regions: [{
          values: gdpData,
          //scale: ["#C8EEFF", "#0071A4"],  // blues
          scale: ["#EEFFC8", "#71A400"],    // greens
          normalizeFunction: "polynomial",
        }]
      },
      onRegionTipShow: function(e, el, code){
        el.html(el.html()+" (GDP - "+gdpData[code]+")");
      }
    });';
  echo $this->registerJs($jsBlock, \yii\web\View::POS_END);
?>
<p>
<h3>Argentina</h3>
Acme, main distributor. Buenos Aires, Argentina.<br/>
Av San Martin, Buenos Aires, Argentina.<br/>
Telephones: (54-11) 1234-5678<br/>
E-mail: info@acme.com<br/>
Web: <?= Html::a('www.acme.com', urldecode('http://www.acme.com'), ['target' => '_blank']); ?><br/>
</p>
<p>

</div>
