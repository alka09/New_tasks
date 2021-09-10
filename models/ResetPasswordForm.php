<?php

namespace app\models;

use http\Exception\InvalidArgumentException;
use yii\base\InvalidParamException;
use yii\base\Model;

/**
 * Class ResetPasswordForm
 * @package app\models
 */

class ResetPasswordForm extends  Model
{
    public $password;

    /**
     * @var \app\models\User
     */
    private $user;

    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties

     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new \InvalidArgumentException('Password reset token cannot be blank');
        }

        $this->_user = User::findByPasswordResetToken($token);

        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Reset password.
     *
     * @return bool if password was reset
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
    }

}