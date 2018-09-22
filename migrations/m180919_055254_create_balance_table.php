<?php

use yii\db\Migration;

/**
 * Handles the creation of table `balance`.
 */
class m180919_055254_create_balance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('balance', [
            'id' => $this->primaryKey()->unique(),
            'name' => $this->string(255)->unique(),
            'one' => $this->integer(),
            'two' => $this->integer(),
            'five' => $this->integer(),
            'ten' => $this->integer()
        ],$tableOptions);

        Yii::$app->db->createCommand()->batchInsert('balance', ['name','one','two','five','ten'],[
            ['user', 10, 30, 20, 15],
            ['vm', 100, 100, 100, 100]
            /*['deposit', 0, 0, 0, 0]*/
        ])->execute();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('balance');
    }
}
