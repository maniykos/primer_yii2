<?php

namespace backend\controllers;

use Yii;
use common\models\Article;
use backend\models\search\ArticleSearch;
use \common\models\ArticleCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ]
            ]
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['published_at'=>SORT_DESC]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            switch ($model->category_id){
                case Article::CAT_VIDEO:
                    return $this->redirect(['video']);
                break;
                case Article::CAT_SUPPORT:
                    return $this->redirect(['support']);
                    break;
                case Article::CAT_BLOG:
                    return $this->redirect(['blog']);
                    break;
                default:
                    return $this->redirect(['index']);
            }
        } else {

            return $this->render('create', [
                'model' => $model,
                'categories' => ArticleCategory::find()->active()->all(),
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            switch ($model->category_id){
                case Article::CAT_VIDEO:
                    return $this->redirect(['video']);
                    break;
                case Article::CAT_SUPPORT:
                    return $this->redirect(['support']);
                    break;
                case Article::CAT_BLOG:
                    return $this->redirect(['blog']);
                    break;
                default:
                    return $this->redirect(['index']);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => ArticleCategory::find()->active()->all(),
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        switch ($model->category_id){
            case Article::CAT_VIDEO:
                return $this->redirect(['video']);
                break;
            case Article::CAT_SUPPORT:
                return $this->redirect(['support']);
                break;
            case Article::CAT_BLOG:
                return $this->redirect(['blog']);
                break;
            default:
                return $this->redirect(['index']);
        }

        return $this->redirect([$view]);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionVideo()
    {

        $arrParams = Yii::$app->request->queryParams;
        $arrParams['ArticleSearch']['category_id'] = Article::CAT_VIDEO;
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($arrParams);
        $dataProvider->sort = [
            'defaultOrder'=>['published_at'=>SORT_DESC]
        ];

        return $this->render('index_video', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider
        ]);
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionSupport()
    {

        $arrParams = Yii::$app->request->queryParams;
        $arrParams['ArticleSearch']['category_id'] = Article::CAT_SUPPORT;
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($arrParams);
        $dataProvider->sort = [
            'defaultOrder'=>['published_at'=>SORT_DESC]
        ];

        return $this->render('index_support', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider
        ]);
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionBlog()
    {

        $arrParams = Yii::$app->request->queryParams;
        $arrParams['ArticleSearch']['category_id'] = Article::CAT_BLOG;
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search($arrParams);
        $dataProvider->sort = [
            'defaultOrder'=>['published_at'=>SORT_DESC]
        ];

        return $this->render('index_blog', [
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider
        ]);
    }

}
