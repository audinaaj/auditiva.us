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
        <h3>BTE/Stock Products</h3>
    </div>
    
    <table border=0 width="100%" cellpadding="2" class="table table-striped">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Side</th>
            <th>Quantity</th>
            <th colspan="4">Options</th>
            <th>Notes</th>
            <th>Action</th>
        </tr>
        
        <div class="professional-order-item-stock">
            
            <?php if (count($orderItemsStock) > 0): ?>
                <?php foreach($orderItemsStock as $i=>$item): ?>
                    <?php if (!empty($item["model"])) : ?>
                        <tr>
                            <td><?= $i+1; ?>.</td>
                            <td><?= $item["model"]    ?><?= Html::activeHiddenInput($item, "[$i]model",    ["value" => $item["model"]])    ?></td>
                            <td><?= $item["side"]     ?><?= Html::activeHiddenInput($item, "[$i]side",     ["value" => $item["side"]])     ?></td>
                            <td><?= $item["quantity"] ?><?= Html::activeHiddenInput($item, "[$i]quantity", ["value" => $item["quantity"]]) ?></td>
                            <td>
                                Batt: <?= $item["battery"]        ?><?= Html::activeHiddenInput($item, "[$i]battery",        ["value" => $item["battery"]]) ?><br/> 
                                Color: <?= $item["faceplateColor"] ?><?= Html::activeHiddenInput($item, "[$i]faceplateColor", ["value" => $item["faceplateColor"]]) ?>
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
                                VC: <?= $item["vcType"]       ?><?= Html::activeHiddenInput($item, "[$i]vcType",       ["value" => $item["vcType"]]) ?><br/>
                                Nano: <?= $item["isNanoCoated"] ?><?= Html::activeHiddenInput($item, "[$i]isNanoCoated", ["value" => $item["isNanoCoated"]]) ?>
                            </td>
                            <td>Rec: <?= $item["recType"] ?><?= Html::activeHiddenInput($item, "[$i]recType", ["value" => $item["recType"]]) ?></td>
                            <td><?= $item["notes"]   ?><?= Html::activeHiddenInput($item, "[$i]notes",   ["value" => $item["notes"]])   ?></td>
                            <td>
                                <?= Html::a('<i class="glyphicon glyphicon-trash d-icon" aria-hidden="true"></i>' . '', 
                                    ['professional/order-prewirekit'], 
                                    [
                                        'id'           => 'btn-delete-part',
                                        'class'        => 'btn btn-default',
                                        'data-confirm' => "Delete this Product Part item? Item [".($i+1)."] ". $item['description'],  
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
                            </td>
                        </tr>
                        
                    <?php else: ?>
                    
                        <tr>
                            <td><?php //= Html::activeHiddenInput($item, "[$i]model", ["value" => $i]) ?></td>
                            <td><?= $form->field($item,"[$i]model")->label('')->dropDownList(
                                    ArrayHelper::map($model->stockProductList, 'id', 'description'),
                                    ['prompt'=>'--Select One--']    // options
                                ) ?>
                                
                                <?php if (!empty($item['model']) && (count($orderItemsStock) > 0)) : ?>
                                    <!-- Delete Button -->
                                    <?= Html::a('<i class="glyphicon glyphicon-trash d-icon" aria-hidden="true"></i>', 
                                        ['professional/order-prewirekit'],
                                        [
                                            'id'           => 'btn-delete-stock',
                                            'class'        => 'btn btn-default',
                                            'data-confirm' => "Delete this Stock item? Item [${i}]", 
                                            //'data-method'  => 'post', 
                                            //'data-pjax'    => 1,
                                            'data' => [
                                                'method' => 'post',
                                                'params' => [
                                                    'category' => 'stock',
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
                                            'id'           => 'btn-add-stock',
                                            'class'        => 'btn btn-success',
                                            //'data-method'  => 'post', 
                                            //'data-pjax'    => 1,
                                            //'data-params'  => "{'category': 'parts','addRow': '1'}",
                                            'data' => [
                                                'method' => 'post',
                                                'params' => [
                                                    'category' => 'stock',
                                                    'addRow'   => '1',
                                                ],
                                                'pjax' => 1
                                            ]
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
                                ['Default'=>'Default', '13'=>'13', '312'=>'312', '10'=>'10']
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
                                ['Default'=>'Default', 'Manual'=>'Manual', 'None'=>'None', 'Trimmer'=>'Trimmer']
                                //['prompt'=>'--Select One--']    // options
                            ) ?>
                            <?= $form->field($item,"[$i]isNanoCoated")->label('Nanocoating')->dropDownList(
                                ['Yes'=>'Yes', 'No'=>'No']
                                //['prompt'=>'--Select One--']    // options
                            ) ?>
                            </td>
                            <td>
                                <?= $form->field($item,"[$i]recType")->label('Receiver Type')->dropDownList(
                                    [
                                        'Standard'=>'Standard', 
                                        'DTEC3008'=>'DTEC3008',
                                        'ED3147'=>'ED3147', 'ED6565'=>'ED6565', 
                                        'FH3371'=>'FH3371', 'FH3375'=>'FH3375', 'FH3854'=>'FH3854', 
                                    ]
                                ) ?>
                            </td>
                            <td><?= $form->field($item,"[$i]notes")->textArea()->label('') ?></td>
                            <td width="20">&nbsp;</td>
                        </tr>
                    <?php endif; // !empty(item)?>
                <?php endforeach; ?>
                
            <?php else: ?>
            
                <tr>
                    <td width="20">#</td>
                    <td width="30">N/A</td>
                    <td width="20">N/A&nbsp;</td>
                    <td width="20">0&nbsp;</td>
                    <td width="50">N/A&nbsp;</td>
                    <td width="50">0&nbsp;</td>
                    <td width="50">N/A&nbsp;</td>
                    <td width="50">N/A&nbsp;</td>
                    <td width="20">&nbsp;</td>
                </tr>
            <?php endif; ?>
                
        </div>

    </table>
</div>