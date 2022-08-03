<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Video;
use common\models\VideoLike;
use common\models\VideoView;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class VideoController extends Controller
{
    public function behaviors()
    {
        return [
            // If unathorized user clicked the Like button, they will be redirected to login page
            'access' => [
                'class' => AccessControl::class,
                'only' => ['like', 'dislike'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            // Only POST method is allowed for Like & Dislike button
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'like' => ['post'],
                    'dislike' => ['post'],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Video::find()->published()->latest() // Call mehods in VideoQuery.php
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id)
    {
        $this->layout = 'blank';
        $video = $this->findVideo($id);

        // Save video views
        $videoView = new VideoView();
        $videoView->video_id = $id;
        $videoView->user_id = \Yii::$app->user->id;
        $videoView->created_at = time();
        $videoView->save();

        // Display video/view.php
        return $this->render('view', [
            'model' => $video
        ]);
    }

    public function actionLike($id)
    {
        $video = $this->findVideo($id);
        $userId = \Yii::$app->user->id;

        $videoLike = new VideoLike();
        $videoLike->video_id = $id;
        $videoLike->user_id = $userId;
        $videoLike->type = VideoLike::TYPE_LIKE;
        $videoLike->created_at = time();
        $videoLike->save();

        return $this->renderAjax('_buttons', [
            'model' => $video
        ]);
    }

    public function findVideo($id)
    {
        $video = Video::findOne($id);

        // Display error if video id does not exist.
        if (!$video) {
            throw new NotFoundHttpException("Video does not exist.");
        }

        return $video;
    }
}