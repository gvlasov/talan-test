<?php

namespace api\modules\v1\models\definitions;

/**
 * @SWG\Definition(required={"user_id", "chat_id", "text"})
 *
 * @SWG\Property(property="id", type="integer")
 * @SWG\Property(property="user_id", type="integer")
 * @SWG\Property(property="chat_id", type="integer")
 * @SWG\Property(property="text", type="string")
 * @SWG\Property(property="created_at", type="integer")
 * @SWG\Property(property="deleted_at", type="integer")
 *
 * @property int $id
 * @property int $user_id
 * @property int $chat_id
 * @property string $text
 * @property int $created_at
 * @property int|null $deleted_at
 */
class Message
{
    // dummy class for Swagger definitions
}
