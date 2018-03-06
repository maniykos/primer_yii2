<?php

namespace frontend\controllers;

use common\components\CustomController;
use common\models\Article;
use common\models\ArticleArticleTag;
use common\models\ArticleTag;
use common\models\ArticleAttachment;
use common\models\Mark;
use common\models\ServicePrice;
use frontend\models\search\ArticleSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use common\models\ContactPerson;
use yii\data\Pagination;
use yii\db\ActiveQuery;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends CustomController
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $this->render('index', ['dataProvider'=>$dataProvider]);
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $model = Article::find()->published()->andWhere(['slug'=>$slug])->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }

        $viewFile = $model->view ?: 'view';
        return $this->render($viewFile, ['model'=>$model]);
    }

    /**
     * @param $id
     * @return $this
     * @throws NotFoundHttpException
     * @throws \yii\web\HttpException
     */
    public function actionAttachmentDownload($id)
    {
        $model = ArticleAttachment::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException;
        }

        return Yii::$app->response->sendStreamAsFile(
            Yii::$app->fileStorage->getFilesystem()->readStream($model->path),
            $model->name
        );
    }

    /**
     * @return string
     */
    public function actionVideo($slug = null)
    {

        // выполняем запрос

        // делаем копию выборки
        if($slug){
            $mark = Mark::find()->where(['slug' => $slug])->one();
            if($mark){
                $query = Article::find()->where(['category_id'=> Article::CAT_VIDEO, 'status' => Article::STATUS_PUBLISHED, 'mark_id' => $mark->id]);
            }else{
                throw new NotFoundHttpException;
            }
        }else{
            $query = Article::find()->where(['category_id'=> Article::CAT_VIDEO, 'status' => Article::STATUS_PUBLISHED]);
        }

        $countQuery = clone $query;

        $query->orderBy('created_at DESC');

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);

        $pages->pageSizeParam = false;
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('video', [
            'models' => $models,
            'pages' => $pages,
            'slug' => $slug
        ]);

    }

    public function actionSupportList()
    {
        return $this->render('support_list');
    }

    public function actionBlogList()
    {
        $tag = trim(Yii::$app->request->get('tag', false));

        $dataQuery = Article::find()->where(['category_id' => Article::CAT_BLOG]);
        if ($tag) {
            $dataQuery->innerJoin('{{%article_article_tag}}', '{{%article_article_tag}}.article_id = {{%article}}.id')
                ->innerJoin('{{%article_tag}}', '{{%article_tag}}.id = {{%article_article_tag}}.article_tag_id')
                ->andWhere(['{{%article_tag}}.name' => $tag]);
        }

        $dataQuery->published()->orderBy(['published_at' => SORT_DESC]);


        $objDataModel = clone $dataQuery;
        $objModel = $objDataModel->one();

        if (empty($objModel)) {
            throw new NotFoundHttpException('Раздел недоступен!');
        }

        $articleTags = ArticleTag::find()
            ->innerJoinWith(['articleArticleTags'])
            ->groupBy('{{%article_tag}}.id')
            ->all();

        return $this->render('blog_list',['dataQuery' => $dataQuery, 'tags' => $articleTags, 'activeTag' => $tag]);
    }

    /**
     * @return string
     */
    public function actionSupport($slug = null)
    {

        $model = Article::find()->published()->andWhere(['slug'=>$slug])->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }


        return $this->render('support_view.php', ['model'=>$model]);

    }

    /**
     * @return string
     */
    public function actionBlog($slug = null)
    {

        $model = Article::find()->published()->andWhere(['slug'=>$slug])->one();
        if (!$model) {
            throw new NotFoundHttpException;
        }


        return $this->render('blog_view.php', ['model'=>$model]);

    }

    /**
     * @return string
     */
    public function actionServicePrice($slug = null)
    {
        if($slug == null){throw new NotFoundHttpException;}

        $model = ServicePrice::find()
            ->where(['slug' => $slug])
            ->with(['infoblok'])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException;
        }


        return $this->render('service', [
            'models' => $model,
            'slug' => $slug,
            'gallery' => $model->galleries,
        ]);

    }
}
