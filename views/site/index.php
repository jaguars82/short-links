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
        <h1 class="display-4">Сервис коротких ссылок</h1>

        <p class="lead">вставьте ссылку, нажмите кнопку!</p>

    </div>

    <div class="body-content">

        <?php $form = ActiveForm::begin([
            'id' => 'link-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                'inputOptions' => ['class' => 'col-lg-3 form-control'],
                'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
            ],
        ]); ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton('Создать короткую ссылку', ['class' => 'btn btn-lg btn-primary', 'name' => 'create-link-button']) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
