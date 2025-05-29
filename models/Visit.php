<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "visit".
 *
 * @property int $id
 * @property int $link_id
 * @property string $ip_address
 * @property int $accessed_at
 *
 * @property Link $link
 */
class Visit extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'visit';
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'accessed_at',
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
            [['link_id', 'ip_address'], 'required'],
            [['link_id'], 'integer'],
            [['ip_address'], 'string', 'max' => 45],
            [['link_id'], 'exist', 'skipOnError' => true, 'targetClass' => Link::class, 'targetAttribute' => ['link_id' => 'id']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_id' => 'Link ID',
            'ip_address' => 'Ip Address',
            'accessed_at' => 'Accessed At',
        ];
    }

    
    /**
     * Gets query for [[Link]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(Link::class, ['id' => 'link_id']);
    }

}
