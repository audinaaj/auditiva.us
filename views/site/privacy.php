<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Privacy Policy';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-privacy-policy">
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Disclaimer</h3>
    <p><?= Yii::$app->params['companyName'] ?> makes every effort to provide the most up-to-date and accurate information on this official company web site. However, we make no warranty or representation, express or implied that the information contained or referenced herein is accurate or complete. Furthermore, <?= Yii::$app->params['companyNameShort'] ?> shall not be liable in any manner whatsoever for direct, indirect, incidental, consequential, or punitive damage resulting from the use of, access to, or inability to use this information. </p>

    <p>In addition, <?= Yii::$app->params['companyNameShort'] ?> shall not be liable in any way for possible errors or omissions in the contents hereof. In particular, this applies to any references to products and services supplied by the <?= Yii::$app->params['companyName'] ?>. Information on this web site may contain technical inaccuracies or typographical errors. <?= Yii::$app->params['companyNameShort'] ?> may also make improvements and/or changes in the products and/or the programs described in this information at any time without prior notification, and will not be liable in any way for possible consequences of such changes.</p>

    <p>Product information published on this <?= Yii::$app->params['companyNameShort'] ?> Web site may contain references or cross references to <?= Yii::$app->params['companyNameShort'] ?> products, programs and services - illustrated or described - that are not announced or available in your country. These products, programs and services references do not imply that <?= Yii::$app->params['companyNameShort'] ?> intends to announce such products, programs or services in your country. </p>

    <p>It is up to you to take precautions to ensure that whatever you select for your use is free of such items as viruses, worms, Trojan horses and other items of a destructive nature. In no event will <?= Yii::$app->params['companyNameShort'] ?> be liable to any party for any direct, indirect, special or other consequential damages by any use of this website, or any other hyperlinked website, including, without limitation, any lost profits, business interruption, loss of programs or other data on your information handling system or otherwise, even if we are expressly advised of the possibility of such damages.</p>

    <h3>Privacy Practices</h3>

    <p><?= Yii::$app->params['companyNameShort'] ?> recognizes the importance of protecting the privacy of visitors to our company web site and the information we may collect from our online visitors. The amount and type of information received depends on how you use our site.</p>

    <p>We use general, not personally identifiable collected information to generate statistics and measure site activity to improve the usefulness of our site for you, our visitors. During normal web site usage we do not collect or store personally identifiable information such as name, mailing address, e-mail address or phone number. </p>

    <p>There are instances where <?= Yii::$app->params['companyNameShort'] ?> requests personally identifiable information to provide the web site visitor a service (e.g. Professional area requires registration for access). This information, such as name, mailing address, e-mail address, type of request and possibly additional information is collected to fulfill your request. The information is used by <?= Yii::$app->params['companyNameShort'] ?> only to provide quality service to you. We do not share this information with any other company or association.</p>

    <p>Internet users may decide to send <?= Yii::$app->params['companyNameShort'] ?> personally identifying information. <?= Yii::$app->params['companyNameShort'] ?> will use this information only to determine how to respond to the electronic mail. We will not use this information other than to resolve the matter identified in the e-mail. </p>

    <p>We reserve the right to change our Privacy Policy. A revised Privacy Policy will apply only to data collected subsequent to its effective date. Any revisions will be posted at least 10 days prior to its effective date.</p>

    <p>E-mail: <i><?= Yii::$app->params['companyEmail'] ?></i></p>


</div>
