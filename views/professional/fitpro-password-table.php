<?php

use yii\helpers\Html;

use app\models\UtilsFitpro;

// echo Html::a('14', ['ezfit', 'days' => 14], ['class' => 'btn btn-default']);
// echo Html::a('30', ['ezfit', 'days' => 30], ['class' => 'btn btn-default']);
echo UtilsFitpro::GetPasswordTable($days ?? 14, $version ?? UtilsFitpro::FITPRO_5);