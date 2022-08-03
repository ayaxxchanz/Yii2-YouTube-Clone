<?php

namespace common\models;

use Imagine\Image\Box;
use Yii;
use yii\imagine\Image;
use yii\helpers\FileHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property string $video_id
 * @property string $title
 * @property string|null $description
 * @property string|null $tags
 * @property int|null $status
 * @property int|null $has_thumbnail
 * @property string|null $video_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 */
class Video extends \yii\db\ActiveRecord
{
    const STATUS_UNLISTED = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * \yii\web\UploadedFile
     */
    public $video;

    /**
     * \yii\web\UploadedFile
     */
    public $thumbnail;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video}}';
    }


    // Return timestamp
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'title'], 'required'],
            [['description'], 'string'],
            [['status', 'has_thumbnail', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['video_id'], 'string', 'max' => 16],
            [['title', 'tags', 'video_name'], 'string', 'max' => 512],
            [['video_id'], 'unique'],
            ['has_thumbnail', 'default', 'value' => 0], // set default thumbnail value
            ['status', 'default', 'value' => self::STATUS_UNLISTED], // set default status value
            ['video', 'file', 'extensions' => ['mp4', 'mkv']], // set only accept valid video file
            ['thumbnail', 'image', 'minWidth' => 1280], // set minimum image width
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'status' => 'Status',
            'has_thumbnail' => 'Has Thumbnail',
            'video_name' => 'Video Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'thumbnail' => 'Thumbnail',
        ];
    }

    public function getStatusLabels()
    {
        return [
            self::STATUS_UNLISTED => 'Unlisted',
            self::STATUS_PUBLISHED => 'Published',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /** @return \yii\db\ActiveQuery */

    public function getViews()
    {
        return $this->hasMany(VideoView::class, ['video_id' => 'video_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VideoQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $isInsert = $this->isNewRecord;
        if ($isInsert) {
            $this->video_id = Yii::$app->security->generateRandomString(8);
            $this->title = $this->video->name;
            $this->video_name = $this->video->name;
        }
        if ($this->thumbnail) {
            $this->has_thumbnail = 1;
        }

        $saved = parent::save($runValidation, $attributeNames);

        if (!$saved) {
            return false;
        }
        if ($isInsert) {
            $videoPath = Yii::getAlias('@frontend/web/storage/videos/' . $this->video_id . '.mp4');
            if (!is_dir(dirname($videoPath))) {
                FileHelper::createDirectory(dirname($videoPath));
            }

            $this->video->saveAs($videoPath);
        }
        if ($this->thumbnail) {
            $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbs/' . $this->video_id . '.jpg');
            if (!is_dir(dirname($thumbnailPath))) {
                FileHelper::createDirectory(dirname($thumbnailPath));
            }

            $this->thumbnail->saveAs($thumbnailPath);

            /* Resize image */
            Image::getImagine()
                ->open($thumbnailPath)
                ->thumbnail(new Box(1280, 720))
                ->save();
        }
        return true;
    }

    // Return the link to the video
    public function getVideoLink()
    {
        return Yii::$app->params['frontendUrl'] . 'storage/videos/' . $this->video_id . '.mp4';
    }

    // Return the video thumbnail link
    public function getThumbnailLink()
    {
        return $this->has_thumbnail ? Yii::$app->params['frontendUrl'] . 'storage/thumbs/' . $this->video_id . '.jpg' : '';
    }

    public function afterDelete()
    {
        parent::afterDelete();

        // Delete video file in storage
        $videoPath = Yii::getAlias('@frontend/web/storage/videos/' . $this->video_id . '.mp4');
        unlink($videoPath);

        $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbs/' . $this->video_id . '.jpg');
        // Delete thumbnail in storage if thumbnail exists
        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }
    }

    public function isLikedBy($userId)
    {
        return VideoLike::find()
            ->userIdVideoId($userId, $this->video_id)
            ->liked()
            ->one();
    }
}