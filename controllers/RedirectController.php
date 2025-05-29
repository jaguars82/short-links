<?php

namespace app\controllers;

use Yii;
use app\models\Link;
use app\models\Visit;

class RedirectController extends \yii\web\Controller
{

    /**
     * Handles redirection for short URLs
     * @param string $shortCode
     * @return Response
     */
    public function actionVisit($shortCode)
    {
        $url = Link::findOne(['short_code' => $shortCode]);

        if ($url) {
            // Log the visit
            $visit = new Visit();
            $visit->link_id = $url->id;
            $visit->ip_address = Yii::$app->request->userIP;
            $visit->save();

            // Increment visit counter
            $url->visit_count += 1;
            $url->save();

            return $this->redirect($url->original_url);
        }
        throw new \yii\web\NotFoundHttpException('Ссылка не найдена');
    }

}