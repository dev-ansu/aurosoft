<?php

use Phinx\Seed\AbstractSeed;

class Acessos extends AbstractSeed
{
    public function run():void
    {
        $rawData = array (
  0 => 
  array (
    'id' => 1,
    0 => 1,
    'nome' => 'Acessar o sistema (página dashboard)',
    1 => 'Acessar o sistema (página dashboard)',
    'chave' => 'dashboard',
    2 => 'dashboard',
    'grupo_id' => NULL,
    3 => NULL,
    'pagina' => 'Sim',
    4 => 'Sim',
  ),
  1 => 
  array (
    'id' => 2,
    0 => 2,
    'nome' => 'Configurações',
    1 => 'Configurações',
    'chave' => 'configuracoes',
    2 => 'configuracoes',
    'grupo_id' => NULL,
    3 => NULL,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  2 => 
  array (
    'id' => 3,
    0 => 3,
    'nome' => 'Permite ver o perfil',
    1 => 'Permite ver o perfil',
    'chave' => 'perfil',
    2 => 'perfil',
    'grupo_id' => NULL,
    3 => NULL,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  3 => 
  array (
    'id' => 4,
    0 => 4,
    'nome' => 'Permite acessar a página de usuários',
    1 => 'Permite acessar a página de usuários',
    'chave' => 'dashboard/usuarios',
    2 => 'dashboard/usuarios',
    'grupo_id' => 2,
    3 => 2,
    'pagina' => 'Sim',
    4 => 'Sim',
  ),
  4 => 
  array (
    'id' => 5,
    0 => 5,
    'nome' => 'Permite listar os usuários na página de usuários',
    1 => 'Permite listar os usuários na página de usuários',
    'chave' => 'api/usuarios',
    2 => 'api/usuarios',
    'grupo_id' => 2,
    3 => 2,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  5 => 
  array (
    'id' => 6,
    0 => 6,
    'nome' => 'Permite listar a página de grupos de acesso',
    1 => 'Permite listar a página de grupos de acesso',
    'chave' => 'dashboard/grupoacessos',
    2 => 'dashboard/grupoacessos',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Sim',
    4 => 'Sim',
  ),
  6 => 
  array (
    'id' => 7,
    0 => 7,
    'nome' => 'Permite listar os grupos de acesso',
    1 => 'Permite listar os grupos de acesso',
    'chave' => 'api/grupoacessos',
    2 => 'api/grupoacessos',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  7 => 
  array (
    'id' => 8,
    0 => 8,
    'nome' => 'Permite acessar a página de acessos',
    1 => 'Permite acessar a página de acessos',
    'chave' => 'dashboard/acessos',
    2 => 'dashboard/acessos',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Sim',
    4 => 'Sim',
  ),
  8 => 
  array (
    'id' => 9,
    0 => 9,
    'nome' => 'Permite listar os acessos',
    1 => 'Permite listar os acessos',
    'chave' => 'api/acessos',
    2 => 'api/acessos',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  9 => 
  array (
    'id' => 10,
    0 => 10,
    'nome' => 'Permite acessar a página de formas de pagamento',
    1 => 'Permite acessar a página de formas de pagamento',
    'chave' => 'dashboard/formaspagamento',
    2 => 'dashboard/formaspagamento',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Sim',
    4 => 'Sim',
  ),
  10 => 
  array (
    'id' => 11,
    0 => 11,
    'nome' => 'Permite listar as formas de pagamento',
    1 => 'Permite listar as formas de pagamento',
    'chave' => 'api/formaspagamento',
    2 => 'api/formaspagamento',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  11 => 
  array (
    'id' => 12,
    0 => 12,
    'nome' => 'Permite acessar a página de frequências',
    1 => 'Permite acessar a página de frequências',
    'chave' => 'dashboard/frequencias',
    2 => 'dashboard/frequencias',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Sim',
    4 => 'Sim',
  ),
  12 => 
  array (
    'id' => 13,
    0 => 13,
    'nome' => 'Permite listar as frequências',
    1 => 'Permite listar as frequências',
    'chave' => 'api/frequencias',
    2 => 'api/frequencias',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  13 => 
  array (
    'id' => 14,
    0 => 14,
    'nome' => 'Permite acessar a página de contas a receber',
    1 => 'Permite acessar a página de contas a receber',
    'chave' => 'dashboard/contasareceber',
    2 => 'dashboard/contasareceber',
    'grupo_id' => 3,
    3 => 3,
    'pagina' => 'Sim',
    4 => 'Sim',
  ),
  14 => 
  array (
    'id' => 15,
    0 => 15,
    'nome' => 'Permite listar as contas a receber',
    1 => 'Permite listar as contas a receber',
    'chave' => 'api/contasareceber',
    2 => 'api/contasareceber',
    'grupo_id' => 3,
    3 => 3,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  15 => 
  array (
    'id' => 16,
    0 => 16,
    'nome' => 'Permite acessar a página de contas a pagar',
    1 => 'Permite acessar a página de contas a pagar',
    'chave' => 'dashboard/contasapagar',
    2 => 'dashboard/contasapagar',
    'grupo_id' => 3,
    3 => 3,
    'pagina' => 'Sim',
    4 => 'Sim',
  ),
  16 => 
  array (
    'id' => 17,
    0 => 17,
    'nome' => 'Permite listar as contas a pagar',
    1 => 'Permite listar as contas a pagar',
    'chave' => 'api/contasapagar',
    2 => 'api/contasapagar',
    'grupo_id' => 3,
    3 => 3,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  17 => 
  array (
    'id' => 18,
    0 => 18,
    'nome' => 'Permite acessar a página de cargos',
    1 => 'Permite acessar a página de cargos',
    'chave' => 'dashboard/cargos',
    2 => 'dashboard/cargos',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Sim',
    4 => 'Sim',
  ),
  18 => 
  array (
    'id' => 19,
    0 => 19,
    'nome' => 'Permite listar os cargos',
    1 => 'Permite listar os cargos',
    'chave' => 'api/cargos',
    2 => 'api/cargos',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  19 => 
  array (
    'id' => 20,
    0 => 20,
    'nome' => 'Permite cadastrar um novo cargo',
    1 => 'Permite cadastrar um novo cargo',
    'chave' => 'api/cargos/insert',
    2 => 'api/cargos/insert',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  20 => 
  array (
    'id' => 21,
    0 => 21,
    'nome' => 'Permite editar o cargo',
    1 => 'Permite editar o cargo',
    'chave' => 'api/cargos/patch',
    2 => 'api/cargos/patch',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  21 => 
  array (
    'id' => 22,
    0 => 22,
    'nome' => 'Permite excluir um cargo',
    1 => 'Permite excluir um cargo',
    'chave' => 'api/cargos/delete',
    2 => 'api/cargos/delete',
    'grupo_id' => 1,
    3 => 1,
    'pagina' => 'Não',
    4 => 'Não',
  ),
  22 => 
  array (
    'id' => 23,
    0 => 23,
    'nome' => 'Permite editar o perfil',
    1 => 'Permite editar o perfil',
    'chave' => 'api/perfil',
    2 => 'api/perfil',
    'grupo_id' => NULL,
    3 => NULL,
    'pagina' => 'Não',
    4 => 'Não',
  ),
);
$data = array_map(function ($item) {
            return array_filter($item, function ($key) {
                return !is_int($key);
            }, ARRAY_FILTER_USE_KEY);
        }, $rawData);
        $this->table('acessos')->insert($data)->save();
    }
}
