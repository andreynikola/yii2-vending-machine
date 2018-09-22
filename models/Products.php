<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\Response;
use yii\web\HttpException;
use yii\web\Session;
use app\models\Balance;

class Products extends ActiveRecord
{
    public function getAll(){
        $products = Products::find()->asArray()->all();
        return $products;
    }

    public function buy($id){
        $session = Yii::$app->session;
        $product = Products::find()->where(['id' => $id])->one();

        if ($product['count'] < 1){
            return json_encode([
                'status' => 'error',
                'text' => 'Не достаточно товара'
            ],JSON_UNESCAPED_UNICODE);
        }

        $subtraction = $session->get('deposit') - $product['price'];
        if ($subtraction < 0){
            return json_encode([
                'status' => 'error',
                'text' => 'Не достаточно денег'
            ],JSON_UNESCAPED_UNICODE);
        }

        $session->set('deposit', $session->get('deposit') - $product['price']);

        $product['count'] -= 1;
        $product->save();

        return json_encode([
            'status' => 'sucess',
            'text' => 'Поздравляем! Вы купили '.$product['name']
        ],JSON_UNESCAPED_UNICODE);
        
    }

}
