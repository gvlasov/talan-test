<?php

namespace api\modules\v1\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property string $title
 * @property int $created_by_id
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $deleted_at
 *
 * @property User $createdBy
 * @property Message[] $messages
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'created_by_id', 'created_at', 'updated_at'], 'required'],
            [['created_by_id', 'created_at', 'updated_at', 'deleted_at'], 'integer'],
            [['title'], 'string', 'max' => 1024],
            [['created_by_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'created_by_id' => 'Created By ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by_id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['chat_id' => 'id']);
    }
}
