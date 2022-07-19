<?php

namespace common\tests\models;

use common\fixtures\UserFixture;
use common\models\User;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    // tests

    public function testValidateReturnsTrueIfParametersAreSet()
    {
        $configurationParams = [
            'username' => 'a valid username',
            'password' => 'a valid password',
            'auth_key' => 'a valid auth key'
        ];

        $user = new User($configurationParams);
        $this->assertTrue($user->validate(), 'User with set parameters should validate');
    }

    public function testFindIdentityByAccessTokenReturnsTheExpectedObject()
    {
        $this->expectException(NotSupportedException::class);

        User::findIdentityByAccessToken('any token');
    }

    public function testGetIdReturnsTheExpectedId()
    {
        $user = new User();
        $user->id = 2;

        $this->assertEquals(2, $user->getId());
    }

    public function testGetAuthKeyReturnsTheExpectedAuthKey()
    {
        $user = new User();
        $user->auth_key = 'some authkey';

        $this->assertEquals('some authkey', $user->getAuthKey());
    }

    public function testFindIdentityReturnsTheExpectedObject()
    {
        /** @var User $expectedAttrs */
        $expectedAttrs = $this->tester->grabFixture('user', 'user1');

        /** @var User $user */
        $user = User::findIdentity($expectedAttrs->id);

        $this->assertNotNull($user);
        $this->assertInstanceOf(IdentityInterface::class, $user);
        $this->assertEquals($expectedAttrs->username, $user->username);
        $this->assertEquals($expectedAttrs->password_hash, $user->password_hash);
        $this->assertEquals($expectedAttrs->auth_key, $user->auth_key);
        $this->assertEquals($expectedAttrs->email, $user->email);
        $this->assertEquals($expectedAttrs->status, $user->status);
    }

    /**
     * @dataProvider nonExistingIdsDataProvider
     */
    public function testFindIdentityReturnsNullIfUserIsNotFound($invalidId)
    {
        $this->assertNull(User::findIdentity($invalidId));
    }

    public function nonExistingIdsDataProvider()
    {
        return [[-1], [null], [30]];
    }

    public function testFindByUsernameReturnsTheExpectedObject()
    {
        /** @var User $expectedAttrs */
        $expectedAttrs = $this->tester->grabFixture('user', 'user1');

        /** @var User $user */
        $user = User::findByUsername($expectedAttrs->username);

        $this->assertNotNull($user);
        $this->assertInstanceOf(IdentityInterface::class, $user);
        $this->assertEquals($expectedAttrs->username, $user->username);
        $this->assertEquals($expectedAttrs->password_hash, $user->password_hash);
        $this->assertEquals($expectedAttrs->auth_key, $user->auth_key);
        $this->assertEquals($expectedAttrs->email, $user->email);
        $this->assertEquals($expectedAttrs->status, $user->status);
    }
}
