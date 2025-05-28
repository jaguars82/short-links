<?php

namespace app\models;

use Yii;

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
class Visit extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['link_id', 'ip_address', 'accessed_at'], 'required'],
            [['link_id', 'accessed_at'], 'integer'],
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
