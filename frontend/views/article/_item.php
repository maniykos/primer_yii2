<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;

?>

<div class="grid12-4 grid12-ph-5 grid12-m-12">
    <?php if ($model->thumbnail_path): ?>
        <?php echo Html::img(
            Yii::$app->glide->createSignedUrl([
                'glide/index',
                'path' => $model->thumbnail_path,
                'w' => 100
            ], true),
            ['alt' => $this->params['default_img_alt'], 'class' => 'article-thumb img-rounded pull-left']
        ) ?>
    <?php endif; ?>
</div>
<div class="grid12-8 grid12-ph-7 grid12-m-12">
    <h4><?= Html::encode($model->title) ?></h4>
    <?php echo \yii\helpers\StringHelper::truncateWords($model->body, 350, '...', null, true) ?>
    <?= Html::a('Подробнее', ['/article/view', 'slug'=>$model->slug], ['class' => 'more']) ?>
</div>


