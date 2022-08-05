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