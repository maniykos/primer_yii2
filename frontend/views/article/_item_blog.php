<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;


?>

<?= Html::beginTag('a', ['href' => \yii\helpers\Url::to(['/article/blog', 'slug'=>$model->slug])]) ?>

    <div class="article-date-bl">
        <?= date('d / m / Y', $model->published_at); ?>
    </div>
    <?php if ($model->thumbnail_path): ?>
        <?php echo Html::img(
            Yii::$app->glide->createSignedUrl([
                'glide/index',
                'path' => $model->thumbnail_path,
                'w' => 335,
                'h' => 252
            ], true),
            ['alt' => $this->params['default_img_alt'], 'class' => '']
        ) ?>
    <?php endif; ?>
    <div class="article-name-bl mt30 mb10">
        <?= Html::encode($model->title); ?>
    </div>
    <div class="article-text-bl mb30">
        <?php echo \yii\helpers\StringHelper::truncate(strip_tags($model->text_short), 80, '...'); ?>
    </div>

    <div class="btn-green-sp">Подробнее</div>
    <?//= Html::a('Подробнее', ['/article/blog', 'slug'=>$model->slug], ['class' => 'btn-green-sp']); ?>

<?= Html::endTag('a') ?>

