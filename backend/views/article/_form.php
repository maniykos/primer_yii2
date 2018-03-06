<?php

use trntv\filekit\widget\Upload;
use trntv\yii\datetime\DateTimeWidget;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $categories common\models\ArticleCategory[] */
/* @var $form yii\bootstrap\ActiveForm */

if(!$model->category_id){
    $model->category_id = Yii::$app->request->get('category_id');
}
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'slug')
        ->hint(Yii::t('backend', 'If you\'ll leave this field empty, slug will be generated automatically'))
        ->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'mark_id')->dropDownList(\common\models\Mark::getParentMarksFilterArray(), [
        'prompt' => 'Выберите марку автомобиля',
    ]) ?>


    <?php if(!$model->category_id): ?>
        <?php echo $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(
                $categories,
                'id',
                'title'
            ), ['prompt'=>'']) ?>
    <?php else: ?>
        <input type="hidden" name="Article[category_id]" value="<?= $model->category_id ?>">
    <?php endif; ?>

    <?php echo $form->field($model, 'tagValues')->widget(Select2::className(), [
        'options'       => [
            'placeholder' => 'Вводите услуги через запятую',
            'multiple'    => true,
            'theme'       => Select2::THEME_BOOTSTRAP,
        ],
        'data'          => \common\models\ArticleTag::find()->select(['name', 'id'])->indexBy('name')->column(),
        'maintainOrder' => true,
        'pluginOptions' => [
            'tokenSeparators' => [","],
            'allowClear'      => true,
            'tags' => true,
        ],
    ]);
    ?>
    <?php echo $form->field($model, 'text_short')->widget(
        \yii\imperavi\Widget::className()
    ) ?>

    <?php echo $form->field($model, 'body')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options' => [
                'replaceDivs' => false,
                'minHeight' => 400,
                'maxHeight' => 400,
                'buttonSource' => true,
                'convertDivs' => false,
                'removeEmptyTags' => false,
                'imageUpload' => Yii::$app->urlManager->createUrl(['/file-storage/upload-imperavi'])
            ]
        ]
    ) ?>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'thumbnail')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'maxFileSize' => 5000000, // 5 MiB
        ]);
    ?>

    <?php /* echo $form->field($model, 'attachments')->widget(
        Upload::className(),
        [
            'url' => ['/file-storage/upload'],
            'sortable' => true,
            'maxFileSize' => 10000000, // 10 MiB
            'maxNumberOfFiles' => 10
        ]);
        */
    ?>

    <?php if(!$model->category_id): ?>
        <?php  echo $form->field($model, 'view')->textInput(['maxlength' => true]) ?>
    <?php else: ?>
        <input type="hidden" name="Article[view]" value="video_view">
    <?php endif; ?>

    <?php echo $form->field($model, 'is_recommended')->label(true)->inline(false)->radioList(\common\models\Article::getRecommendedArray()) ?>

    <?php echo $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>



    <?php  echo $form->field($model, 'published_at')->widget(
        DateTimeWidget::className(),
        [
            'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ'
        ]
    ) ?>

    <div class="form-group">
        <?php echo Html::submitButton(
            $model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
