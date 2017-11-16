<?php

namespace Itk\Bundle\EasyAdminUserBundle\Traits;

trait EasyAdminControllerUserManager
{
    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
        if (method_exists($this->get('fos_user.user_manager'), 'notifyUserCreated')) {
            $this->get('fos_user.user_manager')->notifyUserCreated($user, false);
        }
    }

    public function preUpdateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}
