<?php
namespace app\services\Permissoes;

use app\core\ServiceResponse;
use app\core\Model;
use app\services\acessos\AcessosService;

class PermissoesService extends Model{

    protected string $table = 'permissoes';
    protected array $columns = ['id', 'cargo_id', 'permissao'];

    public function __construct(string | null $env = '')
    {
        $this->name = $env;
    }

    public function fetchPermissoesSemGrupo(){
       $sql = 'SELECT * FROM acessos 
       WHERE grupo_id IS NULL OR grupo_id = 0';
       $query = $this->connection()->query($sql);
       $gruposSemAcesso = $query->fetchAll();

       return ServiceResponse::success('', $gruposSemAcesso);
    }


    public function fetchUsuarioPermissoes(int $id_usuario, int $id_permissao): ServiceResponse
    {
       $sql = 'SELECT * FROM permissoes 
       WHERE cargo_id = :cargo_id AND permissao = :id_permissao';
       $stmt = $this->connection()->prepare($sql);

       $exec = $stmt->execute([
        'cargo_id' => $id_usuario,
        'id_permissao' => $id_permissao
       ]) ;

       $permissoesPorUsuario = $stmt->fetchAll();

       return ServiceResponse::success('', $permissoesPorUsuario);
    }

    public function fetchUsuarioPermissoesByUsuario(int $id_usuario): ServiceResponse
    {
       $sql = 'SELECT * FROM permissoes 
       WHERE cargo_id = :cargo_id ';
       $stmt = $this->connection()->prepare($sql);

       $exec = $stmt->execute([
        'cargo_id' => $id_usuario,
       ]) ;

       $permissoesPorUsuario = $stmt->fetchAll();

       return ServiceResponse::success('', $permissoesPorUsuario);
    }

    public function fetchUsuarioPermissoesByUsuarioWithChave(int $id_usuario): ServiceResponse
    {
       $sql = 'SELECT acessos.nome, acessos.chave, acessos.grupo_id, grupo_acessos.nome as nome_grupo, pagina FROM permissoes 
       LEFT JOIN acessos ON acessos.id = permissoes.permissao
       LEFT JOIN grupo_acessos ON grupo_acessos.id = acessos.grupo_id
       WHERE cargo_id = :cargo_id ';
       $stmt = $this->connection()->prepare($sql);

       $exec = $stmt->execute([
        'cargo_id' => $id_usuario,
       ]) ;

       $permissoesPorUsuario = $stmt->fetchAll();

       return ServiceResponse::success('', $permissoesPorUsuario);
    }


    public function insert($data){
        $sql = "SELECT * FROM {$this->table} WHERE cargo_id =:cargo_id AND permissao = :permissao";
        $stmt = $this->connection()->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetch();

        if($result){
            $deleteSql = "DELETE FROM {$this->table} WHERE cargo_id =:cargo_id AND permissao = :permissao";
            $stmt = $this->connection()->prepare($deleteSql);
            $stmt->execute($data);
            return ServiceResponse::success('Permissão removida com sucesso.', null);
        }

        $this->columns = ['cargo_id', 'permissao'];
        
        $created = $this->create($data);

        return ServiceResponse::success('Permissão inserida com sucesso.', $created); 
    }

    public function insertAllPermissoes($data){

        $sql = "SELECT * FROM {$this->table} WHERE cargo_id =:cargo_id";
        $stmt = $this->connection()->prepare($sql);
        $stmt->execute([
            'cargo_id' => $data
        ]);
        $result = $stmt->fetchAll();

        if($result){
            $deleteSql = "DELETE FROM {$this->table} WHERE cargo_id =:cargo_id";
            $stmt = $this->connection()->prepare($deleteSql);
            $stmt->execute([
                'cargo_id' => $data
            ]);
        }

        $acessos = (new AcessosService())->fetchAll()->toArray();
        $this->columns = ['cargo_id', 'permissao'];

            
        foreach($acessos['data'] as $acesso){
            $created = $this->create([
                'cargo_id' => $data,
                'permissao' => $acesso->id,
            ]);
        }

        return ServiceResponse::success('Permissão inserida com sucesso.', $created); 
    }

}
