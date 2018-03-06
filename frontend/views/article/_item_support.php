<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;

?>

<div class="left-bl">
    <?php if ($model->thumbnail_path): ?>
        <?php echo Html::img(
            Yii::$app->glide->createSignedUrl([
                'glide/index',
                'path' => $model->thumbnail_path,
                'w' => 409
            ], true),
            ['alt' => $this->params['default_img_alt'], 'class' => '']
        ) ?>
    <?php endif; ?>
</div>
<div class="right-bl">
    <h4><?= Html::encode($model->title) ?></h4>
    <?php echo \yii\helpers\StringHelper::truncateWords($model->text_short, 80, '', 'p', true) ?>
    <?= Html::a('Подробнее', ['/article/support', 'slug'=>$model->slug], ['class' => 'more']) ?>
</div>


