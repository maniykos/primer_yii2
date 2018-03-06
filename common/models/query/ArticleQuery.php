<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\Article;
use yii\db\ActiveQuery;

class ArticleQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['status' => Article::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%article}}.published_at', time()]);
        return $this;
    }

    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => Article::STATUS_PUBLISHED]);
    }

    /**
     * @inheritdoc
     * @return \common\models\ServiceType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ServiceType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
