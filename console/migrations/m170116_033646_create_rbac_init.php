<?php

use yii\db\Migration;

class m170116_033646_create_rbac_init extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        // $manageArticles = $auth->createPermission('manageArticles');
        // $manageArticles->description = 'Manage articles';
        // $auth->add($manageArticles);

        // $manageUsers = $auth->createPermission('manageUsers');
        // $manageUsers->description = 'Manage users';
        // $auth->add($manageUsers);

        $customer = $auth->createRole('customer');
        $customer->description = 'Customer';
        $auth->add($customer);

        $staff = $auth->createRole('staff');
        $staff->description = 'Staff';
        $auth->add($Staff);
        // $auth->addChild($moderator, $manageArticles);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $auth->add($admin);
        // $auth->addChild($moderator, $manageArticles);

        $developer = $auth->createRole('developer');
        $developer->description = 'Developer';
        $auth->add($developer);
        // $auth->addChild($admin, $moderator);
        // $auth->addChild($admin, $manageUsers);
    }

    public function down()
    {
        Yii::$app->authManager->removeAll();
        // echo "m170109_015349_rbac_init cannot be reverted.\n";

        // return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
