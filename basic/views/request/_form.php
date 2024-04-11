<?php

use app\models\Category;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$items = Category::find()
    ->select(['name'])
    ->indexBy('id')
    ->column()
/** @var yii\web\View $this */
/** @var app\models\request $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_user')->hiddenInput(['value'=>Yii::$app->user->identity->getId()])->label(false) ?>

    <?= $form->field($model, 'id_category')->dropdownList(
        $items
    ) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'gos_nomer')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => 'A999AA 99' ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
