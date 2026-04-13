<?php
$params = [
    'appId'                         => 'app-auditiva',
    'appName'                       => 'Auditiva Website',
    'appNameShort'                  => 'Auditiva',
    'companyName'                   => 'Auditiva, Inc.',
    'companyNameShort'              => 'Auditiva',
    'companyAddress'                => '165 E. Wildmere Ave, Longwood, FL 32750, United States',
    'companyEmail'                  => 'info@auditiva.us',
    'companyPhone'                  => '800-223-7700, 407-331-0077',
    'companyFax'                    => '407-331-1141',
    'companyWebsite'                => 'http://www.auditiva.us',
    'companyWebsiteSecure'          => 'https://www.auditiva.us',
    'adminEmail'                    => 'info@auditiva.us',
    'supportEmail'                  => 'webmaster@auditiva.us',
    'debugEmail'                    => 'software@audina.net',
    'urlWebmail'                    => '',
    'urlSocialFacebook'             => '',
    'urlSocialYoutube'              => 'https://www.youtube.com/channel/UCDnwW290SWy-PXE3O0bkG7A',
    'urlSocialTwitter'              => '',
    'user.passwordResetTokenExpire' => 3600,
    'isSignupAllowed'               => false, // allows user to signup
    'isSignupApprovalRequired'    => true,  // requires sending email to admin to request signup approval
    'timezone'                      => 'America/New_York',  // Must be a valid PHP timezone.  See: http://php.net/manual/en/timezones.php
    'siteLayout'                    => 'default',  // ['full', 'default_white', 'default_gray', 'default']
    
    'cookieKey' => getenv('COOOKIE_KEY') ,
    'recaptchaSiteKeyv2' => getenv('RECAPTCHA_SITE_KEY'),
    'recaptchaSecretv2' => getenv('RECAPTCHA_SECRET'),

    // direct smtp credentails (used with SwiftMailer)
    'mail.username'   => getenv('MAIL_USERNAME'),
    'mail.password'   => getenv('MAIL_PASSWORD'),
    'mail.server'     => getenv('MAIL_SERVER'),

    's3.key' => getenv('S3_KEY'),
    's3.secret' => getenv('S3_SECRET'),

    'debug.allowedIPs' => [
        '127.0.0.1',     // localhost
        '::1',           // ipv6 localhost
    ],
];

// make sure there is a debug_ip before adding it to the allowedIPs array
if (!empty(getenv('DEBUG_IP'))) {
    $params['debug.allowedIPs'][] = getenv('DEBUG_IP');
}

return $params;
