<?php

namespace tests\api\functional;

use api\modules\v1\models\Chat;
use common\models\User;
use tests\api\functional\base\ApiCest;
use tests\api\FunctionalTester;

class MessageCest extends ApiCest
{
    // tests
    public function testCreateMessage(FunctionalTester $I)
    {
        throw new \Error(
            User::findOne([])->access_token
        );
        $I->sendAjaxPostRequest('/v1/message', [
            'text' => 'Marocco',
            'chatId' => $chat->id,
            ''
        ]);
        $I->see('Lorem ipsum');
    }

    public function testArticleView(FunctionalTester $I)
    {
        $I->amOnPage(['/v1/article', 'slug' => 'test-article-1']);
        $I->see('Lorem ipsum');
    }
}
