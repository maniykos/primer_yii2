<?php

use yii\db\Migration;

/**
 * Class m180207_193817_tbl_add_article_tag
 */
class m180207_193817_tbl_add_article_tag extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%article_tag}}', [
            'id'        	        => $this->primaryKey(),
            'name'  	            => $this->text()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180207_193817_tbl_add_article_tag cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180207_193817_tbl_add_article_tag cannot be reverted.\n";

        return false;
    }
    */
}
