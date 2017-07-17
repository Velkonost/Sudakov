<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;

class RbacController extends Controller
{
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        if (!$auth->getRole('superadmin')) {
            $role = $auth->createRole('superadmin');
            $auth->add($role);
        }
        if (!$auth->getRole('admin')) {
            $role = $auth->createRole('admin');
            $auth->add($role);
        }
        if (!$auth->getRole('worker')) {
            $role = $auth->createRole('worker');
            $auth->add($role);
        }
        echo "done\n";
    }

    public function actionCreate($roleName)
    {
        $auth = Yii::$app->authManager;
        if (!$auth->getRole($roleName)) {
            $role = $auth->createRole($roleName);
            $auth->add($role);
        }
        echo "done\n";
    }

    // assign user with role
    public function actionAssign($userName, $roleName)
    {
        $user = User::findOne(['username' => $userName]);
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if ($role && $user) {
            $auth->assign($role, $user->getId());
            echo "Succeed\n";
        } else {
            echo "not found " . (!$role ? 'Role('.$roleName.')' : '') . ' ' . (!$user ? 'User('.$userName.')' : '');
        }
    }

    // just for demo
    public function actionDemoCode()
    {
        $auth = Yii::$app->authManager;
        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // add "author" role and give this role the "createPost" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($author, 2);
        $auth->assign($admin, 1);
    }
}