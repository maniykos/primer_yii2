<?php

use yii\db\Migration;

/**
 * Class m180207_193938_tbl_add_article_article_tag
 */
class m180207_193938_tbl_add_article_article_tag extends Migration
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


        $this->createTable('article_article_tag', [
            'article_id' => $this->integer(),
            'article_tag_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'PRIMARY KEY(article_id, article_tag_id)',
        ]);


        $this->createIndex('idx_article_article_id', '{{%article_article_tag}}', 'article_id');
        $this->createIndex('idx_article_article_tag_id', '{{%article_article_tag}}', 'article_tag_id');

        $this->addForeignKey('fk_article_article_tag_article', '{{%article_article_tag}}', 'article_id', '{{%article}}', 'id','CASCADE');
        $this->addForeignKey('fk_article_article_tag_article_tag', '{{%article_article_tag}}', 'article_tag_id', '{{%article_tag}}', 'id','CASCADE');


    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_article_article_tag_article', '{{%article_article_tag}}');
        $this->dropForeignKey('fk_article_article_tag_article_tag', '{{%article_article_tag}}');
        $this->dropTable('{{%article_article_tag}}');

        echo "m180207_193938_tbl_add_article_article_tag cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180207_193938_tbl_add_article_article_tag cannot be reverted.\n";

        return false;
    }
    */
}
