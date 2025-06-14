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
      'description' => NULL,
      'key' => 'dashboard',
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
      'description' => NULL,
      'key' => 'dashboard/usuarios',
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
      'description' => NULL,
      'key' => 'dashboard/grupoacessos',
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
      'description' => NULL,
      'key' => 'dashboard/acessos',
    ),
    '/dashboard/formaspagamento' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\dashboard\\FormasPagamentoController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'dashboard/formaspagamento',
    ),
    '/dashboard/frequencias' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\dashboard\\FrequenciasController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'dashboard/frequencias',
    ),
    '/dashboard/contasareceber' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\dashboard\\ContasReceberController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'dashboard/contasareceber',
    ),
    '/dashboard/contasapagar' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\dashboard\\ContasPagarController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'dashboard/contasapagar',
    ),
    '/dashboard/cargos' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\dashboard\\CargosController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'dashboard/cargos',
    ),
    '/dashboard/funcionarios' => 
    array (
      'action' => 
      array (
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'dashboard/funcionarios',
    ),
    '/dashboard/fornecedores' => 
    array (
      'action' => 
      array (
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'dashboard/fornecedores',
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
      'description' => 'Página de login do Aurosoft.',
      'key' => '',
    ),
    '/teste' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\TesteController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
      ),
      'description' => NULL,
      'key' => 'teste',
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
      'description' => 'Realiza o logout do usuário no Aurosoft.',
      'key' => 'logout',
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
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/usuarios',
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
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/usuarios/delete/{id:\\d+}',
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
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/usuarios/activate/{id:\\d+}',
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
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/usuarios/deactivate/{id:\\d+}',
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
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/grupoacessos',
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
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/grupoacessos/delete/{id:\\d+}',
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
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/acessos',
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
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/acessos/delete/{id:\\d+}',
    ),
    '/api/formaspagamento' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\FormasPagamentoController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/formaspagamento',
    ),
    '/api/formaspagamento/delete/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\FormasPagamentoController',
        1 => 'delete',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/formaspagamento/delete/{id:\\d+}',
    ),
    '/api/formaspagamento/select/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\FormasPagamentoController',
        1 => 'select',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/formaspagamento/select/{id:\\d+}',
    ),
    '/api/frequencias' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\FrequenciasController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/frequencias',
    ),
    '/api/frequencias/delete/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\FrequenciasController',
        1 => 'delete',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/frequencias/delete/{id:\\d+}',
    ),
    '/api/contasreceber' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasReceberController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasreceber',
    ),
    '/api/contasreceber/delete/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasReceberController',
        1 => 'delete',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasreceber/delete/{id:\\d+}',
    ),
    '/api/contasapagar' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasPagarController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasapagar',
    ),
    '/api/contasapagar/delete/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasPagarController',
        1 => 'delete',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasapagar/delete/{id:\\d+}',
    ),
    '/api/cargos' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\CargosController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/cargos',
    ),
    '/api/cargos/delete/{id:\\d+}' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\CargosController',
        1 => 'delete',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/cargos/delete/{id:\\d+}',
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
      'description' => 'Realiza a autenticação do usuário no Aurosoft.',
      'key' => 'login',
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
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/usuarios/insert',
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
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/usuarios/patch',
    ),
    '/api/perfil' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\PerfilController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/perfil',
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
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/config',
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
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/grupoacessos/insert',
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
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/grupoacessos/patch',
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
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/acessos/insert',
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
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/acessos/patch',
    ),
    '/api/formaspagamento/patch' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\FormasPagamentoController',
        1 => 'patch',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/formaspagamento/patch',
    ),
    '/api/formaspagamento/insert' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\FormasPagamentoController',
        1 => 'insert',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/formaspagamento/insert',
    ),
    '/api/frequencias/patch' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\FrequenciasController',
        1 => 'patch',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/frequencias/patch',
    ),
    '/api/frequencias/insert' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\FrequenciasController',
        1 => 'insert',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/frequencias/insert',
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
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/permissoes',
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
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/permissoes/insert',
    ),
    '/api/contasreceber/insert' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasReceberController',
        1 => 'insert',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasreceber/insert',
    ),
    '/api/contasreceber/patch' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasReceberController',
        1 => 'patch',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasreceber/patch',
    ),
    '/api/contasreceber/baixar' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasReceberController',
        1 => 'baixar',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasreceber/baixar',
    ),
    '/api/contasreceber/parcelar' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasReceberController',
        1 => 'parcelar',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasreceber/parcelar',
    ),
    '/api/contasapagar/insert' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasPagarController',
        1 => 'insert',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasapagar/insert',
    ),
    '/api/contasapagar/patch' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasPagarController',
        1 => 'patch',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasapagar/patch',
    ),
    '/api/contasapagar/baixar' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasPagarController',
        1 => 'baixar',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasapagar/baixar',
    ),
    '/api/contasapagar/parcelar' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\ContasPagarController',
        1 => 'parcelar',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
        2 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/contasapagar/parcelar',
    ),
    '/api/cargos/insert' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\CargosController',
        1 => 'insert',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\AuthMiddleware',
        1 => 'app\\middlewares\\RoleMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/cargos/insert',
    ),
    '/api/recuperarsenha' => 
    array (
      'action' => 
      array (
        0 => 'app\\controllers\\api\\RecuperarSenhaController',
        1 => 'index',
      ),
      'middlewares' => 
      array (
        0 => 'app\\middlewares\\CSRFMiddleware',
      ),
      'description' => NULL,
      'key' => 'api/recuperarsenha',
    ),
  ),
);