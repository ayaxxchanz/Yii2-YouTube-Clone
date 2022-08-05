<?php

use yii\helpers\Url;

?>
<div class="d-flex align-items-center">

    <a class="btn <?php echo $channel->isSubscribed(Yii::$app->user->id) ? 'btn-secondary' : 'btn-danger' ?> mr-2"
        href="<?php echo Url::to(['channel/subscribe', 'username' =>  $channel->username]) ?>" data-method="post"
        data-pjax="1"><?php echo $channel->isSubscribed(Yii::$app->user->id) ? 'Subscribed' : 'Subscribe' ?><span
            class="ml-2"><?php echo $channel->getSubscribers()->count() ?></span></a><i class="far fa-bell"></i>

</div>