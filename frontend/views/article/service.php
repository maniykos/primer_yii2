<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/**
 * @var $contacts \common\models\ContactPerson[]
 * @var $models  \common\models\ServicePrice
 * @var $photos   \common\models\Gallery[]
 */
if (!empty($models->meta_title)) {
    $this->title = Yii::t('app', $models->meta_title);
}
if (!empty ($models->meta_description)) {
    $this->registerMetaTag([
        'name'    => 'description',
        'content' => Yii::t('app',
            $models->meta_description
        ),
    ]);
}
if (!empty ($models->meta_keywords)) {
    $this->registerMetaTag([
        'name'    => 'keywords',
        'content' => Yii::t('app', $models->meta_keywords),
    ]);
}

$breadcrumbsClass = Yii::$app->controller->uniqueId == 'product' ? 'breadcrumbs-block' : 'breadcrumbs';

$this->title = $models->name;
$this->params['breadcrumbs'] = [
    ['label' => Html::encode($this->title), 'url' => null],
];
?>

<div class="main-text service-view">

     <h1 class="name-h1-bl"><?= Html::encode($models->name) ?></h1>

    <?php if($models->is_visible_text_action): ?>
        <div class="service-view-action">
            <?= $models->text_action ?>
            <div class="service-view-btn">
                <a class="service-view-nomer" href="tel:+74951200546" title="Позвонить в Service Park">+7 495 120-05-46</a>

                <?php
                    $title_catch = 'ЗАКАЗАТЬ ЗВОНОК';
                    $data_text = 'ЗАКАЗАТЬ ЗВОНОК:'.$models->name;
                    $title_is_change = true;
                ?>
                <a href="javascript:void(0);" title="Записаться" data-text="<?= $data_text ?>" data-title="<?= $title_catch ?>" data-title_change = "<?= $title_is_change ?>"
                   class="btn-bl service_price_message">ЗАКАЗАТЬ ЗВОНОК</a>
            </div>
        </div>
    <?php endif;?>


    <div class="wm-1100px">

        <section class="service-view-infoblok mt20 ">
            <?php if(count($models->infoblok) > 0): ?>
                <?php foreach ($models->infoblok as $infoblok): ?>
                    <div id="<?= $infoblok->slug; ?>" class="<?= $infoblok->is_accordion || $infoblok->name == '' ? 'no_arrow' : '' ?> ">
                        <?php if(!$infoblok->is_accordion && $infoblok->name != ''): ?>
                            <input id="ac-<?= $infoblok->id; ?>" name="accordion-<?= $infoblok->id; ?>" type="checkbox" />
                            <label for="ac-<?= $infoblok->id; ?>"><?= $infoblok->name; ?></label>
                            <article class="text-article">
                               <?= $infoblok->text ?>
                            </article>
                        <?php else: ?>
                            <label><?= $infoblok->name; ?></label>
                            <div class="text-article">
                                <?= $infoblok->text ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach;?>
            <?php endif; ?>
        </section>
    </div>
    <?php if($models->video || $gallery && count($gallery)>0): ?>
        <div id="video" class="service-view-gallery">
            <div class="wm-1100px flex-bl">
                <?php if($models->video): ?>
                    <div id="video" class="video-bl">
                        <div class="name-bl">Видео</div>
                        <article class="service-infoblok-video">
                            <?= $models->video ?>
                        </article>
                    </div>
                <?php endif; ?>
                <?php if($gallery && count($gallery)>0): ?>
                <div class="image-bl">
                    <div class="name-bl">Фотографии</div>
                    <div id="service_view__link" class="service_view__carusel ">
                        <div class="service_view__carusel-block">
                            <div class="service_view__list cf">
                                <?php foreach ($gallery as $photo): ?>
                                    <div>
                                        <?= Html::beginTag('a', ['href' => 'gallery', 'class' => 'gallery_link','title' => $photo->name, 'data-block' => 'service_view__list', 'data-pic' => $photo->logo_base_url . '/' . $photo->logo_path]) ?>
                                            <figure style='background-image: url("<?=$photo->getGlideThumb(500)?>")'></figure>
                                        <?= Html::endTag('a') ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="mt40">
        <div class="service-optional wm-1100px mt40">
            <?php if (!empty($models->price)): ?>
                <div class="service-price">
                    <figure>
                        <i class="icon-service i-repair"></i>
                    </figure>
                    <div>
                        <p>Стоимость услуги:</p>
                        <div class="service-price-b"><?= Html::encode($models->price) ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($models->deadline)): ?>
                <div class="service-price">
                    <figure>
                        <i class="icon-service i-time"></i>
                    </figure>
                    <div>
                        <p>Сроки выполнения:</p>
                        <div class="service-price-b"><?= Html::encode($models->deadline) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($models->warranty)): ?>
                <div class="service-price">
                    <figure>
                        <i class="icon-service i-guarantee"></i>
                    </figure>
                    <div>
                        <p>Гарантия:</p>
                        <div class="service-price-b"><?= Html::encode($models->warranty) ?></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?= $this->render('//partial/_payment_terminal') ?>
</div>

<div class="form page-header">
    <div class="site-block">
        <?php
        if($models->title_catch != ''){
            $title_catch = $models->title_catch;
            $data_text = $models->title_catch;
        }else{
            $data_text = $models->name;
            $title_catch = yii\helpers\StringHelper::truncate($models->name, 40, ' ...');
        }
        ?>
        <div class="form-name"><?= $data_text ?></div>
        <?= $this->render('//partial/sing-up',['text' => $data_text, 'data-title'=> $title_catch]) ?>
    </div>
</div>
<hr class="mt40">
<div class="mt40">
    <div class="wm-1100px">
        <h4>Комментарии</h4>
        <div id="hypercomments_widget" ></div>
        <script type="text/javascript">
            _hcwp = window._hcwp || [];
            _hcwp.push({widget:"Stream", widget_id: 96057});
            (function() {
                if("HC_LOAD_INIT" in window)return;
                HC_LOAD_INIT = true;
                var lang = (navigator.language || navigator.systemLanguage || navigator.userLanguage || "en").substr(0, 2).toLowerCase();
                var hcc = document.createElement("script"); hcc.type = "text/javascript"; hcc.async = true;
                hcc.src = ("https:" == document.location.protocol ? "https" : "http")+"://w.hypercomments.com/widget/hc/96057/"+lang+"/widget.js";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hcc, s.nextSibling);
            })();
        </script>
        <a href="http://hypercomments.com" rel = "nofollow" class="hc-link" title="comments widget">comments powered by HyperComments</a>
    </div>
</div>
<div class="mb40">
    <?= $this->render('//partial/shift', ['contacts' => \common\models\ContactPerson::getContactsByCheckpointArray('department')]) ?>
</div>
