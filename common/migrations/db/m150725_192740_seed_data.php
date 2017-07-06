<?php

use common\models\User;
use yii\db\Migration;

class m150725_192740_seed_data extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'status' => User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ]);


        $this->insert('{{%user_profile}}', [
            'user_id' => 1,
            'locale' => Yii::$app->sourceLanguage,
            'firstname' => 'admin',
            'lastname' => ''
        ]);


        $this->insert('{{%page}}', [
            'slug' => 'about',
            'title' => 'About',
            'body' => 'How about AKTracking.',
            'status' => \common\models\Page::STATUS_PUBLISHED,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%article_category}}', [
            'id' => 1,
            'slug' => 'news',
            'title' => 'News',
            'status' => \common\models\ArticleCategory::STATUS_ACTIVE,
            'created_at' => time()
        ]);

        $this->insert('{{%widget_menu}}', [
            'key' => 'frontend-index',
            'title' => 'Frontend index menu',
            'items' => json_encode([
                [
                    'label' => 'Get started with AKTracking',
                    'url' => 'http://uzstudio.com/aktracking/get-start',
                    'options' => ['tag' => 'span'],
                    'template' => '<a href="{url}" class="btn btn-lg btn-success">{label}</a>'
                ],
                [
                    'label' => 'AKTracking on GitHub',
                    'url' => 'https://github.com/ankyestudio/aktracking',
                    'options' => ['tag' => 'span'],
                    'template' => '<a href="{url}" class="btn btn-lg btn-primary">{label}</a>'
                ],
                [
                    'label' => 'Find a bug?',
                    'url' => 'https://github.com/ankyestudio/aktracking/issues',
                    'options' => ['tag' => 'span'],
                    'template' => '<a href="{url}" class="btn btn-lg btn-danger">{label}</a>'
                ]

            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'status' => \common\models\WidgetMenu::STATUS_ACTIVE
        ]);

        $this->insert('{{%widget_text}}', [
            'key' => 'backend_welcome',
            'title' => 'Welcome to backend',
            'body' => '<p>Welcome to Admin Dashboard</p>',
            'status' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%widget_text}}', [
            'key' => 'ads-example',
            'title' => 'Google Ads Example Block',
            'body' => '<div class="lead">
                <script>
                //todo
                </script>
            </div>',
            'status' => 0,
            'created_at' => time(),
            'updated_at' => time(),
        ]);



        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.theme-skin',
            'value' => 'skin-blue',
            'comment' => 'skin-blue, skin-black, skin-purple, skin-green, skin-red, skin-yellow,skin-blue, skin-black-light, skin-purple-light, skin-green-light, skin-red-light, skin-yellow-light'
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-fixed',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-boxed',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-collapsed-sidebar',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.maintenance',
            'value' => 'disabled',
            'comment' => 'Set it to "true" to turn on maintenance mode'
        ]);
        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.table-profit-color',
            'value' => 'table-green',
            'comment' => 'Set Profit color table style'
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'app.sitename',
            'value' => 'AKTracking',
            'comment' => 'Set site name'
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'app.timezone',
            'value' => 'UTC',
            'comment' => 'Set Timezone'
        ]);


    }

    public function safeDown()
    {
        $this->delete('{{%key_storage_item}}', [
            'key' => 'frontend.maintenance'
        ]);

        $this->delete('{{%key_storage_item}}', [
            'key' => 'app.timezone'
        ]);

        $this->delete('{{%key_storage_item}}', [
            'key' => 'app.sitename'
        ]);

        $this->delete('{{%key_storage_item}}', [
            'key' => [
                'backend.theme-skin',
                'backend.layout-fixed',
                'backend.layout-boxed',
                'backend.layout-collapsed-sidebar',
            ],
        ]);

        $this->delete('{{%widget_carousel_item}}', [
            'carousel_id' => 1
        ]);

        $this->delete('{{%widget_carousel}}', [
            'id' => 1
        ]);

        $this->delete('{{%widget_text}}', [
            'key' => 'backend_welcome'
        ]);

        $this->delete('{{%widget_menu}}', [
            'key' => 'frontend-index'
        ]);

        $this->delete('{{%article_category}}', [
            'id' => 1
        ]);

        $this->delete('{{%page}}', [
            'slug' => 'about'
        ]);

        $this->delete('{{%user_profile}}', [
            'user_id' => [1]
        ]);

        $this->delete('{{%user}}', [
            'id' => [1]
        ]);
    }
}
