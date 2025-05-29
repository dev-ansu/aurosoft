<?php return array (
  'GET' => 
  array (
    '/dashboard' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\dashboard\\HomeController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
    ),
    '/dashboard/usuarios' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\dashboard\\UsuariosController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
    ),
    '/dashboard/grupoacessos' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\dashboard\\GrupoAcessosController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
    ),
    '/dashboard/acessos' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\dashboard\\AcessosController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
    ),
    '/' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\HomeController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
      ),
    ),
    '/logout' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\LoginController',
        1 => 'logout',
      ),
      'middlewares' => 
      array (
      ),
    ),
    '/api/usuarios' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\UsuariosController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
      ),
    ),
    '/api/usuarios/delete/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\UsuariosController',
        1 => 'delete',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
      ),
    ),
    '/api/usuarios/activate/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\UsuariosController',
        1 => 'activate',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
      ),
    ),
    '/api/usuarios/deactivate/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\UsuariosController',
        1 => 'deactivate',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
      ),
    ),
    '/api/usuarios/insert' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\UsuariosController',
        1 => 'insert',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
    '/api/usuarios/patch' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\UsuariosController',
        1 => 'patch',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
    '/api/config' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ConfigController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
      ),
    ),
    '/api/grupoacessos' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\GrupoAcessosController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
      ),
    ),
    '/api/grupoacessos/insert' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\GrupoAcessosController',
        1 => 'insert',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
    '/api/grupoacessos/patch' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\GrupoAcessosController',
        1 => 'patch',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
    '/api/grupoacessos/delete/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\GrupoAcessosController',
        1 => 'delete',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
      ),
    ),
    '/api/acessos' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\AcessosController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
      ),
    ),
    '/api/acessos/delete/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\AcessosController',
        1 => 'delete',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
    '/api/acessos/insert' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\AcessosController',
        1 => 'insert',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
    '/api/acessos/patch' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\AcessosController',
        1 => 'patch',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
    '/api/permissoes' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\PermissoesController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
    '/api/permissoes/insert' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\PermissoesController',
        1 => 'insert',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
    '/api/permissoes/insertAll' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\PermissoesController',
        1 => 'insertAll',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
  ),
  'POST' => 
  array (
    '/login' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\LoginController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\CSRFMiddleware',
      ),
    ),
  ),
);