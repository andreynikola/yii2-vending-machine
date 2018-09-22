<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\Response;
use yii\web\HttpException;
use yii\web\Session;

class Balance extends ActiveRecord
{

    private $user;
    private $vm;
    private $deposit;

    public $currency = [
        'one' => 1,
        'two' => 2,
        'five' => 5,
        'ten' => 10,
    ];

    public  function getMain()
    {
        $balance = Balance::find()->asArray()->all();
        return $balance;
    }

    public function contributeMoney($amount){

        $session = Yii::$app->session;
        $session->set('deposit', $session->get('deposit') + $this->currency[$amount]);

        $this->user = Balance::find()->where(['name' => 'user'])->one();
        $this->vm = Balance::find()->where(['name' => 'vm'])->one();

        if ($this->user[$amount] < 1){
            return json_encode([
                'status' => 'error',
                'text' => 'Недостаточно денег'
            ],JSON_UNESCAPED_UNICODE);
        }

        $this->user[$amount] -= 1;
        $this->vm[$amount] += 1;

        $this->user->save();
        $this->vm->save();

        return json_encode([
            'status' => 'success',
            'text' => 'Операция успешно выполнена'
        ],JSON_UNESCAPED_UNICODE);

    }

    public function returnMoney(){

        $session = Yii::$app->session;

        $this->deposit = Balance::find()->where(['name' => 'deposit'])->one();
        $this->user = Balance::find()->where(['name' => 'user'])->one();
        $this->vm = Balance::find()->where(['name' => 'vm'])->one();

        $amount = $session->get('deposit');

        while ($amount > 0){
            if ( $amount >= 10 ){
                $this->vm['ten'] -= 1;
                $this->user['ten'] += 1;
                $amount = $amount - 10;
            }
            elseif ( $amount >= 5 ){
                $this->vm['five'] -= 1;
                $this->user['five'] += 1;
                $amount = $amount - 5;
            }
            elseif ( $amount >= 2 ){
                $this->vm['two'] -= 1;
                $this->user['two'] += 1;
                $amount = $amount - 2;
            }
            elseif ( $amount >= 1 ){
                $this->vm['one'] -= 1;
                $this->user['one'] += 1;
                $amount = $amount - 1;
            }
        }

        $session->set('deposit', 0);

        $this->user->save();
        $this->vm->save();

    }

}
