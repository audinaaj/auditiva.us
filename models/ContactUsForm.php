<?php

namespace app\models;

use Yii;
use yii\base\Model;
use himiklab\yii2\recaptcha\ReCaptchaValidator;

use app\models\SpamFilter;

/**
 * ContactUsForm is the model behind the contact form.
 */
class ContactUsForm extends ContactForm
{
    public $firstName;
    public $lastName;
    public $email;
    public $telephone;
    public $city;
    public $state;
    public $zipCode;
    public $country;
    public $helpCategory;
    public $productSerialNumbers;   // Product Serial Numbers (if available)
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['firstName', 'lastName', 'email', 'subject', 'body'], 'required'],
            [['telephone', 'city', 'state', 'zipCode', 'country', 'productSerialNumbers'], 'string',  'max' => 255],
            [['helpCategory'], 'safe'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            //['verifyCode', 'captcha'],  // yii2 default captcha
            ['verifyCode', ReCaptchaValidator::className(), 'uncheckedMessage' => 'The verification code is incorrect.'],  // Google reCaptcha
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $dstEmail the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($dstEmail)
    {
        $isSpam = $this->isEmailSpam();
        if ($isSpam) {
            //return false;  // message not sent because it looks spammy
            $this->subject = "[SPAM]: " . $this->subject;
            //Yii::trace("### SPAM ###: subject: [{$this->subject}]", __METHOD__);
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');  // Do not proceed handling spam
        } else {
            $this->subject = "Website Contact: " . $this->subject;
            //Yii::trace("### NO SPAM ###: subject: [{$this->subject}]", __METHOD__);
        }
        
        $origMessage = $this->body; // save original message
        $isMessageSent = false;
        
        $useHtmlTemplate = true;
        if (isset($useHtmlTemplate) && $useHtmlTemplate) {
            //--------------------------------
            // Send with HTML template
            //--------------------------------
            $isMessageSent = Yii::$app->mailer->compose('contactUs', ['form' => $this, 'message' => $origMessage])
                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']])
                ->setTo( ($isSpam ? Yii::$app->params['debugEmail'] : $dstEmail) )  
                ->setBcc([
                    Yii::$app->params['adminEmail'] => Yii::$app->params['companyNameShort'] . ' Support', 
                    Yii::$app->params['debugEmail'] => 'Debug Email'
                ])
                ->setSubject($this->subject)
                ->send();
        } else {
            //--------------------------------
            // Send with Plain Text template
            //--------------------------------
            // Prepend all fields to original message
            $this->body = "";
            // Send an email copy to submitter (other than admin), with this message
            $this->body .= "Thank you, {$this->firstName} {$this->lastName}.   We appreciate your submission.\n";
            $this->body .= "We will contact you within two (2) business days, if necessary.\n";
            $this->body .= "For your records, these are the contents of your message:\n";
            $this->body .= "--------------\n";
            $this->body .= "First Name: {$this->firstName}\n";
            $this->body .= "Last Name: {$this->lastName}\n";
            $this->body .= "E-mail: {$this->email}\n";
            $this->body .= "Telephone: {$this->telephone}\n";
            $this->body .= "City: {$this->city}\n";
            $this->body .= "State: {$this->state}\n";
            $this->body .= "ZIP: {$this->zipCode}\n";
            $this->body .= "Country: {$this->country}\n";
            $this->body .= "\n";
            $this->body .= "Subject: {$this->subject}\n";
            $this->body .= "Category: {$this->helpCategory}\n\n";
            $this->body .= "Message: \n";
            $this->body .= "{$origMessage}\n";
            $this->body .= "\n";
            $this->body .= "Serial Numbers: {$this->productSerialNumbers}\n";
            $this->body .= "IP Address: ".Yii::$app->request->userIP."\n";

            $message = Yii::$app->mailer->compose();
            
            if (Yii::$app->user->isGuest) {
                // Format: email or [email => name] 
                //$message->setFrom([$this->email => $this->name]);
                //$message->setFrom([$this->email => $this->firstName . ' ' . $this->lastName]);  // user-entered email not supported in some servers
                $message->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']]);  
            } else {
                // Format: email or [email => name] 
                //$message->setFrom(Yii::$app->user->identity->email);
                //$message->setFrom([Yii::$app->user->identity->email => $this->firstName . ' ' . $this->lastName]);
                //$message->setFrom([$this->email => $this->firstName . ' ' . $this->lastName]);  // user-entered email not supported in some servers
                $message->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']]);  
            }
            $isMessageSent = $message->setTo( ($isSpam ? Yii::$app->params['debugEmail'] : $dstEmail) ) 
                ->setBcc([
                    Yii::$app->params['adminEmail'] => Yii::$app->params['companyNameShort'] . ' Support', 
                    Yii::$app->params['debugEmail'] => 'Debug Email'
                ])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
        }
            
        return $isMessageSent;
    }
    
    /**
     * Checks if this email message is spam.
     *
     * @return boolean whether the email is spam
     */
    private function isEmailSpam()
    {
        // initialize
        $isSpam = false;
        
        $email_fields = [
            $this->email, $this->city, $this->subject, $this->body
        ];
        
        // $spam_keywords = \app\models\SpamFilter::getDefaultSpamKeywords();
        //
        // // Check for spam
        // if ($this->firstName == $this->lastName) {
        //     // Check for spam: Duplicate fields
        //     $isSpam = true;
        //     
        // } else {
        //     // Check for spam: Keywords
        //     //foreach($spam_keywords as $keyword) {
        //     //    foreach($email_fields as $email_field) {
        //     //        if (!empty($email_field)) {
        //     //            Yii::trace("### CHECK ###: keyword [{$keyword}] => ASCII field [{$email_field}].", __METHOD__);
        //     //            if (stripos(trim($email_field), $keyword) !== false) {
        //     //                $isSpam = true;
        //     //                break;
        //     //            }
        //     //        }
        //     //    }
        //     //    if ($isSpam) { break; }
        //     //}
        //     $isSpam = \app\models\SpamFilter::hasSpam($email_fields);
        // }
        $isSpam = \app\models\SpamFilter::hasSpam($email_fields);
        
        //if ($isSpam) { Yii::trace("### SPAM ###: keyword [{$keyword}] found in field [{$email_field}].", __METHOD__); }
        
        return $isSpam;
    }
}
