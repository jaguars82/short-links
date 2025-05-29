<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\LinkForm;

class SiteController extends Controller
{

    /**
     * Displays homepage (a form to enter the url).
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new LinkForm();

        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
