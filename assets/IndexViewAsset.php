<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Asset bundle for index page.
 */
class IndexViewAsset extends \yii\web\AssetBundle
{
    public $js = [
        'js/index-view.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}