<?php

/** @var $model \common\models\Video */
?>

<div class="row">
    <div class="col-sm-8">
        <video class="embed-responsive" poster="<?php echo $model->getThumbnailLink() ?>"
            src="<?php echo $model->getVideoLink() ?>" controls></video>
        <h5 class="mt-2"><?php echo $model->title ?></h5>
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-muted">
                <?php echo $model->getViews()->count() ?> views •
                <?php echo Yii::$app->formatter->asDate($model->created_at) ?>
            </div>
            <div>
                <button class="btn btn-sm btn-outline-primary">
                    <i class="fa-solid fa-thumbs-up"></i> 9
                </button>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fa-regular fa-thumbs-down"></i> 3
                </button>
            </div>
        </div>

    </div>
    <div class="col-sm-4"></div>
</div>