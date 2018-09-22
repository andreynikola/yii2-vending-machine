<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products`.
 */
class m180922_093201_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('products', [
            'id' => $this->primaryKey()->unique(),
            'name' => $this->string(255)->unique(),
            'price' => $this->integer(),
            'count' => $this->integer()
        ],$tableOptions);

        Yii::$app->db->createCommand()->batchInsert('products', ['name','price','count'],[
            ['Чай', 13, 10],
            ['Кофе', 18, 20],
            ['Кофе с молоком', 21, 20],
            ['Сок', 35, 15],
        ])->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('products');
    }
}
