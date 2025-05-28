<?php

use yii\db\Migration;

class m250528_134534_create_link_and_visit_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%link}}', [
            'id' => $this->primaryKey(),
            'original_url' => $this->text()->notNull(),
            'short_code' => $this->string(6)->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'visit_count' => $this->integer()->notNull()->defaultValue(0),
        ]);

        $this->createTable('{{%visit}}', [
            'id' => $this->primaryKey(),
            'link_id' => $this->integer()->notNull(),
            'ip_address' => $this->string(45)->notNull(),
            'accessed_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-link-short_code', '{{%link}}', 'short_code');
        $this->createIndex('idx-visit-link_id', '{{%visit}}', 'link_id');

        $this->addForeignKey(
            'fk_visit_link',
            '{{%visit}}',
            'link_id',
            '{{%link}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_visit_link', '{{%visit}}');
        $this->dropTable('{{%visit}}');
        $this->dropTable('{{%link}}');
    }
}