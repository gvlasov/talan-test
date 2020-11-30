<?php

namespace api\modules\v1\resources;

use yii\helpers\Url;
use yii\web\Link;
use yii\web\Linkable;

class Chat extends \api\modules\v1\models\Chat
{
    public function fields()
    {
        return ['id', 'title'];
    }

    public function extraFields()
    {
        return [];
    }
}
