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
        <h3>Spare Parts</h3>
    </div>
    
    <?php if (0): //(YII_ENV_DEV) : ?>
    <div class="alert alert-success" role="alert">
        <pre><?= print_r($orderItemsParts, true) ?></pre>
        <pre>queryParams: <?= print_r(Yii::$app->request->queryParams, true) ?></pre>
        <pre>bodyParams: <?= print_r(Yii::$app->request->bodyParams, true) ?></pre>
        <pre>GET: <?= print_r(Yii::$app->request->get(), true) ?></pre>
        <pre>POST: <?= print_r(Yii::$app->request->post(), true) ?></pre>
    </div>
    <?php endif; ?>
        
    <table border=0 width="100%" cellpadding="2" class="table table-striped">
        <tr>
            <th width="5">#</th>
            <th width="20">Name</th>
            <th width="20">Description</th>
            <th width="20">Side</th>
            <th width="20">Quantity</th>
            <th width="20">Color</th>
            <th width="50">Notes</th>
            <th width="20">Action</th>
        </tr>
        
        <div class="professional-order-item-part">
            
            <?php if (count($orderItemsParts) > 0): ?>
                <?php foreach($orderItemsParts as $i=>$item): ?>
                
                    <?php if (!empty($item["name"])) : ?>
                        <tr>
                            <td><?= $i+1; ?>.</td>
                            <td><?= $item["name"]        ?><?= Html::activeHiddenInput($item, "[$i]name",        ["value" => $item["name"]]) ?></td>
                            <td><?= $item["description"] ?><?= Html::activeHiddenInput($item, "[$i]description", ["value" => $item["description"]]) ?></td>
                            <td><?= $item["side"]        ?><?= Html::activeHiddenInput($item, "[$i]side",        ["value" => $item["side"]]) ?></td>
                            <td><?= $item["quantity"]    ?><?= Html::activeHiddenInput($item, "[$i]quantity",    ["value" => $item["quantity"]]) ?></td>
                            <td><?= $item["color"]       ?><?= Html::activeHiddenInput($item, "[$i]color",       ["value" => $item["color"]]) ?></td>
                            <td><?= $item["notes"]       ?><?= Html::activeHiddenInput($item, "[$i]notes",       ["value" => $item["notes"]]) ?></td>
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
                            <td><?php //= Html::activeHiddenInput($item, "[$i]name", ["value" => $i]) ?></td>
                            <td colspan="2"><?= $form->field($item,"[$i]name")->label('')->dropDownList(
                                    ArrayHelper::map($model->productPartList, 'id', 'description'),
                                    [
                                        'id'       => "product_parts_id_{$i}",
                                        'prompt'   => '--Select One--',            // options
                                        'onchange' => "setProductPartDescription(
                                            '#product_parts_description_{$i}', 
                                            $('#product_parts_id_{$i} option:selected').text() 
                                        )",
                                    ]    
                                ) ?>
                                    
                                <?php if (!empty($item['name']) && (count($orderItemsParts) > 0)) : ?>
                                    <!-- Delete Button -->
                                    <?= Html::a('<i class="glyphicon glyphicon-trash d-icon" aria-hidden="true"></i>', 
                                        ['professional/order-prewirekit'], 
                                        [
                                            'id'           => 'btn-delete-part',
                                            'class'        => 'btn btn-default',
                                            'data-confirm' => "Delete this Product Part item? Item [".($i+1)."] ". $item['description'], 
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
                                <?php else: ?>
                                    <!-- Add Button -->
                                    <?= Html::a('<i class="glyphicon glyphicon-plus d-icon" aria-hidden="true"></i>' . ' Add Item', 
                                        ['professional/order-prewirekit'], 
                                        [
                                            'id'           => 'btn-add-parts',
                                            'class'        => 'btn btn-success',
                                            //'data-method'  => 'post', 
                                            //'data-pjax'    => 1,
                                            //'data-params'  => "{'category': 'parts','addRow': '1'}",
                                            'data' => [
                                                'method' => 'post',
                                                'params' => [
                                                    'category' => 'parts',
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
                                        'id'    => "product_parts_description_{$i}",
                                        'value' => $item['description']
                                    ]) ?>
                            </td>
                            <td><?= $form->field($item,"[$i]side")->label('')->dropDownList(
                                ['N/A'=>'N/A', 'Left'=>'Left', 'Right'=>'Right']
                            ) ?></td>
                            <td><?= $form->field($item,"[$i]quantity")->label('')->dropDownList($arrNumbers); ?></td>
                            <td><?= $form->field($item,"[$i]color")->label('')->dropDownList(
                                //$model->getColors()
                                ['Default'=>'Default', 'Pink'=>'Pink', 'Tan'=>'Tan', 'Light Brown'=>'Light Brown', 'Brown'=>'Brown']
                                //['prompt'=>'--Select One--']    // options
                            ) ?></td>
                            <td><?= $form->field($item,"[$i]notes")->textArea()->label('') ?></td>
                            <td width="20">&nbsp;</td>
                        </tr>
                    <?php endif; // !empty(item)?>
                <?php endforeach; ?>
                
            <?php else: ?>
            
                <tr>
                    <td width="5">#</td>
                    <td width="30">N/A</td>
                    <td width="50">N/A&nbsp;</td>
                    <td width="20">N/A&nbsp;</td>
                    <td width="20">0&nbsp;</td>
                    <td width="20">N/A&nbsp;</td>
                    <td width="50">N/A&nbsp;</td>
                    <td width="20">&nbsp;</td>
                </tr>
                
            <?php endif; ?>
                
        </div>
        
    </table>
</div>

<?php
$jsBlock = "
function setProductPartDescription(elem, aValue)
{
    // set the specified element to specified value
    $(elem).val(aValue);
}
";
$this->registerJs($jsBlock, \yii\web\View::POS_END);
?>