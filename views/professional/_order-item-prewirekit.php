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

<div class="professional-order-item-prewirekit">
    
<?php if (count($orderItems) > 0): ?>
    <?php foreach($orderItems as $i=>$item): ?>
        <tr>
            <td><br/><?= $i+1; ?>.
                <?= Html::activeHiddenInput($item, "[$i]model", ["value" => $i]) ?>
            </td>
            <td><?= $form->field($item,"[$i]model")->label('')->dropDownList(
                    ArrayHelper::map($model->productList, 'id', 'description'),
                    ['prompt'=>'--Select One--']    // options
                ) ?>
                <?php if ($i > 0) : ?>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    <?= Html::a('<i class="glyphicon glyphicon-minus d-icon" aria-hidden="true"></i>' . ' Delete Item', 
                        ['professional/order-prewirekit', 'delRow' => $i], 
                        [
                            'class'        => 'btn btn-default',
                            'data-confirm' => "Delete this item? Item [${i}]", 
                            'data-method'  => "post", 
                            //'data-pjax'    => '0'
                        ]) 
                    ?>
                <?php endif; ?>
            </td>
            <td><?= $form->field($item,"[$i]side")->label('')->dropDownList(
                ['Left'=>'Left', 'Right'=>'Right']
                //['prompt'=>'--Select One--']    // options
            ) ?></td>
            <!-- <td>< ? = $form->field($item,"[$i]description")->label(''); ? ></td> -->
            <td><?= $form->field($item,"[$i]quantity")->label('')->dropDownList($arrNumbers); ?></td>
            
            <!-- Faceplate -->
            <td><?= $form->field($item,"[$i]battery")->label('Battery')->dropDownList(
                ['13'=>'13', '312'=>'312', '10'=>'10'],
                ['prompt'=>'--Select One--']    // options
            ) ?>
            <?= $form->field($item,"[$i]faceplateShape")->label('Shape')->dropDownList(
                ['Flat'=>'Flat', 'Domed'=>'Domed']
                //['prompt'=>'--Select One--']    // options
            ) ?>
            <?= $form->field($item,"[$i]faceplateConnector")->label('Connector')->dropDownList(
                ['Socket'=>'Socket', 'Flex'=>'Flex', 'Pill'=>'Pill']
                //['prompt'=>'--Select One--']    // options
            ) ?>
            <?= $form->field($item,"[$i]faceplateColor")->label('Color')->dropDownList(
                //$model->getColors()
                ['Pink'=>'Pink', 'Tan'=>'Tan', 'Light Brown'=>'Light Brown', 'Brown'=>'Brown']
                //['prompt'=>'--Select One--']    // options
            ) ?></td>
            
            <!-- Trimmers -->
            <td>
                <?= $form->field($item,"[$i]trimmers")->label('Trimmers')->checkboxList([
                    'LFC'            => 'LFC',
                    'HFC'            => 'HFC',
                    'Gain'           => 'Gain',
                    'PC'             => 'PC',
                    'TK'             => 'TK',
                    'TelecoilToggle' => 'Tcoil Tog',
                ]) ?>
            </td>
            
            <!-- Options -->
            <td><?= $form->field($item,"[$i]vcType")->label('VC')->dropDownList(
                ['Manual'=>'Manual', 'None'=>'None', 'Trimmer'=>'Trimmer']
                //['prompt'=>'--Select One--']    // options
            ) ?>
            <?= $form->field($item,"[$i]memoryButtonType")->label('Memory Btn')->dropDownList(
                ['Button'=>'Button', 'None'=>'None']
                //['prompt'=>'--Select One--']    // options
            ) ?>
            <?= $form->field($item,"[$i]isFloated")->label('Floated')->dropDownList(
                ['Yes'=>'Yes', 'No'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>
            <?= $form->field($item,"[$i]isNanoCoated")->label('Nanocoating')->dropDownList(
                ['Yes'=>'Yes', 'No'=>'No']
                //['prompt'=>'--Select One--']    // options
            ) ?>
            </td>
            <td>
                <?= $form->field($item,"[$i]micType")->label('Microphone Type')->dropDownList(
                    ['Standard'=>'Standard', 'EM3368'=>'EM3368', 'TM3546'=>'TM3546']
                ) ?>
                <?= $form->field($item,"[$i]recType")->label('Receiver Type')->dropDownList(
                    [
                        'Standard'=>'Standard', 
                        'DTEC3008'=>'DTEC3008',
                        'ED3147'=>'ED3147', 'ED6565'=>'ED6565', 
                        'FH3371'=>'FH3371', 'FH3375'=>'FH3375', 'FH3854'=>'FH3854', 
                    ]
                ) ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td width="20">#</td>
        <td width="30">N/A</td>
        <td width="50">N/A&nbsp;</td>
        <td width="100">0&nbsp;</td>
        <td width="100">N/A&nbsp;</td>
        <td width="20">0&nbsp;</td>
        <td width="50">N/A&nbsp;</td>
        <td width="50">N/A&nbsp;</td>
    </tr>
<?php endif; ?>
        
</div>
