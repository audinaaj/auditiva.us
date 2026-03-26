<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Testimonials';
$this->params['breadcrumbs'][] = ['label'=> 'Consumers', 'url' => Url::toRoute(['consumer/index'])];
$this->params['breadcrumbs'][] = Html::encode($this->title);
?>
<div class="site-testimonials">

    <h1><?= $this->title; ?></h1>
    <img src="<?= Yii::$app->homeUrl; ?>img/aboutus/about-people-bw.png" class="img-responsive" align="center" width="1140">

    <p>&nbsp;</p>
    <p>&nbsp;</p>

    <blockquote>
      <p>I have experienced the distinct disadvantage of not hearing clearly what others were saying. I am frequently in group settings for meetings, classes and lectures; and my hearing difficulty made me hesitant to ask questions. I thought I might ask something that had been covered but missed by me, because I didn’t hear.
My <?= Yii::$app->params['companyNameShort'] ?> instrument has changed all that! Now, I can hear most of the time; and when I have difficulty, I easily adjust the volume. I really love the size of my instruments – the tiny, plastic tubes are almost invisible. Vanity kept me from enjoying better hearing earlier, but <?= Yii::$app->params['companyNameShort'] ?>’s instruments allow me to hear clearly and really understand conversation in group settings.
I would recommend anyone with hearing loss to talk with a hearing professional and experience the joy of being able to understand. I was very pleased with the ease of being tested and fitted with my <?= Yii::$app->params['companyNameShort'] ?> hearing aids. My hearing professional had thorough knowledge and training to fit and adjust my instruments.</p>
      <p><em>–Beverly Sibley, Maitland, FL, U.S.A.</em></p>
    </blockquote>
    
    <p>&nbsp;</p>
    <blockquote>
      <p>I have been hard of hearing since the age of six and have worn many types of hearing aids in the past. My <?= Yii::$app->params['companyNameShort'] ?> hearing instrument is by far the best! It is so comfortable and nearly invisible! I certainly would recommend <?= Yii::$app->params['companyNameShort'] ?> to anyone with hearing loss. In fact, I referred a friend who also is very happy with his new <?= Yii::$app->params['companyNameShort'] ?> hearing aid.</p>
      <p><em>–Lori Sommer, Apopka, FL, U.S.A.</em></p>
    </blockquote>
    
    <p>&nbsp;</p>
    <blockquote>
      <p>Clear hearing is a must for me! I am a Fraternal Mason and office holder and travel to conventions all over the United States. I have been wearing hearing aids for over 30 years and find <?= Yii::$app->params['companyNameShort'] ?>’s instruments allow clear hearing and convenient adjustments – better than any others I have worn. When I meet someone with a hearing loss, I encourage them to try an <?= Yii::$app->params['companyNameShort'] ?> hearing instrument. Thank you <?= Yii::$app->params['companyNameShort'] ?>!</p>
      <p><em>–Carl Straker, Lansdowne, PA, U.S.A.</em></p>
    </blockquote>
                
</div>
