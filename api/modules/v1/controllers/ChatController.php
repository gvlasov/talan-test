<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Chat;
use api\modules\v1\models\ChatUser;
use api\modules\v1\models\Message;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpHeaderAuth;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\rest\IndexAction;
use yii\rest\OptionsAction;
use yii\web\HttpException;

class ChatController extends \yii\rest\Controller
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'authenticator' => [
                    'class' => HttpHeaderAuth::class,
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
            ]
        );
    }

    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ],
            'list' => [
                'class' => IndexAction::class,
                'modelClass' => \api\modules\v1\resources\Chat::class,
                'prepareDataProvider' => [$this, 'prepareDataProvider'],
            ],
            'messages' => [
                'class' => IndexAction::class,
                'modelClass' => \api\modules\v1\resources\Message::class,
                'prepareDataProvider' => [$this, 'prepareChatMessagesDataProvider'],
            ],
            'users' => [
                'class' => IndexAction::class,
                'modelClass' => \api\modules\v1\resources\User::class,
                'prepareDataProvider' => [$this, 'prepareChatUsersDataProvider'],
            ],
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        return new ActiveDataProvider([
            'query' => \api\modules\v1\resources\Chat::find()->where(['deleted_at' => null])
        ]);
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareChatMessagesDataProvider()
    {
        return new ActiveDataProvider([
            'query' => \api\modules\v1\resources\Message::find()
                ->where(['deleted_at' => null])
                ->andWhere(['chat_id' => \Yii::$app->request->getQueryParam('chatId')])
                ->orderBy('id ASC')
        ]);
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareChatUsersDataProvider()
    {
        return new ActiveDataProvider([
            'query' => \api\modules\v1\resources\User::find()
                ->active()
                ->innerJoin('chat_user', 'user.id = chat_user.user_id')
        ]);
    }

    /**
     * @throws HttpException
     */
    public function actionCreate()
    {
        $chat = new Chat();
        $chat->created_by_id = \Yii::$app->user->identity->id;
        $chat->created_at = time();
        $chat->updated_at = time();
        if (
            $chat->load(
                \Yii::$app->request->post()
            )
            && $chat->validate()
        ) {
            $chat->save();
            \Yii::$app->response->setStatusCode(201);
        } else {
            throw new HttpException(400);
        }
    }

    /**
     * @param string $chatId
     * @throws HttpException
     */
    public function actionDelete(string $chatId)
    {
        $chat = $this->findModel($chatId);
        $chat->deleted_at = time();
        $chat->save();
    }

    /**
     * @throws HttpException
     */
    public function actionSendMessage($chatId)
    {
        $message = new Message();
        $message->chat_id = $chatId;
        $message->user_id = \Yii::$app->user->id;
        $message->created_at = time();
        if (
            $message->load(
                \Yii::$app->request->post()
            )
            && $message->validate()
        ) {
            $message->save();
        } else {
            throw new HttpException(400);
        }
    }

    public function actionDeleteMessage($messageId) {
        $message = Message::findOne([
            'id' => $messageId,
            'user_id' => \Yii::$app->user->id,
        ]);
        $message->deleted_at = time();
        $message->save();
    }

    public function actionEnter($chatId) {
        $link = new ChatUser();
        $link->chat_id = (int)$chatId;
        $link->user_id = \Yii::$app->user->id;
        $link->save();
    }

    public function actionQuit($chatId) {
        ChatUser::deleteAll(
            [
                'chat_id' => $chatId,
                'user_id' => \Yii::$app->user->id,
            ]
        );
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    protected function findModel($id): Chat
    {
        $model = Chat::find()
            ->where(['deleted_at' => null])
            ->andWhere(['id' => (int)$id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }

}
