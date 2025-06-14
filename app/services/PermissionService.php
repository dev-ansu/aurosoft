<?php

namespace app\services;
use app\facade\App;

class PermissionService{
    
    public static function has(string $permission): bool{
        $user = App::authSession()->get();
         
        if($user->cargo_id == 1){
            return true;
        }

        $permissions = App::authSession()->get()->permissoes;
            

        return in_array($permission, array_column($permissions, 'chave'));
    }

    public static function hasGroupPermission(string $group): bool{
        $groups =  App::authSession()->get()->permissoesPorGrupo;
        
        $user = App::authSession()->get();

        if($user->cargo_id == 1){
            return true;
        }
            
        return array_key_exists($group, $groups);
    }

    public static function hasGroupPermissionAndPermission(string $group, string $permission): bool{
        return self::hasGroupPermission($group) && self::has($permission);
    }

}