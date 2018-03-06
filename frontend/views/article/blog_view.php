<?php

use yii\helpers\Html;

if (!empty($model->meta_title)) {
    $this->title = Yii::t('app', $model->meta_title);
}
if (!empty ($model->meta_description)) {
    $this->registerMetaTag([
        'name' => 'description',
        'content' => Yii::t('app',
            $model->meta_description
        ),
    ]);
}
if (!empty ($model->meta_keywords)) {
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => Yii::t('app', $model->meta_keywords),
    ]);
}

/* @var $this yii\web\View */
/* @var $model common\models\Article */
$this->title = $model->title;
$this->params['breadcrumbs'] = [
    ['label' => 'Блог', 'url' => '/blog'],
    ['label' => Html::encode($this->title), 'url' => null],
];

//opengraph
Yii::$app->opengraph->title = Html::encode(Html::encode($model->meta_title));
Yii::$app->opengraph->description = $model->meta_description;
if (!empty($model->thumbnail_path) && $model->thumbnail_path) {
    Yii::$app->opengraph->image =  \yii\helpers\Url::toRoute(Yii::$app->glide->createSignedUrl([
        'glide/index',
        'path' => $model->thumbnail_path,
        'w' => 367
    ], true), true);
} else {
    Yii::$app->opengraph->image = \yii\helpers\Url::toRoute('/images/logo_short.png', true);
}
Yii::$app->opengraph->locale = 'ru_RU';

// JsonLD
$doc = [
    "@type" => "http://schema.org/Article",
    "http://schema.org/mainEntityOfPage" => (object)[
        "@type" => "http://schema.org/WebPage",
        "@id" => $model->getSitemapUrl(),
    ],
    "http://schema.org/url" => $model->getSitemapUrl(),
    "http://schema.org/datePublished" => date('Y-m-d', $model->published_at),
    "http://schema.org/headline" => $model->title,
    "http://schema.org/image" => (object)[
        "@type" => "ImageObject" ,
        "http://schema.org/url" => \yii\helpers\Url::toRoute('/images/logo_short.png', true),
    ],
    "http://schema.org/articleBody" => $model->text_short,
    "http://schema.org/author" => (object)[
        "@type" => "http://schema.org/Person",
        "http://schema.org/name" => "Мастер техцентра Сервис Парк",
    ],
    "http://schema.org/publisher" => (object)[
        "@type" => "http://schema.org/Organization",
        "http://schema.org/name" => "Мастер техцентра Сервис Парк",
        "http://schema.org/logo" => (object)[
            "@type" => "ImageObject" ,
            "http://schema.org/url" => \yii\helpers\Url::toRoute('/images/logo_short.png', true),
         ]
    ],
];

\nirvana\jsonld\JsonLDHelper::add($doc);

?>

<div class="site-block">
    <h1 class="name-h1"><?= $model->title ?></h1>
</div>

<div class="main-text">
    <div class="site-block cf">
        <div class="youtube-video-left">
            <?php if (!empty($model->video)): ?>
                <div class="youtube-video-wrapper">
                    <?=  $model->video ?>
                </div>
            <?php endif; ?>

            <div class="description">
                <?=  $model->body ?>
                <a href="/blog" class="more"><img src="/images/icon-back-green.png" alt=""> Назад</a>

                <h4>Комментарии</h4>
                <div id="hypercomments_widget"></div>
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
    </div>
</div>