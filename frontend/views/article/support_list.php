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

$this->title = Yii::t('app', 'Поддержка');

$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::t('app', 'Наши мастера дадут советы по уходу за автомобилем, предоставят инструкцию по эксплуатации Land Rover и Jaguar. Заезжайте или звоните по телефону +7 495 120-05-46! '),
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Yii::t('app', 'Поддержка'),
]);


Yii::$app->opengraph->title = $this->title;
Yii::$app->opengraph->image = \yii\helpers\Url::toRoute('/images/logo_short.png', true);
Yii::$app->opengraph->locale = 'ru_RU';

?>
    <div class="support-intro main-text">
        <div class="site-block">
            <h1 class="name-h1">Поддержка владельцев Jaguar Land Rover</h1>
            <div class="support-info-list mt30">
                <div class="support-info-bl">
                    <div class="left-bl">
                        <i class="icon-sp-instruction"></i>
                    </div>
                    <div class="right-bl">
                        Инструкции<br> по эксплуатации
                    </div>
                </div>
                <div class="support-info-bl">
                    <div class="left-bl">
                        <i class="icon-sp-wrench"></i>
                    </div>
                    <div class="right-bl">
                        Советы мастера<br> по уходу за автомобилем
                    </div>
                </div>
                <div class="support-info-bl">
                    <div class="left-bl">
                        <i class="icon-sp-error"></i>
                    </div>
                    <div class="right-bl">
                        Ошибки<br>на приборной панели
                    </div>
                </div>
                <div class="support-info-bl">
                    <div class="left-bl">
                        <i class="icon-sp-info"></i>
                    </div>
                    <div class="right-bl">
                        Техническая<br> информация
                    </div>
                </div>
            </div>

            <div class="support-text mt50">
                <div class="left-bl">
                    <div class="intro-heading">Что нужно владельцу идеального автомобиля?<br> Первоклассная поддержка профессионалов!</div>
                    <p class="mt40">Современные модели Land Rover и Jaguar это технологически сложные машины, которые оснащены большим количеством устройств, обеспечивающих комфорт водителя и пассажиров. Иногда у владельцев этих автомобилей могут возникнуть затруднения с тем или иным оснащением. Чтобы помочь найти быстрое решение, не прибегая к услугам автосервиса, в этом разделе мы публикуем статьи и советы мастеров нашего сервиса, которые помогут вам справиться с возможными незначительными неприятностями, а также полезные советы по уходу за автомобилем, которые помогут сохранить его работоспособность.</p>
                </div>
                <div class="right-bl">
                    <img src="images/support-man.png" alt="">
                </div>
            </div>
        </div>
    </div>


    <?php $modelRecommended = \common\models\Article::getRecommendedSupport(); ?>
    <?php if (!empty($modelRecommended) && count($modelRecommended)): ?>
        <div class="mt40">
            <div class="site-block">
                <?= $this->render('//site/_item_recom_support.php', ['models' => $modelRecommended]) ?>
            </div>
        </div>
    <?php endif; ?>


    <div class="support-content main-text">
        <div class="site-block">
            <h1 class="name-h1">Свежие темы</h1>

            <?= ListView::widget([
                'id' => 'articles-list',
                'layout' => "{items}{pager}",
                'pager' => [
                    'prevPageLabel' => 'Назад',
                    'nextPageLabel' => 'Вперед',
                    'options' => [
                        'class' => 'pagination-bl'
                    ]
                ],
                'dataProvider' => new ActiveDataProvider([
                    'query' => \common\models\Article::find()->where(['category_id' => \common\models\Article::CAT_SUPPORT])->published()->orderBy(['published_at' => SORT_DESC]),
                    'pagination' => [
                        'pageSize' => 3,
                    ],
                ]),
                'itemView' => '_item_support',
                'itemOptions' => ['class' => 'support-content-list cf'],
            ]) ?>

        </div>
    </div>
    <br>

    <div class="support-subscribe main-text">
        <div class="site-block">
            <h1 class="name-h1">Будь в курсе!<br> Персональная рассылка для Вас</h1>
            <div class="cf">
                <div class="grid12-7 grid12-ph-12">
                    <p>Чтобы не пропустить полезные советы и интересные статьи от профессионалов по ремонту и обслуживанию Land Rover и Jaguar, подпишитесь на нашу рассылку.</p>
                    <div class="mt40">
                        <?= common\widgets\SubscriptionWidget::widget(['view' => 'subscribe_reverse']) ?>
                    </div>
                </div>
                <div class="grid12-5 grid12-ph-12">
                    <img src="images/support-subscribe.png" alt="">
                </div>
            </div>
        </div>
    </div>

    <div class="support-help mb40">
        <h1 class="name-h1">Мне нужна помощь</h1>
        <button title="Заказать бесплатную консультацию профессионала"
                data-text="Заказать бесплатную консультацию профессионала"
                data-title="Заказать бесплатную консультацию профессионала"
                data-title_change="1"
                class="btn-help service_price_message">обратиться в службу поддержки</button>
    </div>

<? //= $this->render('//partial/map') ?>