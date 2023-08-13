<?php

use yii\db\Migration;

/**
 * Class m230812_170242_create_tables
 */
class m230812_170242_create_tables extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $tableName = $this->db->tablePrefix . 'product';
        if ($this->db->getTableSchema($tableName, true) !== null) {
            $this->dropTable($tableName);
        }

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'image' => $this->string()->null()->comment("Ссылка на изображение"),
            'is_deleted' => $this->boolean()->null(),
        ], $tableOptions);


        $tableName = $this->db->tablePrefix . 'store_product';
        if ($this->db->getTableSchema($tableName, true) !== null) {
            $this->dropTable($tableName);
        }

        $this->createTable('{{%store_product}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->null(),
            'product_image' => $this->string()->null()->comment("Ссылка на изображение"),
        ], $tableOptions);

        $this->addForeignKey(
            'fk-product_id',
            'store_product',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-product_id',
            'store_product'
        );

        $this->dropTable('{{%product}}');
        $this->dropTable('{{%store_product}}');
    }
}
