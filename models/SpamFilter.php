<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "spam_filter".
 *
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string $keywords
 * @property int $status
 */
class SpamFilter extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'spam_filter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keywords'], 'string'],
            [['name', 'category'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('app', 'ID'),
            'name'     => Yii::t('app', 'Name'),
            'category' => Yii::t('app', 'Category'),
            'keywords' => Yii::t('app', 'Keywords'),
            'status'   => Yii::t('app', 'Status'),
        ];
    }
    
    /**
     * Get spam keyword array.
     *
     * @return array List of spam keywords.
     */
    public static function getDefaultSpamKeywords()
    {
        $spam_keywords = [];
        $spam_filters = self::find()->where(['status' => self::STATUS_ACTIVE])->asArray()->all();
        
        if (!empty($spam_filters)) {
            // Extract spam keywords from spam filters
            foreach($spam_filters as $filter) {
                $spam_keywords = array_merge( $spam_keywords, explode("," , $filter['keywords']) );
            }
        } else {
            // Generate default spam keyword list, since we did not find any spam filters
            $spam_keywords = [
                // Typical spam HTML tags or entities
                'a href=', 'http://', 'https://', 'sales@', 'noreply@', 
                
                // Dangerous or nuissance files
                '.exe', '.cgi', '.csv', '.gz', '.jar', '.json', '.mp3', '.pdf', '.php', '.ppt', '.sql', '.xls', '.xml', '.zip', 
                
                // UTF8
                'домашний', 
                
                // Sample spam (use for testing)
                //'Считается, что повышенный уровень глюкозы в крови является главной причиной развития диабета 2-го типа. Однако немецкие ученые доказали: резистентность клеток к инсулину может быть вызвана увеличением концентрации в крови метилглиоксаля (MG) - метаболита глюкозы. Подробнее читайте на сайте <a href=http://dom-lady.ru>dom-lady.ru</a>'
                
                // Known spam sentences
                '24-7', 'Business Capital', 'Capital for Your Business', 'client development', 'company name', 
                'email marketing', 'free trial', 'job title', 
                'Made in Germany', 'marketing executive', 'online marketing', 'SBA Capital', 'subject line',
                'target industry', 'trial period', 'US Food and Drug Administration',
                
                // Typical spam TLD or geo-origin
                '.ru', 
                'Belarus', 'Mосква', 'Russia',
                
                // Unrelated professions
                'allergist', 'cardiologist', 'chiropractor', 
                'dentist', 'dermatologist', 'diagnostic', 'endocrinologist', 
                'gynecologist', 'gynecology', 
                'laboratory', 'medical', 'neurologist', 
                'obstetric', 'oncologist', 'orthopedic', 'osteopathic',  
                'pediatrician', 'physician', 'radiologist', 'surgeon', 
                
                // Typical spam words
                'Amoxicillin', 'apply', 'Bentyl', 'bets', 'biotechnology', 'branding', 'capital', 'casino', 'cassino', 'cialis', 
                'competitive', 'compliance', 'consolidation', 'credit', 'debt', 'diarrhea', 'drug', 
                'essay', 'free', 'Google', 'hosting', 'loan', 'lucrative', 'marketing', 'medicine', 'no-cost', 
                'outsource', 'slots', 'pharmaceutical', 'pharmacy', 'plagiarism', 'unsubscribe', 'viagra',
            ];
        }
        
        return $spam_keywords;
    }
    
    /**
     * Checks if this email message is spam.
     * $params array $fields  Array of fields. Eg:
     *    $fields = [
     *        $this->email, $this->city, $this->subject, $this->body
     *    ];
     * @return boolean whether the email is spam
     */
    public static function hasSpam($fields)
    {
        // initialize
        $isSpam = false;
        
        $spam_keywords = self::getDefaultSpamKeywords();
        
        // Check for spam patterns
        if (self::hasDuplicates($fields)) {
            // Check for spam: Duplicate fields
            $isSpam = true;
        } else {
            // Check for spam keywords
            foreach($spam_keywords as $keyword) {
                foreach($fields as $field) {
                    if (!empty($field)) {
                        //Yii::trace("### CHECK ###: keyword [{$keyword}] => field data [{$field}].", __METHOD__);
                        if (stripos(trim($field), $keyword) !== false) {
                            Yii::trace("### FOUND ###: keyword [{$keyword}] => field data  [{$field}].", __METHOD__);
                            $isSpam = true;
                            break;
                        }
                    }
                }
                if ($isSpam) { break; }
            }
        }
        
        //if ($isSpam) { Yii::trace("### SPAM ###: keyword [{$keyword}] found in field [{$field}].", __METHOD__); }
        
        return $isSpam;
    }
    
    /**
     * Check if list of field contains a duplicate
     */
    private static function hasDuplicates($fields)
    {
        $isDuplicate = false;
        $i = 0;
        
        foreach($fields as $field) {
            $testFields = $fields;
            unset($testFields[$i++]);  // remove current field from test list
            $isDuplicate = (in_array($field, $testFields));
            if ($isDuplicate) { 
                Yii::trace("### FOUND ###: duplicate [{$field}] found in [".implode("|",$fields)."].", __METHOD__);
                break; 
            }
        }
        return $isDuplicate;
    }
    
    private static function isBlacklisted($ip_address)
    {
        // Query StopForumSpam server.
        // Eg: http://api.stopforumspam.org/api?ip=46.161.9.18
        //
        // Response:
        //   <response success="true">
        //       <type>ip</type>
        //       <appears>yes</appears>
        //       <lastseen>2018-05-16 20:56:45</lastseen>
        //       <frequency>255</frequency>
        //   </response>
    }
}
