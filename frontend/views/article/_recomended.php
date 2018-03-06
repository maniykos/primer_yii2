<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;

?>

<?php if(count($models) > 0):?>
    <div class="grid12-4 grid12-m-12 youtube-video-right">
        <p>Рекомендуем посмотреть</p>
        <?php foreach ($models as $model): ?>
            <?= Html::beginTag('a', ['href' => \yii\helpers\Url::to(['/article/view', 'slug' => $model->slug]), 'class' => '']) ?>
            <?php if ($model->thumbnail_path): ?>
                <?php echo Html::img(
                    Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => $model->thumbnail_path,
                    ], true),
                    ['alt' => $this->params['default_img_alt'], 'class' => 'article-thumb img-rounded pull-left']
                ) ?>
            <?php endif; ?>
            <b><?= $model->title ?></b>
            <?= Html::endTag('a') ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>