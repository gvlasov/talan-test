<?php

namespace api\modules\v1\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $user_id
 * @property int $chat_id
 * @property string $text
 * @property int $created_at
 * @property int|null $deleted_at
 *
 * @property Chat $chat
 * @property User $user
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'chat_id', 'text', 'created_at'], 'required'],
            [['user_id', 'chat_id', 'created_at', 'deleted_at'], 'integer'],
            [['text'], 'string', 'max' => 1024],
            [['chat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Chat::className(), 'targetAttribute' => ['chat_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'chat_id' => 'Chat ID',
            'text' => 'Text',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Chat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChat()
    {
        return $this->hasOne(Chat::className(), ['id' => 'chat_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
