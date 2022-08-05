<?php

use yii\helpers\Url;

?>

<a class="btn btn-danger mr-2" href="<?php echo Url::to(['channel/subscribe', 'username' =>  $channel->username]) ?>" data-method="post" data-pjax="1">Subscribe</a><i class="far fa-bell"></i>