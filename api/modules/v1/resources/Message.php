<?php

namespace api\modules\v1\resources;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Message extends \api\modules\v1\models\Message
{
    public function fields()
    {
        return ['id', 'text', 'user_id', 'created_at', 'username'];
    }

    public function extraFields()
    {
        return [];
    }
}
