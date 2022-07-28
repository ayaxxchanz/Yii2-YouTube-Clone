<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\bootstrap4\ActiveForm */

\backend\assets\TagsInputAsset::register($this);
?>

<div class="video-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row mr-2">
        <div class="col-sm-8">
            <!-- Display error message -->
            <?php echo $form->errorSummary($model) ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <label><?php echo $model->getAttributeLabel('thumbnail') ?></label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                </div>
            </div>

            <?= $form->field($model, 'tags', [
                'inputOptions' => ['data-role' => 'tagsinput']
            ])->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-sm-4 bg-light p-0">
            <div class=>
                <video class="embed-responsive" poster="<?php echo $model->getThumbnailLink() ?>"
                    src="<?php echo $model->getVideoLink() ?>" controls></video>
                <div class="m-3">
                    <div class="text-muted ts-2">Video link</div>
                    <a href="<?php echo $model->getVideoLink() ?>">Open Video</a>
                </div>
            </div>
            <div class="m-3">
                <div class="text-muted">Filename</div>
                <?php echo $model->video_name ?>
                <?= $form->field($model, 'status')->dropdownList($model->getStatusLabels()) ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>

    </div>
</div>