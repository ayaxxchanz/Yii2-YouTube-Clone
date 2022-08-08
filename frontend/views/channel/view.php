<?php

use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<div class="jumbotron">
    <h1 class="display-4"><?php echo $channel->username ?></h1>
    <hr class="my-4">
    <?php Pjax::begin();

    echo $this->render('_subscribe', [
        'channel' => $channel
    ]);

    Pjax::end(); ?>
</div>

<?php
echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider, // Display video id
    'itemView' => '../video/_video_item', // Display video in Bootstrap Card from _video_item.php
    'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}', // Wrap item in _video_item.php in new div
    'itemOptions' => [
        'tag' => false // Remove data-key in div
    ]
]);
?>