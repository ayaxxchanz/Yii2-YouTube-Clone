<?php

/** @var $dataProvider \yii\data\ActiveDataProvier */
?>

<h1>Found videos</h1>

<?php
echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider, // Display video id
    'itemView' => '_video_item', // Display video in Bootstrap Card from _video_item.php
    'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}', // Wrap item in _video_item.php in new div
    'itemOptions' => [
        'tag' => false // Remove data-key in div
    ]
]);