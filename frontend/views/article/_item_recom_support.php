<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;
?>

<h2 class="name_block">Рекомендованные темы</h2>
<div id="support-recom__link" class="support-recom-lists we-best__carusel carusel dots-line">
    <div class="we-best__carusel-block">
        <div class="we-best__carusel-arrow"></div>
        <div class="we-best__list cf">
            <?php $i = 0; ?>
            <?php foreach ($models as $model) : ?>
                <?php $active = '';
                if ($i === 0) {
                    $active = ' on';
                }
                ?>
                <div class="support-recom-list <?= $active ?>">
                    <div class="title-bl">
                        <?= Html::beginTag('a', ['href' => \yii\helpers\Url::to(['/article/support', 'slug' => $model->slug])]) ?>
                            <?= $model->title ?>
                        <?= Html::endTag('a') ?>
                        <hr>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php

$script2 = <<< JS
    $(document).ready(function () {        

	$("#support-recom__link .we-best__list").slick({
		dots: true,
		infinite: true,
		speed: 1000,
		slidesToShow: 4,
		slidesToScroll: 4,
		autoplay: true,
		autoplaySpeed: 10000,
		appendArrows: $('#we-best__link .we-best__carusel-arrow'),
		appendDots: $('#we-best__link'),
		responsive: [
			{
			  breakpoint: 1920,
			  settings: {
				slidesToShow: 4,
                slidesToScroll: 4,
			  }

			},
			{
			  breakpoint: 1280,
			  settings: {
				slidesToShow: 3,
				slidesToScroll: 3,
			  }
			},
			{
			  breakpoint: 768,
			  settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
                
			  }
			}
		]
	}).on('afterChange', function(event, slick, currentSlide){
        var countSlide = currentSlide +1;
        $('#we-best__content .we-best__result-item').removeClass('on');
        $('#we-best__content .we-best__result-item:nth-child(' +countSlide+ ')').addClass('on');
    });
    });
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
    $this->registerJs($script2, yii\web\View::POS_END);

?>
