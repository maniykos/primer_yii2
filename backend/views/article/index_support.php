<?php

use common\grid\EnumColumn;
use common\models\ArticleCategory;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Article;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cтатьи поддержки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">
    <p>
        <?= Html::a(
            Yii::t('backend', 'Создать статью'),
            ['create', 'category_id' => Article::CAT_SUPPORT],
            ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [

            'id',
            'slug',
            'title',
            [
                'class' => EnumColumn::className(),
                'attribute' => 'status',
                'enum' => [
                    Yii::t('backend', 'Not Published'),
                    Yii::t('backend', 'Published')
                ]
            ],
            'created_at:datetime',
            // 'updated_at',

            [
                'attribute' => 'mark_id',
                'filter'    => \common\models\Mark::getMarksFilterArray(),
                'value'     => 'mark.name',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ]
        ]
    ]); ?>
</div>
