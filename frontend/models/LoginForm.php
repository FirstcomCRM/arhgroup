<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Customer;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $ic;
    public $password;
    public $rememberMe = true;

    private $_customer;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // ic and password are both required
            [['ic', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect ic or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided ic and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[ic]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_customer === null) {
            $this->_customer = User::findByUsername($this->ic);
        }

        return $this->_customer;
    }

    public function getCustomerInfo($ic,$password)
    {
        $result = Customer::find()->where(['nric' => $ic])->orWhere(['uen_no' => $ic])->andWhere(['password' => $password])->one();

        return $result;
    }
}
