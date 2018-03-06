<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View
 * @var $video         \common\models\Video
 * @var $contacts      \common\models\ContactPerson
 * @var $advantages    \common\models\Advantage[]
 * @var $servicePrices \common\models\ServicePrice[]
 * @var $seo           \common\models\Seo
 * @var $itemsMark     array
 * @var $photos   \common\models\Gallery[]
 */

$this->title = Yii::t('app', 'Блог');

$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::t('app', 'Наши мастера дадут советы по уходу за автомобилем, предоставят инструкцию по эксплуатации Land Rover и Jaguar. Заезжайте или звоните по телефону +7 495 120-05-46! '),
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Yii::t('app', 'Блог'),
]);


Yii::$app->opengraph->title = $this->title;
Yii::$app->opengraph->image = \yii\helpers\Url::toRoute('/images/logo_short.png', true);
Yii::$app->opengraph->locale = 'ru_RU';


$this->params['breadcrumbs'] = [
    ['label' => Html::encode($this->title), 'url' => null],
];
?>

<div class="mt40">
    <div class="blog-mobile-select">
        <div class="to-select__name">Рубрики</div>
        <select id="article_blog_select"  class="to-select__select selectbox"  onchange="blogNextUrlPage()" data-url="<?= \yii\helpers\Url::to(['article/blog-list'], true) ?>" >
            <option value="all" <?php if(!$activeTag){echo 'selected';} ?> >
                Все записи
            </option>
            <?php foreach($tags as $tag): ?>
                <option value="?tag=<?= $tag->name; ?>" <?= $activeTag == $tag->name ? 'selected' : '' ?>>
                        <?= $tag->name; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="border-top-gray">
        <div class="site-block">
            <div class="article-block">
                <div class="left-bl">
                    <div>
                        <div class="rubric-name-bl mt40">Рубрики</div>
                        <ul class="rubric-ul">
                            <li class="<?php if(!$activeTag){echo 'active';} ?>">
                                <?= Html::beginTag('a', ['href' => \yii\helpers\Url::to(['article/blog-list'])]) ?>
                                    Все записи
                                <?= Html::endTag('a') ?>
                            </li>
                            <?php foreach($tags as $tag): ?>
                                <li class="<?= $activeTag == $tag->name ? 'active' : '' ?>" >
                                    <?= Html::beginTag('a', ['href' => \yii\helpers\Url::to(['article/blog-list', 'tag' => $tag->name])]) ?>
                                        <?= $tag->name; ?>
                                    <?= Html::endTag('a') ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="right-bl">
                    <?= ListView::widget([
                        'options' => [
                            'tag' => 'section',
                            'class' => 'article-lists',
                            'id' => 'articles-list'
                        ],
                        'layout' => "{items}{pager}",
                        'pager' => [
                            'prevPageLabel' => 'Назад',
                            'nextPageLabel' => 'Вперед',
                            'options' => [
                                'class' => 'pagination-bl'
                            ]
                        ],
                        'dataProvider' => new ActiveDataProvider([
                            'query' => $dataQuery,
                            'pagination' => [
                                'pageSize' => 6,
                            ],
                        ]),
                        'itemView' => '_item_blog',
                        'itemOptions' => ['class' => 'article-list cf'],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->render('//partial/map') ?>

<?php
$script = <<< JS
    function blogNextUrlPage() {
      var item = $('#article_blog_select').val();      
      var url = $('#article_blog_select').data('url');
      
      if(item !=  'all'){
          url = url + item;
      }
      
      window.location.replace(url);
      
    }
JS;
$this->registerJs($script, yii\web\View::POS_BEGIN);
?>

