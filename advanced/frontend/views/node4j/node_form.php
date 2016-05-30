<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>   
<div class="row">
    <div class="col-lg-12">
        <?= Html::beginForm(['node4j/create'], 'post', ['enctype' => 'multipart/form-data']) ?>
        <?= Html::label('First name', 'firstname', ['class' => 'label']) ?>
        <?= Html::input('Firstname', 'firstname', '', ['class' => 'firstname']) ?>
        <?= Html::label('Last name', 'lastname', ['class' => 'label']) ?>  
        <?= Html::input('Lastname', 'lastname', '', ['class' => 'lastname']) ?>
        <?= Html::label('Position', 'position', ['class' => 'label']) ?>   
        <?= Html::input('Position', 'position', '', ['class' => 'position']) ?>
        <br/><br/><br/>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php Html::endForm() ?>

    </div>
</div>