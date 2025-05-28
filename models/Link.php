<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property string $original_url
 * @property string $short_code
 * @property int $created_at
 * @property int $visit_count
 *
 * @property Visit[] $visits
 */
class Link extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_count'], 'default', 'value' => 0],
            [['original_url', 'short_code', 'created_at'], 'required'],
            [
                ['original_url'],
                'url',
                'validSchemes' => ['http', 'https'],
                'defaultScheme' => 'https',
                'enableIDN' => true,
            ],
            [['created_at', 'visit_count'], 'integer'],
            [['short_code'], 'string', 'max' => 6],
            [['short_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'original_url' => 'Original Url',
            'short_code' => 'Short Code',
            'created_at' => 'Created At',
            'visit_count' => 'Visit Count',
        ];
    }

    /**
     * Gets query for [[Visits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVisits()
    {
        return $this->hasMany(Visit::class, ['link_id' => 'id']);
    }

    
    /**
     * Generates a unique short code
     * @return string
     */
    public function generateShortCode()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        if (self::find()->where(['short_code' => $code])->exists()) {
            return $this->generateShortCode();
        }
        return $code;
    }

}
