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

<div class="row">
    <div class="col-lg-12">
        <h3>Modules / Pre-wire Kits</h3>
    </div>
    <table border=0 width="100%" cellpadding="2" class="table table-striped">
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Description</th>
            <th>Side</th>
            <th>Quantity</th>
            <th>Faceplate</th>
            <th>Trimmers</th>
            <th>Options</th>
            <th>Mic/Rec</th>
            <th width="20">Action</th>
        </tr>
        
        <div class="professional-order-item-module">
            
            <?php if (count($orderItemsModule) > 0): ?>
                <?php foreach($orderItemsModule as $i=>$item): ?>
                    <?php if (!empty($item["model"])) : ?>
                        <tr>
                            <td><?= $i+1; ?>.</td>
                            <td><?= $item->getModuleCode() ?> <?= Html::activeHiddenInput($item, "[$i]model",    ["value" => $item["model"]])    ?></td>
                            <td><?= $item["description"] ?><?= Html::activeHiddenInput($item, "[$i]description", ["value" => $item["description"]]) ?></td>
                            <td><?= $item["side"]     ?><?= Html::activeHiddenInput($item, "[$i]side",     ["value" => $item["side"]])     ?></td>
                            <td><?= $item["quantity"] ?><?= Html::activeHiddenInput($item, "[$i]quantity", ["value" => $item["quantity"]]) ?></td>
                            <td>
                                Batt:   <?= $item["battery"]            ?><?= Html::activeHiddenInput($item, "[$i]battery",            ["value" => $item["battery"]]) ?>, 
                                Shape: <?= $item["faceplateShape"]     ?><?= Html::activeHiddenInput($item, "[$i]faceplateShape",     ["value" => $item["faceplateShape"]]) ?><br/>
                                Conn:  <?= $item["faceplateConnector"] ?><?= Html::activeHiddenInput($item, "[$i]faceplateConnector", ["value" => $item["faceplateConnector"]]) ?>, 
                                Color: <?= $item["faceplateColor"]     ?><?= Html::activeHiddenInput($item, "[$i]faceplateColor",     ["value" => $item["faceplateColor"]]) ?>
                            </td>
                            <td>
                                Trimmer: <?= (is_array($item['trimmers']) ? implode(', ', $item['trimmers']) : 'N/A') ?>
                                <?php
                                    if (is_array($item['trimmers'])) {
                                        foreach($item["trimmers"] as $trimmer_value) {
                                            echo Html::activeHiddenInput($item, "[$i]trimmers[]", ["value" => $trimmer_value]);
                                        }
                                    }
                                ?>
                            </td>
                            <td>
                                VC:     <?= $item["vcType"]           ?><?= Html::activeHiddenInput($item, "[$i]vcType",           ["value" => $item["vcType"]]) ?>, 
                                Mem:   <?= $item["memoryButtonType"] ?><?= Html::activeHiddenInput($item, "[$i]memoryButtonType", ["value" => $item["memoryButtonType"]]) ?><br/>
                                Float: <?= $item["isFloated"]        ?><?= Html::activeHiddenInput($item, "[$i]isFloated",        ["value" => $item["isFloated"]]) ?>, 
                                Nano:  <?= $item["isNanoCoated"]     ?><?= Html::activeHiddenInput($item, "[$i]isNanoCoated",     ["value" => $item["isNanoCoated"]]) ?>
                            </td>
                            <td>
                                Mic:  <?= $item["micType"] ?><?= Html::activeHiddenInput($item, "[$i]micType", ["value" => $item["micType"]]) ?><br/>
                                Rec: <?= $item["recType"] ?><?= Html::activeHiddenInput($item, "[$i]recType", ["value" => $item["recType"]]) ?>
                            </td>
                            <td>
                                <?= Html::a('<i class="glyphicon glyphicon-trash d-icon" aria-hidden="true"></i>' . '', 
                                    ['professional/order-prewirekit'], 
                                    [
                                        'id'           => 'btn-delete-module',
                                        'class'        => 'btn btn-default',
                                        'data-confirm' => "Delete this Module/Pre-wire Kit item? Item [".($i+1)."] ". $item['description'],  
                                        'data' => [
                                            'method' => 'post',
                                            'params' => [
                                                'category' => 'module',
                                                'delRow'   => $i,
                                            ],
                                            'pjax' => 1
                                        ]
                                    ]) 
                                ?>
                            </td>
                        </tr>
                        
                    <?php else: ?>
                    
                        <tr>
                            <td><?php //= Html::activeHiddenInput($item, "[$i]model", ["value" => $i]) ?></td>
                            <td colspan="2"><?= $form->field($item,"[$i]model")->label('')->dropDownList(
                                    ArrayHelper::map($model->moduleProductList, 'id', 'description'),
                                    [
                                        'id'       => "module_id_{$i}",
                                        'prompt'   => '--Select One--',            // options
                                        'onchange' => "setModuleDescription(
                                            '#module_description_{$i}', 
                                            $('#module_id_{$i} option:selected').text() 
                                        )",
                                    ] 
                                ) ?>
                                
                                <?php if (!empty($item['model']) && (count($orderItemsModule) > 0)) : ?>
                                    <!-- Delete Button -->
                                    <?= Html::a('<i class="glyphicon glyphicon-trash d-icon" aria-hidden="true"></i>', 
                                        ['professional/order-prewirekit'],
                                        [
                                            'id'           => 'btn-delete-module',
                                            'class'        => 'btn btn-default',
                                            'data-confirm' => "Delete this Module/Pre-wire Kit item? Item [".($i+1)."] ". $item['description'],  
                                            //'data-method'  => 'post', 
                                            //'data-pjax'    => 1,
                                            'data' => [
                                                'method' => 'post',
                                                'params' => [
                                                    'category' => 'module',
                                                    'delRow'   => $i,
                                                ],
                                                'pjax' => 1
                                            ]
                                        ]) 
                                    ?>
                                <?php else: ?>
                                    <!-- Add Button -->
                                    <?= Html::a('<i class="glyphicon glyphicon-plus d-icon" aria-hidden="true"></i>' . ' Add Item', 
                                        ['professional/order-prewirekit'], 
                                        [
                                            'id'           => 'btn-add-module',
                                            'class'        => 'btn btn-success',
                                            //'data-method'  => 'post', 
                                            //'data-pjax'    => 1,
                                            //'data-params'  => "{'category': 'parts','addRow': '1'}",
                                            'data' => [
                                                'method' => 'post',
                                                'params' => [
                                                    'category' => 'module',
                                                    'addRow'   => '1',
                                                ],
                                                'pjax' => 1
                                            ]
                                        ]) 
                                    ?>
                                <?php endif; ?>
                                
                                <?php //echo $form->field($item,"[$i]description")->label('') ?>
                                <?= Html::activeHiddenInput($item, "[$i]description", 
                                    [
                                        'id'    => "module_description_{$i}",
                                        'value' => $item['description']
                                    ]) ?>
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
                                ['None'=>'None', 'Manual'=>'Manual (Standard, N/A in CIC)', 'Manual Raised'=>'Manual (Raised)', 'Trimmer'=>'Trimmer']
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
                            <td width="20">&nbsp;</td>
                        </tr>
                    <?php endif; // !empty(item)?>
                <?php endforeach; ?>
                
            <?php else: ?>
            
                <tr>
                    <td width="20">#</td>
                    <td width="30">N/A&nbsp;</td>
                    <td width="30">N/A&nbsp;</td>
                    <td width="50">N/A&nbsp;</td>
                    <td width="100">0&nbsp;</td>
                    <td width="100">N/A&nbsp;</td>
                    <td width="20">0&nbsp;</td>
                    <td width="50">N/A&nbsp;</td>
                    <td width="50">N/A&nbsp;</td>
                    <td width="20">&nbsp;</td>
                </tr>
                
            <?php endif; ?>
            
        </div>
    </table>
</div>

<?php
$jsBlock = "
function setModuleDescription(elem, aValue)
{
    // set the specified element to specified value
    $(elem).val(aValue);
}
";
$this->registerJs($jsBlock, \yii\web\View::POS_END);
?>