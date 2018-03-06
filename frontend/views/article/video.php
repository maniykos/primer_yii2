<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = Yii::t('frontend', 'Видео техцентра Service Park – как мы работаем');

$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Видео-представление компании Сервис Парк, а также различные видео, на которых видно как мы работаем. Оцените нашу работу сами!',
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'Видео',
]);

Yii::$app->opengraph->title = $this->title;
Yii::$app->opengraph->image = \yii\helpers\Url::toRoute('/images/logo_short.png', true);
Yii::$app->opengraph->locale = 'ru_RU';

?>

<div class="site-block">
  <h1 class="name-h1">Видео техцентра Сервис Парк</h1>

  <div class="main-text">
    <div id="oil-brands" class="tab-all-models cf">
      <a href="/allvideo" title="Все Модели" class="oil-brands__button <?= $slug ? '' : 'on' ?>">Все</a>
      <a href="/allvideo?slug=land-rover" title="Land Rover" class="oil-brands__button <?= $slug=='land-rover' ? 'on' : '' ?>">Land Rover</a>
      <a href="/allvideo?slug=jaguar" title="Jaguar" class="oil-brands__button <?= $slug=='jaguar' ? 'on' : '' ?>">Jaguar</a>
    </div>

    <div class="tab-content-models oil-brand cf">
        <?php if (count($models) > 0): ?>
          <?php foreach ($models as $model) : ?>
              <div class="grid-row cf">
                <div class="grid12-4 grid12-ph-5 grid12-m-12">
                    <?php if ($model->thumbnail_path): ?>
                        <?php echo Html::img(
                            Yii::$app->glide->createSignedUrl([
                                'glide/index',
                                'path' => $model->thumbnail_path,
                            ], true),
                            ['alt' => $this->params['default_img_alt'], 'class' => '']
                        ) ?>
                    <?php endif; ?>

                </div>
                <div class="grid12-8 grid12-ph-7 grid12-m-12">
                  <h4><?= Html::encode($model->title) ?></h4>
                  <?php echo \yii\helpers\StringHelper::truncateWords($model->text_short, 350, '...', null, true) ?>
                    <?= Html::a('Подробнее', ['/article/view', 'slug'=>$model->slug], ['class' => 'more']) ?>
                </div>
              </div>
          <?php endforeach; ?>
        <?php else: ?>
            <span style="font-size: 20px;">Нет видео</span>
        <?php endif; ?>

        <?php
        // отображаем постраничную разбивку
        echo LinkPager::widget([
            'pagination' => $pages,
            'registerLinkTags' => true,
            'prevPageLabel'=>'Назад',
            'nextPageLabel'=>'Вперед',
            'options' => [
                'class' => 'pager-ul',
                'prevPageLabel' => 'previous',
                'nextPageLabel' => 'next',
                'pageCssClass' => 'filter_nav',
                'firstPageCssClass' => 'lknflbes',
                'maxButtonCount' => 1,
            ]
        ]);
        ?>
    </div>

  </div>
</div>





