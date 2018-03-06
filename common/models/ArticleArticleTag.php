<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article_article_tag".
 *
 * @property int $article_id
 * @property int $article_tag_id
 * @property string $created_at
 *
 * @property Article $article
 * @property ArticleTag $articleTag
 */
class ArticleArticleTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_article_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'article_tag_id'], 'required'],
            [['article_id', 'article_tag_id'], 'integer'],
            [['created_at'], 'safe'],
            [['article_id', 'article_tag_id'], 'unique', 'targetAttribute' => ['article_id', 'article_tag_id']],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
            [['article_tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleTag::className(), 'targetAttribute' => ['article_tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => 'Article ID',
            'article_tag_id' => 'Article Tag ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTag()
    {
        return $this->hasOne(ArticleTag::className(), ['id' => 'article_tag_id']);
    }
}
