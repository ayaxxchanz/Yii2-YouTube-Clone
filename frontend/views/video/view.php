<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var $model \common\models\Video */
?>

<div class="row">
    <div class="col-sm-8">
        <video class="embed-responsive" poster="<?php echo $model->getThumbnailLink() ?>" src="<?php echo $model->getVideoLink() ?>" controls></video>
        <h5 class="mt-2"><?php echo $model->title ?></h5>
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                <?php echo $model->getViews()->count() ?> views •
                <?php echo Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
            <div>
                <?php Pjax::begin() ?>
                <?php echo $this->render('_buttons', [
                    'model' => $model
                ]) ?>
                <?php Pjax::end() ?>
            </div>
        </div>
        <div>
            <p><?php echo $model->createdBy->username ?></p>
            <?php echo \yii\helpers\Html::encode($model->description) ?>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>