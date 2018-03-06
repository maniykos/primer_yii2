<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article_tag".
 *
 * @property int $id
 * @property string $name
 *
 * @property ArticleArticleTag[] $articleArticleTags
 * @property Article[] $articles
 */
class ArticleTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleArticleTags()
    {
        return $this->hasMany(ArticleArticleTag::className(), ['article_tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])->viaTable('article_article_tag', ['article_tag_id' => 'id']);
    }
}
