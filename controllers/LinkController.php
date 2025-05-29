<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\LinkForm;
use app\models\service\Link;

class LinkController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'shorten' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Handles URL shortening & saving to DB
     * @return array
     */
    public function actionShorten()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $form = new LinkForm();
        
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            $model = new Link();
            $model->setAttributes($form->attributes);
            
            // Check URL accessibility
            if (!$model->isAccessible()) {
                return ['success' => false, 'message' => 'URL сейчас не доступен'];
            }

            // Generate short code
            $model->short_code = Link::generateShortCode();

            if ($model->save()) {
                $qrUrl = $model->qr;
                return [
                    'success' => true,
                    'message' => 'Ссылка сгенерирована',
                    'shortUrl' => $model->shortUrl,
                    'qrCode' => $model->qr,
                ];
            }
        }
        return ['success' => false, 'message' => 'Невалидный URL'];
    }

}
