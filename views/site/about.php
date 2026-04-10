<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'About Us';
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="site-about">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-8">
                <h1>Who We Are</h1>
                <img src="https://cdn.auditiva.us/professionals/about-people-bw.png" class="img-responsive" align="left" width="750">
                <p>&nbsp;</p>
                <h3>Experience the <?= Yii::$app->params['companyNameShort'] ?> Difference</h3>
                <h4>Improving the lives of hearing loss patients</h4>
                <p>For over twenty years, our professional associates at <?= Yii::$app->params['companyNameShort'] ?> have designed and produced innovative hearing instruments to improve the lives of hearing loss patients. On a daily basis, our highly-skilled engineering, technical and sales associates demonstrate their vision for product excellence, superior service, unconditional integrity and customer value.</p>

                <h3>Quality and commitment at every stage</h3>
                <p>Our team is devoted to improving the quality of life for every person who wears an <?= Yii::$app->params['companyNameShort'] ?> hearing instrument. Tapping the diverse skills of all <?= Yii::$app->params['companyNameShort'] ?> team members, we effectively apply our resources to support hearing care professionals and to provide high-tech solutions that meet the hearing and cosmetic preferences of each patient.</p>


                <img src="https://cdn.auditiva.us/professionals/madeinusa.jpg" align="right">
                <p><?= Yii::$app->params['companyNameShort'] ?> takes pride in its independence as a global organization with loyal and satisfied clients on every continent. We are large enough to blend the latest technology with sophisticated design and engineering, while offering the highest level of personalized service.</p>

                <ul>
                  <li>Privately owned American company and hearing industry leader</li>
                  <li>Comprehensive product line to accommodate all hearing loss needs</li>
                  <li>International reputation -- exporting to over 45 countries</li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h1>Our Mission</h1>
                <img src="https://cdn.auditiva.us/professionals/productionlab-bw.jpg" class="img-responsive" align="left" width="360">
                <p>&nbsp;</p>
                <p><?= Yii::$app->params['companyNameShort'] ?> is committed to exceptional quality, supported by an enthusiastic customer service attitude. Quality comes first, with a "Do it right the first time" approach. Our goal is to continually improve our products and services to our customer, by having an effective and value added Quality Management System. Exceptional Quality and Customer Service is not just a way of doing business; it is a way of life at <?= Yii::$app->params['companyNameShort'] ?>. It is the key to our success!</p>
            </div>
        </div>
        
    </div>
</div>
