<?php

/** @var $channel \common\models\User */
/** @var $user \common\models\User */

?>

Hello <?php echo $channel->username ?>!
User <?php echo \common\helpers\Html::channelLink($user, true) ?> has subscribed to you.
- YuTub Team