<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LinkForm $model */

use app\assets\IndexViewAsset;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

IndexViewAsset::register($this);

$this->title = 'Сервис коротких ссылок';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 id="title" class="display-4">Сервис коротких ссылок</h1>
        <p id="subtitle" class="lead">вставьте ссылку, нажмите кнопку</p>
    </div>

    <div id="content" class="body-content">

        <?php $form = ActiveForm::begin([
            'id' => 'link-form',
            'enableClientScript' => false,
            'action' => ['link/shorten'],
            'fieldConfig' => [
                'template' => '<div class="d-flex justify-content-between">
                    {label}
                    {error}
                </div>
                {input}',
                'errorOptions' => ['class' => 'text-danger text-end'],
            ],
        ]); ?>

        <div class="row g-3 align-items-end">
            <div class="col-auto flex-grow-1 position-relative">
                <?= $form->field($model, 'original_url', [
                    'options' => ['class' => 'mb-0 py-1'],
                ])->textInput(['autofocus' => true]) ?>
            </div>

            <div class="col-auto">
                <?= Html::submitButton('OK', [
                    'class' => 'btn btn-lg btn-primary',
                    'name' => 'create-link-button',
                    'id' => 'submit-button',
                ]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
