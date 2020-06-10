<?php
// Usage: Yii::$app->params['myparam'];
return [
    'appId'                         => 'app_website',
    'appName'                       => 'Website',
    'appNameShort'                  => 'Website',
    'companyName'                   => 'Acme, Inc.',
    'companyNameShort'              => 'Acme',
    'companyAddress'                => '123 Main St, Maplewood, VA 12345, United States',
    'companyEmail'                  => 'info@acme.com',
    'companyPhone'                  => '800-123-ACME',
    'companyFax'                    => '800-123-ACME',
    'companyWebsite'                => 'http://www.acme.com',
    'companyWebsiteSecure'          => 'https://secure.acme.com',
    'adminEmail'                    => 'admin@acme.com',
    'supportEmail'                  => 'support@acme.com',
    'debugEmail'                    => 'support@acme.com',
    'urlWebmail'                    => 'https://outlook.office365.com/owa/?realm=acme.com',
    'urlSocialFacebook'             => 'https://www.facebook.com/acme',
    'urlSocialYoutube'              => 'http://www.youtube.com/user/acme',
    'urlSocialTwitter'              => 'https://twitter.com/acme',
    'user.passwordResetTokenExpire' => 3600,
    'isSignupAllowed'               => false, // allows user to signup
    'isSignupApprovalRequired'      => false, // allows user to signup and login right away
    //'isSignupApprovalRequired'    => true,  // requires sending email to admin to request signup approval
    'timezone'                      => 'America/New_York',  // Must be a valid PHP timezone.  See: http://php.net/manual/en/timezones.php
    'siteLayout'                    => 'default',  // ['full', 'default_white', 'default_gray', 'default']
    'authorizenetAPILoginId'        => "YOURLOGIN",
    'authorizenetTransactionKey'    => "YOURKEY",
    'authorizenetTestMode'          => true,
    'authorizenetSandbox'           => true,
    'enableWebAnalytics'            => false,
    
    'cookieKey' => '',
    'recaptchaSiteKeyv2' => '',
    'recaptchaSecretv2' => '',
    'recaptchaSiteKeyv3' => '',
    'recaptchaSecretv3' => '',
];
