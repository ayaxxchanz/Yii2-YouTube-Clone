<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row mr-2">
        <div class="col-sm-8">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-sm-4 bg-light p-0">
            <div class=>
                <video class="embed-responsive" src="<?php echo $model->getVideoLink() ?>" controls></video>
                <div class="m-3">
                    <div class="text-muted ts-2">Video link</div>
                    <a href="<?php echo $model->getVideoLink() ?>">Open Video</a>
                </div>
            </div>
            <div class="m-3">
                <div class="text-muted">Filename</div>
                <?php echo $model->video_name ?>
                <?= $form->field($model, 'status')->textInput() ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>

    </div>
</div>