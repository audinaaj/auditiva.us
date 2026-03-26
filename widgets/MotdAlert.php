<?php
namespace app\widgets;

use Yii;
use Yii\helpers\Html;
use app\models\Content;
use app\models\User;

/**
 * MOTD widget renders all active  messages from the MOTD table.
 *
 */
class MotdAlert extends \yii\bootstrap\Widget
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        // Retrieve all *active* MOTDs, and order them by their ID
        $queryMOTD = Content::find()
            ->joinWith(['category', 'contentType'])
            ->where(['content_type.alias' => 'motd'])
            // published
            ->andWhere(['status' => Content::STATUS_ACTIVE])
            
            // skip 'not yet published' or expired MOTDs
            ->andWhere( 
                ['or', ['publish_up'=> null], ['<=', 'publish_up', date("Y-m-d 23:59:00")]]
            )
            ->andWhere(
                ['or', ['publish_down'=> null], ['>=', 'publish_down', date("Y-m-d 23:59:00")]]  // handle date only
            );

        if (!User::isCurrentUserAdmin()) {
            $queryMOTD = $queryMOTD->andWhere(['!=', 'content.title', 'test']);
        }

        $motdList = $queryMOTD->all();

        foreach ($motdList as $msg) {
            echo Html::beginTag('div', ['class' => 'row']) .
                    Html::beginTag('div', ['class' => $msg->getMotdStyle() . ' col-lg-12', 'role' => 'alert']) .
                        Html::beginTag('h3') .
                            (User::isCurrentUserAdmin() ? Html::a('<span class="glyphicon glyphicon-edit"></span>', ['content/update', 'id' => $msg->id]) : '') .
                            ' ' . $msg['title'] .
                        Html::endTag('h3') .
                        $msg['intro_text'] .
                    Html::endTag('div') .
                Html::endTag('div');
        }
    }
}
