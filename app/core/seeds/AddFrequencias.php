<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class AddFrequencias extends AbstractSeed
{
    
    public function run(): void
    {
        $data = [
            [
                'frequencia' => 'Diária',
                'dias' => 1,
            ],
            [
                'frequencia' => 'Semanal',
                'dias' => 7,
            ],
            [
                'frequencia' => 'Quinzenal',
                'dias' => 15,
            ],
            [
                'frequencia' => 'Mensal',
                'dias' => 30,
            ],
            [
                'frequencia' => 'Bimestral',
                'dias' => 60,
            ],
            [
                'frequencia' => 'Semestral',
                'dias' => 180,
            ]
        ];

        $formasPagamento = $this->table("frequencias");
        $sql = "SELECT * FROM frequencias";        
        $rows = $this->fetchAll($sql);
        
        if(count($rows) == 0){
            $formasPagamento->insert($data)->save();
        }
    }
}
