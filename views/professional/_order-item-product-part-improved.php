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
            <th>#</th>
            <th>Name</th>
            <th>Side</th>
            <th>Quantity</th>
            <th>Description</th>
            <th>Color</th>
            <th>Notes</th>
        </tr>
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
                        <?php if (!empty($item['name']) && (count($orderItemsParts) > 0)) : ?>
                            <?= Html::a('<i class="glyphicon glyphicon-trash d-icon" aria-hidden="true"></i>', 
                                ['professional/order-prewirekit'], 
                                [
                                    'id'           => 'btn-delete-part',
                                    'class'        => 'btn btn-default',
                                    'data-confirm' => "Delete this Product Part item? Item [".($i+1).". ". $item['name'] . "]", 
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
                            <?= Html::a('<i class="glyphicon glyphicon-plus d-icon" aria-hidden="true"></i>' . ' Add Item', 
                                ['professional/order-prewirekit'], 
                                [
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
        <!-- <tr id="rowLast"> -->
            <!-- <td colspan="10"> -->
                <!-- < ?= Html::a('<i class="glyphicon glyphicon-plus d-icon" aria-hidden="true"></i>' . ' Add Item',  -->
                    <!-- ['professional/order-prewirekit'],  -->
                    <!-- [ -->
                        <!-- 'class'        => 'btn btn-success', -->
                        <!-- //'data-method'  => 'post',  -->
                        <!-- //'data-pjax'    => 1, -->
                        <!-- //'data-params'  => "{'category': 'parts','addRow': '1'}", -->
                        <!-- 'data' => [ -->
                            <!-- 'method' => 'post', -->
                            <!-- 'params' => [ -->
                                <!-- 'category' => 'parts', -->
                                <!-- 'addRow'   => '1', -->
                            <!-- ], -->
                            <!-- 'pjax' => 1 -->
                        <!-- ] -->
                    <!-- ])  -->
                <!-- ?> -->
            <!-- </td> -->
        <!-- </tr>        -->
    </table>
</div>