<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;
use app\models\UtilsProvider;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

// Theme Layout 
switch(Yii::$app->params['siteLayout']) {
    case 'full':
        $bgStyle              = 'background-color: white;';
        $logoBannerStyle      = 'background-color: white;';
        $contentNavbarStyle   = 'background-color: white;';
        $contentNavbarClass   = 'wrap';
        $contentStyle         = 'background-color: white; margin-top: -80px; box-shadow: 0px 10px 20px -5px rgba(50, 50, 50, 0.94);';
        $contentClass         = 'wrap';
        $footerStyle          = 'background-color: #f5f5f5; border-top: 1px solid #ddd; padding-top: 20px;';
        $footerClass          = '';
        $footerContainerStyle = '';
        break;
        
    case 'default_white':
        $bgStyle              = 'background-color: white;';
        $logoBannerStyle      = 'background-color: white; box-shadow: 0px 20px 20px -5px rgba(50, 50, 50, 0.94);';
        $contentNavbarStyle   = 'background-color: white; box-shadow: 0px 10px 20px -5px rgba(50, 50, 50, 0.94);';
        $contentNavbarClass   = 'container wrap';
        $contentStyle         = 'background-color: white; margin-top: -80px;';
        $contentClass         = 'container wrap';
        $footerStyle          = 'background-color: #f5f5f5; border-top: 1px solid #ddd; padding-top: 20px; box-shadow: 0px 60px 20px -5px rgba(50, 50, 50, 0.94);';
        $footerClass          = 'container';
        $footerContainerStyle = 'margin: 10px;';
        break;
        
    case 'default_gray':
    case 'default':
    default:
        $bgStyle              = 'background-color: #ddd;';  // gray
        $bgStyle              = 'background-color: #d4cbbe;';  // lightbrow
        //$logoBannerStyle      = 'background-color: white; box-shadow: 0px 20px 30px -5px rgba(50, 50, 50, 0.94);';
        $logoBannerStyle      = 'background-color: white; box-shadow: 0px 10px 15px 0px rgba(50, 50, 50, 0.94);';
        //$contentNavbarStyle   = 'background-color: white; box-shadow: 0px 10px 30px -5px rgba(50, 50, 50, 0.94);';
        $contentNavbarStyle   = 'background-color: white; box-shadow: 0px 10px 15px 0px rgba(50, 50, 50, 0.94);';  // dark gray
        $contentNavbarClass   = 'container wrap';
        $contentStyle         = 'background-color: white; margin-top: -80px;';
        $contentClass         = 'container wrap';
        //$footerStyle          = 'background-color: #f5f5f5; border-top: 1px solid #ddd; padding-top: 20px; box-shadow: 0px 60px 30px -5px rgba(50, 50, 50, 0.94);';
        //$footerStyle          = 'background-color: #f5f5f5; border-top: 1px solid #ddd; padding-top: 20px; box-shadow: 0px 70px 15px 0px rgba(50, 50, 50, 0.94);';
        $footerStyle          = 'background-color: #f5f5f5; border-top: 1px solid #ddd; padding-top: 20px; box-shadow: 0px 70px 15px 0px rgba(50, 50, 50, 0.94);';
        //$footerStyle          = 'background-color: #6a736a; border-top: 1px solid #ddd; padding-top: 20px; box-shadow: 0px 70px 15px 0px rgba(50, 50, 50, 0.94);';
        $footerClass          = 'container';
        $footerContainerStyle = 'margin: 10px;';
        break;
}

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(($this->title != Yii::$app->params['companyNameShort'] ? Yii::$app->params['companyNameShort'] . ' - ' : '') . $this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="<?= Yii::$app->homeUrl; ?>favicon.ico" type="image/x-icon" />
</head>
<body style="<?= $bgStyle ?>">
    
    <!--[if lt IE 9]>
        <script src="<?= Yii::$app->homeUrl; ?>lib/jquery-1.12.0.min.js"></script>
        <script src="<?= Yii::$app->homeUrl; ?>js/bootstrap.js"></script>
        <div class="alert alert-danger" role="alert">
            <h1>YOUR BROWSER IS OUT-OF-DATE</h1>
            <p>PLEASE UPGRADE TO <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">INTERNET EXPLORER 9</a> OR NEWER, <br>
            OR USE <a href="https://www.mozilla.org/firefox">FIREFOX</a> OR <a href="https://www.google.com/chrome/browser/">CHROME</a> 
            TO VIEW THE FULL CONTENT OF THIS SITE.
            </p>
        </div>
    <![endif]-->
    <!--[if gte IE 9 | (!IE)]><!-->
        
    <!--<![endif]-->

    <?php
        //echo '<pre>';
        //var_dump(Yii::$app->user);
        //if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin())
        //{
        //    echo "ADMIN USER";
        //    var_dump(Yii::$app->user->identity);
        //}            
        //echo '/<pre>';
    ?>
    <?php $this->beginBody() ?>
    
    <!-- Logo -->
    <div class="container" style="<?= $logoBannerStyle ?>">
      <img src="<?= Yii::$app->homeUrl; ?>img/frontpage/logo.png" style="margin: 10px" valign="left">
      <p class="pull-right" style="margin-top: 5px; margin-right: 20px;">
            <?php UtilsProvider::getGoogleTranslateDropdown(); ?>&nbsp;&nbsp;  
      </p>
    </div>
    
    <div class="<?= $contentNavbarClass ?>" style="<?= $contentNavbarStyle ?>">
        <?php
            $iconLocked   = (isset(Yii::$app->user->identity) ? '' : '<span class="glyphicon glyphicon-lock d-icon"></span> ' );
            $iconUnlocked = (isset(Yii::$app->user->identity) ? '' : '<span class="glyphicon glyphicon-ok-circle d-icon"></span> ' );
            
            NavBar::begin([
                //'brandLabel' => 'Acme, Inc.',
                //'brandLabel' => Yii::$app->params['companyNameShort'],
                //'brandLabel' => '<img src="'.Yii::$app->homeUrl.'img/frontpage/logo.png" style="margin: -10px; height: 40px;" valign="left">',
                //'brandUrl'   => Yii::$app->homeUrl,
                'options' => [
                    //'class' => 'navbar navbar-inverse navbar-fixed-top',  // dark theme
                    //'class' => 'navbar navbar-default',                   // light theme
                    'class' => 'navbar navbar-inverse',                     // dark theme
                ],
                //'submenuOptions' => ['target' => '_blank'],  // to go blank tab for each menu item
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About Us', 'url' => ['/site/about'],
                    'items' => [
                            ['label' => 'Who We Are & Our Mission', 'url' => ['/site/about']],
                            //['label' => 'International',  'url' => ['site/international']],
                            ['label' => 'International',    'url' => ['distributor/index']],
                            //['label' => 'News',           'url' => ['/content/index', 'category'=>'news', 'id'=>'10']],
                            //['label' => 'News',           'url' => Url::to(['/content/index', 'category'=>'news', 'linkOptions' => ['data-method' => 'post']])],
                            ['label' => 'News',             'url' => ['/content/index', 
                                'category'=>'news', 'section'=>'site/about', 'ord'=>'desc', 'by'=>'created_at'
                            ]],
                    ]],
                ['label' => 'Products', 'url' => ['/product/index'],
                    'items' => [
                            ['label' => 'Hearing Aid Styles',   'url' => Url::to(['content/index', 'category'=>'product-styles'])],
                            //['label' => 'Water Resistance',     'url' => ['content/index', 'category'=>'product-water-resistance']],
                            ['label' => 'Water Resistance',     'url' => ['content/view', 'id'=>18]],
                            '<li role="presentation" class="divider"></li>',     // divider
                            ['label' => 'Custom',               'url' => ['content/index', 'category'=>'products', 'tags'=>'Custom']],
                            ['label' => 'Open Fit',             'url' => ['content/index', 'category'=>'products', 'tags'=>'Open Fit']],
                            ['label' => 'Behind-The-Ear (BTE)', 'url' => ['content/index', 'category'=>'products', 'tags'=>'BTE']],
                            ['label' => 'Super Power',          'url' => ['content/index', 'category'=>'products', 'tags'=>'Super Power']],
                            ['label' => 'Stock ITC',            'url' => ['content/index', 'category'=>'products', 'tags'=>'Stock ITC']],
                            ['label' => 'Linear Custom',        'url' => ['content/index', 'category'=>'products', 'tags'=>'Linear']],
                            ['label' => 'Pre-Wire Kits',        'url' => ['content/index', 'category'=>'products', 'tags'=>'Pre-wire Kit']],
                            //['label' => 'Wireless',             'url' => ['content/index', 'category'=>'products', 'tags'=>'Wireless']],
                            //'<li role="presentation" class="divider"></li>',     // divider
                            //['label' => 'In-ear Monitors',      'url' => ['content/index', 'category'=>'products', 'tags'=>'In-ear Monitors']],
                            //['label' => 'Ear Protection',       'url' => ['content/index', 'category'=>'products', 'tags'=>'Ear Protection']],
                    ]],
                ['label' => 'Professionals', 'url' => ['/professional/index'],
                    'items' => [
                            ['label' => $iconUnlocked . 'Overview',                'url' => ['/professional/index']],
                            ['label' => $iconUnlocked . 'Testimonials ',           'url' => ['/professional/testimonials']],
                            //['label' => $iconLocked . 'Product Overview',          'url' => ['/professional/product-overview']],
                            //['label' => $iconLocked . 'Product Specifications',  'url' => Yii::$app->params['companyWebsite'].'/catalog'],
                            ['label' => $iconLocked . 'Product Specifications',    'url' => ['/professional/product-specs']],
                            ['label' => $iconUnlocked . 'Cable Reference',         'url' => ['/professional/cable-reference']],
                            //['label' => $iconUnlocked . 'Connectivity',         'url' => ['/professional/connectivity']],
                            ['label' => $iconUnlocked . 'Software',                'url' => ['/professional/software']],
                            //['label' => $iconLocked . 'OASIS Software',          'url' => ['/professional/software-oasis']],
                            //['label' => $iconLocked . 'Technical Manual',        'url' => Yii::$app->params['companyWebsite'].'/techman'],
                            ['label' => $iconLocked . 'Technical Manual',          'url' => ['/professional/technical-manual']],
                            ['label' => $iconLocked . 'Printable Forms',           'url' => ['/professional/printable-forms']],
                            ['label' => $iconLocked . 'Marketing Materials',       'url' => ['/professional/marketing-materials']],
                            //'<li role="presentation" class="divider"></li>',     // divider
                            
                            //['label' => 'Order Stock/BTE/Pre-Wire Kits',        'url' => ['/professional/order-prewirekit']],
                            //'<li role="presentation" class="divider"></li>',     // divider
                            
                            //$isModuleDealersInstalled ? ['label' => $iconUnlocked . 'Dealer Application', 'url' => ['/dealers/dealer/create']] : '',
                            //$isModuleDealersInstalled ? '<li role="presentation" class="divider"></li>' : '',  // divider
                            
                            //['label' => 'Order Custom',                         'url' => ['/professional/order-custom']],
                            //'<li role="presentation" class="divider"></li>',     // divider
                            
                            //['label' => $iconUnlocked . 'Workshops & Conventions', 'url' => Yii::$app->params['companyWebsite'].'/workshopmgr/workshops',
                            //    'linkOptions' => ['target' => '_blank']
                            //],
                            //['label' => $iconUnlocked . 'Workshop Registration',   'url' => Yii::$app->params['companyWebsite'] . '/workshopmgr/registrations/add', 
                            //    'linkOptions' => ['target' => '_blank']
                            //],
                    ]],
                ['label' => 'Hearing & You', 'url' => ['/consumer/index'],
                    'items' => [
                            ['label' => 'Hearing Loss',                   'url' => ['content/index', 'category'=>'consumers']],
                            //['label' => 'Testimonials',                   'url' => ['consumer/testimonials']],
                            ['label' => 'Hearing Associations',           'url' => ['consumer/hearing-associations']],
                            ['label' => 'Product Brochures & Manuals',    'url' => ['consumer/product-brochures']],
                            ['label' => 'Find a Professional in my Area', 'url' => ['consumer/find-professional']],
                    ]],
                //['label' => 'Contact Us', 'url' => ['/site/contact']],
                ['label' => 'Contact Us', 'url' => ['/site/contact-us']],
            ];
            
            //if (isset(Yii::$app->user->identity) && (!Yii::$app->user->identity->isAdmin())) {
            //    $menuItems[] = ['label' => 'User Profile', 'url' => ['user/view', 'id'=>Yii::$app->user->getId()]];
            //}
            
            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
                $menuItems[] = ['label' => 'Admin', 'url' => '',
                    'items' => [
                        ['label' => 'Dashboard', 'url' => ['site/admin-dashboard']],
                        (Yii::$app->getModule('gii') && ArrayHelper::isIn(Yii::$app->request->userIP, Yii::$app->getModule('gii')->allowedIPs)) ?
                            ['label' => 'Gii', 'url' => ['/gii']] : '',
                        ['label' => 'Users', 'url' => ['user/index']],
                        '<li role="presentation" class="divider"></li>',
                        
                        ['label' => 'Articles', 'url' => ['content/admin-index']],
                        ['label' => 'Carousel', 'url' => ['content/carousel-index']],
                        //['label' => 'Galleries', 'url' => ['/gallery']],
                        ['label' => 'MOTD', 'url' => ['content/motd-index']],
                    ]
                ];
            }

            if (Yii::$app->user->isGuest) {
                if (Yii::$app->params['isSignupAllowed']) {
                    $menuItems[] = ['label' => 'Signup', 'url' => ['/user/signup']];
                }
                $menuItems[] = ['label' => 'Login',  'url' => ['/site/login']];
            } else {
                //$menuItems[] = [
                //    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                //    'url' => ['/site/logout'],
                //    'linkOptions' => ['data-method' => 'post']
                //];
                $menuItems[] = ['label' => 'User (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/login'],
                    'items' => [
                        ['label' => 'User Profile', 'url' => ['user/view', 'id'=>Yii::$app->user->getId()]],
                        //['label' => 'Account Balance', 'url' => ['/account-aging/view']],
                        //['label' => 'Payment', 'url' => ['/payment/create']],
                        '<li role="presentation" class="divider"></li>',     // divider
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                    ]
                ];
            }
            
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,  // to allow icons in labels
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>
        
        <?php //echo '<pre>'.print_r(Yii::$app->user->identity, true).'</pre>'; ?>
        
        <div class="container" style="<?= $contentStyle ?>">
        <?= \app\widgets\MotdAlert::widget() ?>

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    
        <?= \app\widgets\Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>
    
    <footer class="<?= $footerClass ?>" style="<?= $footerStyle ?>">
        <div class="container" style="<?= $footerContainerStyle ?>">
        <p class="pull-left"><small>
            &copy; <?= date('Y') ?>, 
            <?= Yii::$app->params['companyName'] ?>
            | <?= Html::a('Privacy Policy', urldecode(Url::toRoute(['site/privacy'])) ) ?>
            <?= (!empty(Yii::$app->params['urlWebmail'])        ? "| <a href='". Yii::$app->params['urlWebmail']."' target='_blank'>WebMail</a>" : '') ?> </small>
            <?= (!empty(Yii::$app->params['urlSocialFacebook']) ? "| &nbsp;&nbsp;<a class='facebook' href='". Yii::$app->params['urlSocialFacebook']."' target='_blank'><img src='". Yii::$app->homeUrl."img/frontpage/social-facebook.png'></a>": '' ) ?>
            <?= (!empty(Yii::$app->params['urlSocialYoutube'])  ? "<a class='youtube' href='". Yii::$app->params['urlSocialYoutube']."' target='_blank'><img src='".Yii::$app->homeUrl."img/frontpage/social-youtube.png'></a>": '' ) ?>
        </p>
        
        <p class="pull-right" style="margin-top: 5px; margin-right: 20px;">
            <?php //UtilsProvider::getGoogleTranslateDropdown(); ?>&nbsp;&nbsp;  
        </p>
        </div>
    </footer>
    
    <?php if (Yii::$app->params['enableWebAnalytics']): ?>
        <!-- Piwik: Web Analytics --> 
        <script type="text/javascript">
            var pkBaseURL = (("https:" == document.location.protocol) ? "<?= Yii::$app->params['companyWebsiteSecure'] ?>/webanalytics/" : "<?= Yii::$app->params['companyWebsite'] ?>/webanalytics/");
            document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            try {
                var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
                piwikTracker.trackPageView();
                piwikTracker.enableLinkTracking();
            } catch( err ) {}
        </script>
        <noscript><p><img src="<?= Yii::$app->params['companyWebsiteSecure'] ?>/webanalytics/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
        <!-- End Piwik Tracking Code -->
    <?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

