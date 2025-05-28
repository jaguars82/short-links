<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LinkForm is the model behind the link form.
 */
class LinkForm extends Model
{
    public $original_url;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['original_url', 'required'],
            [
                'original_url',
                'url',
                'validSchemes' => ['http', 'https'],
                'defaultScheme' => 'https',
                'enableIDN' => true,
            ],
        ];
    }

    /**
     * @return array the label attributes.
     */
    public function attributeLabels()
    {
        return [
            'original_url' => 'Ссылка',
        ];
    }
}