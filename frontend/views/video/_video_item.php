<?php

use yii\helpers\Url;

/** @var $model \common\models\Video */

?>

<div class="card m-3" style="width: 14rem;">
    <a href="<?php echo Url::to(['/video/view', 'id' => $model->video_id]) ?>">
        <video class="embed-responsive" poster="<?php echo $model->getThumbnailLink() ?>"
            src="<?php echo $model->getVideoLink() ?>"></video>
    </a>
    <div class="card-body p-2">
        <h6 class="card-title m-0"><?php echo $model->title ?></h6>
        <p class="text-muted card-text m-0">
            <?php echo $model->createdBy->username ?>
        </p>
        <p class="text-muted card-text m-0">
            140 views . <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        </p>
    </div>
</div>