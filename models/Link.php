<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

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
class Link extends ActiveRecord
{
    const SHORT_CODE_LENGTH = 6;

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
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => null,
                'value' => time(),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['visit_count'], 'default', 'value' => 0],
            [['original_url', 'short_code'], 'required'],
            [
                ['original_url'],
                'url',
                'validSchemes' => ['http', 'https'],
                'defaultScheme' => 'https',
                'enableIDN' => true,
            ],
            [['created_at', 'visit_count'], 'integer'],
            [['short_code'], 'string', 'max' => self::SHORT_CODE_LENGTH],
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

}
