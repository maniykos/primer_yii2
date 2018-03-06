<?php

namespace common\models;

use common\components\ParentModel;
use common\models\query\ArticleQuery;
use mrssoft\sitemap\SitemapInterface;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use creocoder\taggable\TaggableBehavior;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $body
 * @property string $view
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property array $attachments
 * @property integer $category_id
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $author
 * @property User $updater
 * @property ArticleCategory $category
 * @property ArticleAttachment[] $articleAttachments
 * @property ArticleArticleTag[] $articleArticleTags
 * @property ArticleTag[] $articleTag
 */
class Article extends ParentModel implements SitemapInterface
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 0;

    const CAT_VIDEO     = 3;
    const CAT_BLOG      = 4;
    const CAT_SUPPORT   = 2;

    const RECOMENDED_ACTIVE = 1;
    const RECOMENDED_DISABLE = 0;

    /**
     * @var array
     */
    public $attachments;

    /**
     * @var array
     */
    public $thumbnail;

    public static function sitemap()
    {
        return self::find()->active();
    }

    public function getSitemapUrl()
    {
        switch ($this->category_id){
            case $this::CAT_SUPPORT:
                return Url::toRoute([
                    'article/support/',
                    'slug' => $this->slug,
                ], true);
                break;
            case $this::CAT_BLOG:
                return Url::toRoute([
                    'article/blog/',
                    'slug' => $this->slug,
                ], true);
                break;
            case $this::CAT_VIDEO:
                return Url::toRoute([
                    'article/view',
                    'slug' => $this->slug,
                ], true);
                break;
            default:
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @return ArticleQuery
     */
    public static function find()
    {
        return new \common\models\query\ArticleQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'immutable' => true
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'attachments',
                'multiple' => true,
                'uploadRelation' => 'articleAttachments',
                'pathAttribute' => 'path',
                'baseUrlAttribute' => 'base_url',
                'orderAttribute' => 'order',
                'typeAttribute' => 'type',
                'sizeAttribute' => 'size',
                'nameAttribute' => 'name',
            ],
            [
                'class' => UploadBehavior::className(),
                'attribute' => 'thumbnail',
                'pathAttribute' => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url'
            ],
            [
                 'class'                 => TaggableBehavior::className(),
                 'tagValuesAsArray'      => true,
                 'tagRelation'           => 'articleTags',
                 'tagValueAttribute'     => 'name',
                 'tagFrequencyAttribute' => false,
             ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'body', 'category_id'], 'required'],
            [['slug'], 'unique'],
            [['body'], 'string'],
            [['published_at'], 'default', 'value' => function () {
                return date(DATE_ISO8601);
            }],
            [['published_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['category_id'], 'exist', 'targetClass' => ArticleCategory::className(), 'targetAttribute' => 'id'],
            [['status'], 'integer'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
            [['view'], 'string', 'max' => 255],
            [['text_short', 'video', 'meta_title', 'meta_description', 'meta_keywords'], 'string'],
            [['mark_id','is_recommended'], 'integer'],
            ['is_recommended', 'in', 'range' => array_keys(self::getRecommendedArray())],
            [['attachments', 'thumbnail'], 'safe'],
            ['tagValues', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'slug' => Yii::t('common', 'Slug'),
            'title' => Yii::t('common', 'Title'),
            'text_short' => 'Аннотация',
            'body' => Yii::t('common', 'Body'),
            'view' => Yii::t('common', 'Article View'),
            'thumbnail' => Yii::t('common', 'Thumbnail'),
            'category_id' => Yii::t('common', 'Category'),
            'status' => Yii::t('common', 'Published'),
            'published_at' => Yii::t('common', 'Published At'),
            'created_by' => Yii::t('common', 'Author'),
            'updated_by' => Yii::t('common', 'Updater'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'mark_id' => 'Марка',
            'is_recommended' => 'Рекомендованая статья',
            'video' => 'Фрейм видео',
            'tagValues' => 'Подкатегории',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleAttachments()
    {
        return $this->hasMany(ArticleAttachment::className(), ['article_id' => 'id']);
    }

    public static function getVideoRecommended()
    {

        return self::find()->where(['is_recommended' => 1, 'category_id' => Article::CAT_VIDEO, 'status' => 1])->all();

    }

    public static function getBlogRecommended()
    {

        return self::find()->where(['is_recommended' => 1, 'category_id' => Article::CAT_BLOG, 'status' => 1])->all();

    }

    public static function getRecommendedSupport()
    {

        return self::find()->where(['is_recommended' => 1, 'category_id' => Article::CAT_SUPPORT, 'status' => 1])->all();

    }

    public static function getRecommendedArray()
    {
        return array(
            self::RECOMENDED_ACTIVE => 'рекомендовать',
            self::RECOMENDED_DISABLE => 'не рекомендовать',
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMark()
    {
        return $this->hasOne(Mark::className(), ['id' => 'mark_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleArticleTags()
    {
        return $this->hasMany(ArticleArticleTag::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['id' => 'article_tag_id'])->viaTable('{{%article_article_tag}}', ['article_id' => 'id']);
    }


    public static function getArticleLists($catalog, $tag = false)
    {
        $query = self::find()->where(['category_id' => $catalog]);
        if($tag){
            $query->innerJoin('{{%article_article_tag}}', '{{%article_article_tag}}.article_id = {{%article}}.id')
                ->innerJoin('{{%article_tag}}', '{{%article_tag}}.id = {{%article_article_tag}}.article_tag_id')
                ->andWhere(['{{%article_tag}}.name' => $tag]);
        }
        $query->published()->orderBy(['published_at' => SORT_DESC]);
        return $query;

    }

}
