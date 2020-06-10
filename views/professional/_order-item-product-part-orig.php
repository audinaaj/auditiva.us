<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\jui\DatePicker;
use app\models\Tool;
use app\models\OrderItemPrewirekit;

// Form data
$arrNumbers = [];
for($i=0; $i<=300; $i++) {
    $arrNumbers[] = $i;
}
?>

<div class="professional-order-item-part">
    
<?php if (count($orderItemsParts) > 0): ?>
    <?php foreach($orderItemsParts as $i=>$item): ?>
        <tr>
            <td><br/><?= $i+1; ?>.
                <?= Html::activeHiddenInput($item, "[$i]name", ["value" => $i]) ?>
            </td>
            <td><?= $form->field($item,"[$i]name")->label('')->dropDownList(
                    ArrayHelper::map($model->productPartList, 'id', 'description'),
                    ['prompt'=>'--Select One--']    // options
                ) ?>
                <?php if ($i > 0) : ?>
                    <p>&nbsp;</p>
                    <?= Html::a('<i class="glyphicon glyphicon-minus d-icon" aria-hidden="true"></i>' . ' Delete Item', 
                        ['professional/order-prewirekit'], 
                        [
                            'id'           => 'btn-delete-part',
                            'class'        => 'btn btn-default',
                            //'data-confirm' => "Delete this Product Part item? Item [${i}]", 
                            //'data-method'  => 'post', 
                            //'data-pjax'    => 1,
                            'data' => [
                                'method' => 'post',
                                'params' => [
                                    'category' => 'parts',
                                    'delRow'   => $i,
                                ],
                                'pjax' => 1
                            ]
                        ]) 
                    ?>
                <?php endif; ?>
            </td>
            <td><?= $form->field($item,"[$i]side")->label('')->dropDownList(
                ['N/A'=>'N/A', 'Left'=>'Left', 'Right'=>'Right']
            ) ?></td>
            <td><?= $form->field($item,"[$i]quantity")->label('')->dropDownList($arrNumbers); ?></td>
            <td><?= $form->field($item,"[$i]description")->label('') ?></td>
            <td><?= $form->field($item,"[$i]color")->label('')->dropDownList(
                //$model->getColors()
                ['Default'=>'Default', 'Pink'=>'Pink', 'Tan'=>'Tan', 'Light Brown'=>'Light Brown', 'Brown'=>'Brown']
                //['prompt'=>'--Select One--']    // options
            ) ?></td>
            <td><?= $form->field($item,"[$i]notes")->textArea()->label('') ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td width="20">#</td>
        <td width="30">N/A</td>
        <td width="50">N/A&nbsp;</td>
        <td width="20">0&nbsp;</td>
        <td width="20">N/A&nbsp;</td>
        <td width="20">N/A&nbsp;</td>
        <td width="50">N/A&nbsp;</td>
    </tr>
<?php endif; ?>
        
</div>
