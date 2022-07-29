<?php

/** @var $model \common\models\Video */

use \yii\helpers\StringHelper;
use \yii\helpers\Url;

?>

<div class="media">
    <a href="<?php echo Url::to(['/video/update', 'video_id' =>  $model->video_id]) ?>">
        <div style="width:120px">
            <video class="embed-responsive" poster="<?php echo $model->getThumbnailLink() ?>"
                src="<?php echo $model->getVideoLink() ?>"></video>
        </div>
    </a>
    <img src="" alt="" class="mr-3">
    <div class="media-body">
        <h6 class="mt-0"><?php echo $model->title ?></h6>
        <?php echo StringHelper::truncateWords($model->description, 10) ?>
    </div>
</div>