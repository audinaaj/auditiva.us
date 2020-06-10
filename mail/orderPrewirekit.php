<?php
use yii\helpers\Html;
use frontend\models\OrderPrewirekitForm;

/* @var $this yii\web\View */
/* @var $form frontend\models\OrderPrewirekitForm */

date_default_timezone_set('America/New_York');
?>

Thank you, <?= Html::encode($form->accountContact) ?>.  We appreciate your order.<br><?= "\n" ?>
We will contact you within two (2) business days.<br><?= "\n" ?>
For your records, these are the contents of your message:<br><?= "\n" ?>
<hr>
<h3>Order</h3>
<table border="0" cellspacing="5" cellpadding="5"><?= "\n" ?>
<tr><td><strong>Contact Name:     </strong></td><td><?= Html::encode($form->accountContact) ?></td></tr><?= "\n" ?>
<tr><td><strong>Account Number:   </strong></td><td><?= Html::encode($form->accountNumber) ?></td></tr><?= "\n" ?>
<tr><td><strong>Email:            </strong></td><td><?= Html::encode($form->email) ?></td></tr><?= "\n" ?>
<tr><td><strong>Telephone:        </strong></td><td><?= Html::encode($form->telephone) ?></td></tr><?= "\n" ?>
<tr><td><strong>Ship Date:        </strong></td><td><?= Html::encode($form->shipDate) ?></td></tr><?= "\n" ?>
<tr><td><strong>Ship To:          </strong></td><td><?= Html::encode($form->shipTo) ?></td></tr><?= "\n" ?>
<tr><td><strong>Ship Method:      </strong></td><td><?= Html::encode($form->shipMethod) ?></td></tr><?= "\n" ?>
</table><?= "\n" ?>

<h3>Modules / Pre-wire Kits</h3>
<table border="1" cellspacing="5" cellpadding="5"><?= "\n" ?>
<tr>
    <th>#</th>
    <th>Quantity</th>
    <th>Code</th>
    <th>Name</th>
    <th>Side</th>
    <th>Faceplate</th>     
    <th>Trimmers</th>             
    <th>Options</th>                 
    <th>Mic</th>                
    <th>Rec</th>                
</tr>
<?php if (count($form->itemsModule) > 0): ?>
    <?php foreach($form->itemsModule as $i=>$item): ?>
        <?php if (!empty($item['model'])): ?>
            <tr>
                <td><?= $i+1 ?>.</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= $item->getModuleCode() ?></td>
                <td><?= $item['description'] ?> <?php //echo OrderPrewirekitForm::getModuleProductDescription($item['model']) ?>&nbsp;</td>
                <td><?= $item['side'] ?></td>
                <td><?= "Battery ${item['battery']}, ${item['faceplateShape']}, Connector ${item['faceplateConnector']}, ${item['faceplateColor']}" ?></td>
                <?php if (is_array($item['trimmers'])): ?>
                    <td><?= implode(', ', $item['trimmers']) ?>&nbsp;</td>
                <?php else: ?>
                    <td>N/A</td>
                <?php endif; ?>
                <td><?= implode(', ', ["VC ${item['vcType']}", "Mem ${item['memoryButtonType']}", ($item['isFloated'] == "Yes" ? "Floated" : "Mounted"), ($item['isNanoCoated'] == "Yes" ? "Nanocoating" : "No Nano")]) ?></td>
                <td><?= $item['micType'] ?>&nbsp;</td>
                <td><?= $item['recType'] ?>&nbsp;</td>
            </tr>
        <?php endif; ?> 
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td width="20">N/A&nbsp;</td>
        <td width="20">N/A&nbsp;</td>
        <td width="30">N/A&nbsp;</td>
        <td width="50">N/A&nbsp;</td>
        <td width="20">N/A&nbsp;</td>
        <td width="100">N/A&nbsp;</td>
        <td width="100">N/A&nbsp;</td>
        <td width="15">N/A&nbsp;</td>
        <td width="15">N/A&nbsp;</td>
    </tr>
<?php endif; ?>                
</table><?= "\n" ?>

<h3>BTE/Stock Products</h3>
<table border="1" cellspacing="5" cellpadding="5"><?= "\n" ?>
<tr>
    <th>#</th>
    <th>Quantity</th>
    <th>Name</th>
    <th>Side</th>
    <th>Options</th>
    <th>Trimmers</th>
    <th>&nbsp;</th>
    <th>Rec</th>
    <th>Notes</th>               
</tr>
<?php if (count($form->itemsStock) > 0): ?>
    <?php foreach($form->itemsStock as $i=>$item): ?>
        <?php if (!empty($item['model'])): ?>
            <tr>
                <td><?= $i+1 ?>.</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= $item['model'] ?>&nbsp;</td>
                <td><?= $item['side'] ?></td>
                <td><?= "Battery ${item['battery']}, ${item['faceplateColor']}" ?></td>
                <?php if (is_array($item['trimmers'])): ?>
                    <td><?= implode(', ', $item['trimmers']) ?>&nbsp;</td>
                <?php else: ?>
                    <td>N/A</td>
                <?php endif; ?>
                <td><?= implode(', ', ["VC ${item['vcType']}", ($item['isNanoCoated'] == "Yes" ? "Nanocoating" : "No Nano")]) ?></td>
                <td><?= $item['recType'] ?>&nbsp;</td>
                <td><?= $item['notes'] ?>&nbsp;</td>
            </tr>
        <?php endif; ?> 
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td width="20">#</td>
        <td width="20">0&nbsp;</td>
        <td width="30">N/A</td>
        <td width="20">N/A&nbsp;</td>
        <td width="50">N/A&nbsp;</td>
        <td width="50">0&nbsp;</td>
        <td width="50">N/A&nbsp;</td>
        <td width="50">N/A&nbsp;</td>
    </tr>
<?php endif; ?>                
</table><?= "\n" ?>

<h3>Spare Parts</h3>
<table border="1" cellspacing="5" cellpadding="5"><?= "\n" ?>
<tr>
    <th>#</th>
    <th>Quantity</th>
    <th>Code</th>
    <th>Name</th>
    <th>Side</th>
    <th>Color</th>
    <th>Notes</th>                
</tr>
<?php if (count($form->itemsParts) > 0): ?>
    <?php foreach($form->itemsParts as $i=>$item): ?>
        <?php if (!empty($item['name'])): ?>
            <tr>
                <td><?= $i+1 ?>.</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= $item['name'] ?>&nbsp;</td>
                <td><?= $item['description'] ?>&nbsp;<?php //echo OrderPrewirekitForm::getProductPartDescription($item['name']) ?></td>
                <td><?= $item['side'] ?></td>
                <td><?= $item['color'] ?></td>
                <td><?= $item['notes'] ?>&nbsp;</td>
            </tr>
        <?php endif; ?> 
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td width="20">#</td>
        <td width="20">0&nbsp;</td>
        <td width="30">N/A&nbsp;</td>
        <td width="30">N/A&nbsp;</td>
        <td width="20">N/A&nbsp;</td>
        <td width="20">N/A&nbsp;</td>
        <td width="50">N/A&nbsp;</td>
    </tr>
<?php endif; ?>                
</table><?= "\n" ?>

<p>&nbsp;</p>

<table border="1" cellspacing="5" cellpadding="5"><?= "\n" ?>
<tr><th colspan="2"><strong>FOR ORDER ENTRY USE ONLY</strong></th></tr><?= "\n" ?>
<tr><td><strong>Order Number:     </strong></td><td>________________</td></tr><?= "\n" ?>
<tr><td><strong>Order Date:       </strong></td><td><?= date("m/d/Y h:i a") ?></td></tr><?= "\n" ?>
<tr><td><strong>Order Taken By:   </strong></td><td>Website Pre-wire Kit Order Form</td></tr><?= "\n" ?>
<tr><td><strong>Verified:         </strong></td><td>________________</td></tr><?= "\n" ?>
<tr><td><strong>Is account on hold by the Credit Department?</strong></td><td>________________</td></tr><?= "\n" ?>
<tr><td><strong>If 'Yes', Credit Manager signature is required</strong></td><td>________________</td></tr><?= "\n" ?>
</table><?= "\n" ?>






