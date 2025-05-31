<?php
namespace app\database;

use app\core\DBManager;

class QueryBuilder extends DBManager{

    protected $db;
    protected string $table;
    protected array $select = ['*'];
    protected array $wheres = [];
    protected array $joins = [];
    protected array $bindings = [];
    protected array $orderBy = [];
    protected ?int $limit = null;
    protected ?int $offset = null;
    
    public function __construct(?string $env = null)
    {
        $this->db = (new DBManager)->connection($env);
    }

    public function table(string $table): self{
        $this->table = $table;
        return $this;
    }

    public function select(array $fields = ['*']): self{
        $this->select = $fields;
        return $this;        
    }

    // ------- JOINS ------- //
    public function join(string $table, string $first, string $operator, string $second, string $type = 'INNER'): self{
        $this->joins[] = strtoupper($type) . " JOIN $table ON $first $operator $second";
        return $this;
    }

    public function leftJoin(string $table, string $first, string $operator, string $second): self{
        return $this->join($table, $first, $operator, $second, 'LEFT');
    }

    public function rightJoin(string $table, string $first, string $operator, string $second): self{
        return $this->join($table, $first, $operator, $second, 'RIGHT');
    }

    // ******** WHERES ******** //

    public function where(callable|string $columns, string $operator = null, string $value = null, string $boolean = 'AND'): self{
        return $this;
    }

}