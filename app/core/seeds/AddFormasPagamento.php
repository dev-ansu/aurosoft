<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AddFormasPagamento extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'nome' => 'Dinheiro',
            ],
            [
                'nome' => 'Pix'
            ],
            [
                'nome' => 'Cartão de crédito'
            ],
            [
                'nome' => 'Cartão de débito'
            ],
            [
                'nome' => 'Carnê'
            ],
            [
                'nome' => 'Boleto'
            ]
        ];

        $formasPagamento = $this->table("formas_pagamento");
        $sql = "SELECT * FROM formas_pagamento";        
        $rows = $this->fetchAll($sql);
        
        if(count($rows) == 0){
            $formasPagamento->insert($data)->save();
        }
        
    }
}
