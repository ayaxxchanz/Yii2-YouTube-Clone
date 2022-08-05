<?php

namespace frontend\controllers;

use common\models\User;
use yii\web\Controller;
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
