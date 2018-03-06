<?php

namespace common\models\search;

use yii\db\ActiveQueryInterface;
use yii\db\ActiveRecord;
/**
 * AdvantageSearch represents the model behind the search form about `common\models\Advantage`.
 */

/**
 * Home static page search model.
 *
 * @property integer $id
 * @property string $slug
 * @property string $description
 */

class ArticleSearch extends ActiveRecord implements \vintage\search\interfaces\CustomSearchInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }
    /**
     * @inheritdoc
     */
    public function getSearchTitle() {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function getSearchDescription() {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function getSearchUrl() {
        return 'home';
    }

    /**
     * @inheritdoc
     */
    public function getSearchFields() {
        return [
            'title',
            'body'
        ];
    }

    /**
     * @inheritdoc
     */
    public function getQuery(ActiveQueryInterface $query, $field, $searchQuery)
    {

        $result = $query->orWhere([
            'and',
            ['like', $field, $searchQuery],
        ]);

        return $result;

    }
}