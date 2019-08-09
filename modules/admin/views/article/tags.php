<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="tags-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= Html::dropDownList('tags', $selectedTags, $tags,
     ['class' => 'form-control', 'multiple' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>
