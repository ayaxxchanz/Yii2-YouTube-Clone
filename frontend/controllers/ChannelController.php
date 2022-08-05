<?php

namespace frontend\controllers;

use common\models\User;
use yii\web\Controller;
use common\models\Subscriber;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class ChannelController extends Controller
{
    public function behaviors()
    {
        return [
            // If unathorized user clicked the Subscribe button, they will be redirected to login page
            'access' => [
                'class' => AccessControl::class,
                'only' => ['subscribe'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }
    public function actionView($username)
    {
        $channel = $this->findChannel($username);

        return $this->render('view', [
            'channel' => $channel
        ]);
    }

    public function actionSubscribe($username)
    {
        $channel = $this->findChannel($username);

        // Check if user already subscribed
        $userId = \Yii::$app->user->id;
        $subscriber = $channel->isSubscribed($userId);

        // If user haven't subscribed, then create new Susbcribe
        if (!$subscriber) {
            $subscriber = new Subscriber();
            $subscriber->channel_id = $channel->id;
            $subscriber->user_id = $userId;
            $subscriber->created_at = time();
            $subscriber->save();
        }
        // If user already subscribed, then unsubscribed
        else {
            $subscriber->delete();
        }

        return $this->renderAjax('_subscribe', [
            'channel' => $channel
        ]);
    }

    public function findChannel($username)
    {
        $channel = User::findByUsername($username);
        if (!$channel) {
            throw new NotFoundHttpException("Channel does not exist.");
        }

        return $channel;
    }
}