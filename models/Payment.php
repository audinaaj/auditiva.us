<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "payment".
 *
 * @property integer $id
 * @property string $full_name
 * @property string $company_name
 * @property string $address
 * @property string $city
 * @property string $state_prov
 * @property string $postal_code
 * @property string $country
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property string $account_number
 * @property string $amount
 * @property string $description
 * @property string $payment_date
 * @property string $payment_status
 * @property string $crcard_type
 * @property string $crcard_number
 * @property string $crcard_first_name
 * @property string $crcard_last_name
 * @property string $trans_id
 * @property string $trans_invoice_num
 * @property string $trans_description
 * @property string $trans_response
 * @property string $ip_address
 * @property string $notes
 * @property string $created_at
 * @property string $updated_at
 * @property integer $active
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property string $crcard_plain_number
 * @property string $crcard_security_code
 * @property string $crcard_expiration_month
 * @property string $crcard_expiration_year
 * @property string $crcard_use_contact_address
 * @property string $crcard_billing_address
 * @property string $crcard_billing_city
 * @property string $crcard_billing_state_prov
 * @property string $crcard_billing_postal_code
 * @property string $crcard_billing_country
 */
class Payment extends \yii\db\ActiveRecord
{
    //public crcard_type;
    public $crcard_plain_number;
    public $crcard_security_code;
    public $crcard_expiration_month;
    public $crcard_expiration_year;
    public $crcard_use_contact_address;
    public $crcard_billing_address;
    public $crcard_billing_city;
    public $crcard_billing_state_prov;
    public $crcard_billing_postal_code;
    public $crcard_billing_country;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'payment';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        date_default_timezone_set( 
          (!empty(Yii::$app->params['timezone']) ? Yii::$app->params['timezone'] : 'America/New_York') 
        );
     
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at', // OR 'create_time', to override default field name
                'updatedAtAttribute' => 'updated_at', // OR 'update_time', to override default field name
                'value' => new \yii\db\Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',  // OR 'author_id', to override default field name
                'updatedByAttribute' => 'updated_by',  // OR 'updater_id', to override default field name
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'full_name', 'address', 'city', 'state_prov', 'postal_code', 'email', 'crcard_type', 'crcard_number', 'crcard_first_name', 'crcard_last_name',
                'crcard_plain_number', 'crcard_security_code', 'crcard_expiration_month', 'crcard_expiration_year', 
            ], 'required'],
            
            [['payment_date', 'created_at', 'updated_at'], 'safe'],
            [['trans_response', 'notes'], 'string'],
            [['active', 'created_by', 'updated_by'], 'integer'],
            
            [[
                'full_name', 'company_name', 'address', 'city', 'state_prov', 'postal_code', 'country', 'email', 'description', 
                'payment_status', 'crcard_type', 'crcard_number', 'crcard_first_name', 'crcard_last_name',
                'trans_id', 'trans_invoice_num', 'trans_description', 'ip_address',
                'crcard_plain_number', 'crcard_security_code', 'crcard_expiration_month', 'crcard_expiration_year', 'crcard_use_contact_address',
                'crcard_billing_address', 'crcard_billing_city', 'crcard_billing_state_prov', 'crcard_billing_postal_code', 'crcard_billing_country', 
            ], 'string', 'max' => 255],
            
            [['phone', 'fax', 'account_number', 'amount'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('app', 'ID'),
            'full_name'         => Yii::t('app', 'Full Name'),
            'company_name'      => Yii::t('app', 'Company Name'),
            'address'           => Yii::t('app', 'Address'),
            'city'              => Yii::t('app', 'City'),
            'state_prov'        => Yii::t('app', 'State / Province'),
            'postal_code'       => Yii::t('app', 'ZIP / Postal Code'),
            'country'           => Yii::t('app', 'Country'),
            'email'             => Yii::t('app', 'Email'),
            'phone'             => Yii::t('app', 'Phone'),
            'fax'               => Yii::t('app', 'Fax'),
            'account_number'    => Yii::t('app', 'Account Number'),
            'amount'            => Yii::t('app', 'Amount'),
            'description'       => Yii::t('app', 'Description'),
            'payment_date'      => Yii::t('app', 'Payment Date'),
            'payment_status'    => Yii::t('app', 'Payment Status'),
            'crcard_type'       => Yii::t('app', 'Credit Card Type'),
            'crcard_number'     => Yii::t('app', 'Credit Card Number'),
            'crcard_first_name' => Yii::t('app', 'Credit Card Full Name'),
            'crcard_last_name'  => Yii::t('app', 'Credit Card Last Name'),
            'trans_id'          => Yii::t('app', 'Transaction ID'),
            'trans_invoice_num' => Yii::t('app', 'Transaction Invoice Num'),
            'trans_description' => Yii::t('app', 'Transaction Description'),
            'trans_response'    => Yii::t('app', 'Transaction Response'),
            'ip_address'        => Yii::t('app', 'IP Address'),
            'notes'             => Yii::t('app', 'Notes'),
            'created_at'        => Yii::t('app', 'Created At'),
            'updated_at'        => Yii::t('app', 'Updated At'),
            'active'            => Yii::t('app', 'Active'),
            'created_by'        => Yii::t('app', 'Created By'),
            'updated_by'        => Yii::t('app', 'Updated By'),
            
            'crcard_plain_number'        => Yii::t('app', 'Credit Card Number'), 
            'crcard_security_code'       => Yii::t('app', 'Credit Card Security Code'), 
            'crcard_expiration_month'    => Yii::t('app', 'Credit Card Expiration Month'), 
            'crcard_expiration_year'     => Yii::t('app', 'Credit Card Expiration Year'), 
            'crcard_use_contact_address' => Yii::t('app', 'Credit Card Use Contact Address'),
            'crcard_billing_address'     => Yii::t('app', 'Credit Card Billing Address'), 
            'crcard_billing_city'        => Yii::t('app', 'Credit Card Billing City'), 
            'crcard_billing_state_prov'  => Yii::t('app', 'Credit Card Billing State / Province'), 
            'crcard_billing_postal_code' => Yii::t('app', 'Credit Card Billing ZIP / Postal Code'), 
            'crcard_billing_country'     => Yii::t('app', 'Credit Card Billing Country')
        ];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Format and clean some fields
            $this->crcard_number = "XXXX" . substr($this->crcard_plain_number, -4);  // store CR card's last 4-digits
            $this->amount        = $this->cleanValueString($this->amount);

            return true;
        } else {
            return false;
        }
    }
    
    private function cleanValueString($aValue)
    {
        $aValue = strtoupper(str_replace(' ', '', trim(strval($aValue))));
        $aValue = str_replace('$', '', $aValue);
        $aValue = str_replace('-', '', $aValue);
        return $aValue;
    }
    
    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($dstEmail)
    {
        $subject = "Payment";
        $isMessageSent = false;

        $useHtmlTemplate = true;
        if (isset($useHtmlTemplate) && $useHtmlTemplate) {
            //--------------------------------
            // Send with HTML template
            //--------------------------------
            $isMessageSent = Yii::$app->mailer->compose('payment', ['model' => $this])
                ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']])
                ->setTo($dstEmail)
                ->setBcc([
                    Yii::$app->params['adminEmail'] => Yii::$app->params['companyNameShort'] . ' Support',
                    Yii::$app->params['debugEmail'] => 'Debug Email'
                ])
                ->setSubject($subject)
                ->send();
        } else {
            //--------------------------------
            // Send with Plain Text template
            //--------------------------------
            $body = "";
            // Send an email copy to submitter (other than admin), with this message
            $body .= "Thank you, {$this->full_name}.   We appreciate your payment.\n";
            $body .= "For your records, this is your receipt:\n";
            $body .= "--------------\n";
            $body .= "Payee / Billing Address:\n";
            $body .= "Contact Name: {$this->full_name} \n";
            $body .= "Account Number: {$this->account_number} \n";
            $body .= "\n";
            $body .= "E-mail: {$this->email} \n";
            $body .= "Telephone: {$this->phone} \n";
            $body .= "\n";
            $body .= "Address: {$model->address} \n";
            $body .= "City: {$model->city} \n";
            $body .= "State/Province: {$model->state_prov} \n";
            $body .= "ZIP / Postal Code: {$model->postal_code} \n";
            $body .= "Country: {$model->country} \n";
            $body .= "\n";

            $body .= "Transaction Details\n";
            $body .= "Amount: {$model->amount} \n";
            $body .= "Description:{$model->description} \n";
            $body .= "Payment Date: {$model->payment_date} \n";
            $body .= "Payment Status: ".($model->paymentent_status ? "Paid": "Unpaid") ."\n";
            $body .= "Credit Card Type: {$model->crcard_type} \n";
            $body .= "Credit Card Num:{$model->crcard_number} \n";
            $body .= "Transaction ID: {$model->trans_id} \n";
            $body .= "Transaction Invoice:{$model->trans_invoice_num} \n";
            $body .= "Transaction Description:{$model->trans_description} \n";
            $body .= "Transaction Response: {$model->trans_response} \n";

            $message = Yii::$app->mailer->compose();

            if (Yii::$app->user->isGuest) {
                // Format: email or [email => name]
                // Note: User-entered email not supported in some servers.
                $message->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']]);
            } else {
                // Format: email or [email => name]
                // Note: User-entered email not supported in some servers.
                $message->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->params['companyName']]);
            }
            $isMessageSent = $message->setTo($dstEmail)
                ->setBcc([
                    Yii::$app->params['adminEmail'] => Yii::$app->params['companyNameShort'] . ' Support',
                    Yii::$app->params['debugEmail'] => 'Debug Email'
                ])
                ->setSubject($subject)
                ->setTextBody($body)
                ->send();
        }

        return $isMessageSent;
    }
}
