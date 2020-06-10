<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FindProfessionalForm extends ContactForm
{
    public $firstName;
    public $lastName;
    public $email;
    public $telephone;
    public $city;
    public $state;
    public $zipCode;
    public $country;
    public $isProductUser;          // Do you currently wear hearing aids?  Yes/No
    public $productInterests;       // What are the products in which you are interested in? (choose all that apply): Hearing Aids/Bluetooth®/Other 
    public $helpType;               // How may we help you? I am looking for a location that can repair my hearing instrument. /  I am looking for a location where I can purchase your product or accessory.
    public $productSerialNumbers;   // Product Serial Numbers (if available)
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            //[['firstName', 'lastName', 'email', 'subject', 'body'], 'required'],
            [['firstName', 'lastName', 'email'], 'required'],
            [['telephone', 'city', 'state', 'zipCode', 'country', 'isProductUser', 'productSerialNumbers'], 'string',  'max' => 255],
            [['productInterests', 'helpType'], 'safe'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($dstEmail)
    {
        $this->subject = "Looking for a professional in my area";
        $isMessageSent = false;
        
        $useHtmlTemplate = true;
        if (isset($useHtmlTemplate) && $useHtmlTemplate) {
            //--------------------------------
            // Send with HTML template
            //--------------------------------
            $isMessageSent = Yii::$app->mailer->compose('findProfessional', ['form' => $this])
                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']])
                ->setTo($dstEmail)
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
            $this->body = "";
            // Send an email copy to submitter (other than admin), with this message
            $this->body .= "Thank you, {$this->firstName} {$this->lastName}.   We appreciate your submission.\n";
            $this->body .= "We will contact you within two (2) business days.\n";
            $this->body .= "For your records, these are the contents of your message:\n";
            $this->body .= "--------------\n";
            $this->body .= "I am looking for a Professional in my area.  My contact information is:\n";
            $this->body .= "First Name: {$this->firstName} \n";
            $this->body .= "Last Name: {$this->lastName} \n";
            $this->body .= "E-mail: {$this->email} \n";
            $this->body .= "Telephone: {$this->telephone} \n";
            $this->body .= "City: {$this->city} \n";
            $this->body .= "State: {$this->state} \n";
            $this->body .= "ZIP: {$this->zipCode} \n";
            $this->body .= "Country: {$this->country} \n";
            $this->body .= "\n";
            $this->body .= "Currently wear hearing aids?\n";
            $this->body .= "- {$this->isProductUser} \n";
            $this->body .= "\n";
            $this->body .= "Products interested in?\n";
            $this->body .= "- " . implode(", ", $this->productInterests) . "\n";  // array data
            $this->body .= "\n";
            $this->body .= "Type of help\n";
            $this->body .= "- {$this->helpType} \n";
            $this->body .= "\n";
            $this->body .= "Serial Numbers: {$this->productSerialNumbers} \n";

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
            $isMessageSent = $message->setTo($dstEmail)
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
}
