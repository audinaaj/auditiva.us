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

// Flags
$onlyShowListing = true;

// Form data
$arrNumbers = [];
for($i=0; $i<=300; $i++) {
    $arrNumbers[] = $i;
}
?>

<!-- <div class="row"> -->
    <!-- <div class="col-lg-12"> -->
        <!-- <h3>Spare Parts</h3> -->
    <!-- </div> -->
    <!-- <table border=0 width="100%" cellpadding="2" class="table table-striped"> -->
    <tr>
        <th width="20">#</th>
        <th width="30">Name</th>
        <th width="50">Side</th>
        <th width="20">Quantity</th>
        <th width="20">Description</th>
        <th width="20">Color</th>
        <th width="50">Notes</th>
        <th width="20">Action</th>
    </tr>
    
    <!-- <div class="professional-order-item-part"> -->
        <?php if ($onlyShowListing) : ?>
        
            <?php if (count($orderItemsParts) > 0): ?>
                <?php foreach($orderItemsParts as $i=>$item): ?>
                    <?php if (!empty($item["name"])) : ?>
                        <tr>
                            <td><?= $i+1; ?>.</td>
                            <td><?= $item["name"] ?></td>
                            <td><?= $item["side"] ?></td>
                            <td><?= $item["quantity"] ?></td>
                            <td><?= $item["description"] ?></td>
                            <td><?= $item["color"] ?></td>
                            <td><?= $item["notes"] ?></td>
                            <td>
                                <?= Html::a('<i class="glyphicon glyphicon-trash d-icon" aria-hidden="true"></i>' . '', 
                                    ['professional/order-prewirekit'], 
                                    [
                                        'id'           => 'btn-delete-part',
                                        'class'        => 'btn btn-default',
                                        'data-confirm' => "Delete this Product Part item? Item [${i}]", 
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
                            <td><?= Html::activeHiddenInput($item, "[$i]name", ["value" => $i]) ?></td>
                            <td><?= $form->field($item,"[$i]name")->label('')->dropDownList(
                                    ArrayHelper::map($model->productPartList, 'id', 'description'),
                                    ['prompt'=>'--Select One--']    // options
                                ) ?>
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
                            <td width="20">#</td>
                        </tr>
                        
                    <?php endif; // !empty(item)?>
                    
                <?php endforeach; ?>
            <?php endif; // endif totalItems > 0?>
            
        
        <?php else: ?>

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
                            <?php if (0): //($i > 0) : ?>
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
                        <td width="20">#</td>
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
            
        <?php endif; ?>
            
    <!-- </div> -->

    <tr id="rowLast">
        <td colspan="10">
            <?= Html::a('<i class="glyphicon glyphicon-plus d-icon" aria-hidden="true"></i>' . ' Add', 
                ['professional/order-prewirekit'], 
                [
                    'class'        => 'btn btn-warning',
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
        </td>
    </tr>       
    <!-- </table> -->
<!-- </div>     -->