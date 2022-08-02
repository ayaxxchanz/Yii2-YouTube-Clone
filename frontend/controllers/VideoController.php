<?php

namespace frontend\controllers;

use yii\web\Controller;
use common\models\Video;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class VideoController extends Controller
{
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
        $video = Video::findOne($id);

        // Display error if video id does not exist.
        if (!$video) {
            throw new NotFoundHttpException("Video does not exist.");
        }

        // Display video/view.php
        return $this->render('view', [
            'model' => $video
        ]);
    }
}