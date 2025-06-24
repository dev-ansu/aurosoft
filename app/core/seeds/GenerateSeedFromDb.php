<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class GenerateSeedFromDb extends AbstractSeed
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
                'nome' => 'Cadastros'
            ],
            [
                'nome' => 'Pessoas'
            ],
            [
                'nome' => 'Financeiro'
            ]
        ];
        $rows = $this->fetchAll('SELECT * FROM grupo_acessos');
        if(count($rows) === 0){
            $this->table('grupo_acessos')->insert($data)->save();
        }
        
        $rows = $this->fetchAll("SELECT * FROM acessos");
        $rows2 = json_decode(json_encode($rows), true);
        // Gerar o conteúdo do seed
        $seedContent = "<?php\n\n";
        $seedContent .= "use Phinx\\Seed\\AbstractSeed;\n\n";
        $seedContent .= "class Acessos extends AbstractSeed\n";
        $seedContent .= "{\n";
        $seedContent .= "    public function run():void\n";
        $seedContent .= "    {\n";
        $seedContent .= "
                    \$data = [
                    [
                        'nome' => 'Cadastros'
                    ],
                    [
                        'nome' => 'Pessoas'
                    ],
                    [
                        'nome' => 'Financeiro'
                    ]
                ];
                \$rows = \$this->fetchAll('SELECT * FROM grupo_acessos');
                if(count(\$rows) === 0){
                    \$this->table('grupo_acessos')->insert(\$data)->save();
                }
        ";
        $seedContent .= "        \$rawData = " . var_export($rows2, true) . ";\n";
        $seedContent .= "\$data = array_map(function (\$item) {
            return array_filter(\$item, function (\$key) {
                return !is_int(\$key);
            }, ARRAY_FILTER_USE_KEY);
        }, \$rawData);\n";
        $seedContent .= "        \$this->table('acessos')->insert(\$data)->save();\n";
        $seedContent .= "    }\n";
        $seedContent .= "}\n";

        // Salvar o arquivo do seed
        file_put_contents('app/core/seeds/Acessos.php', $seedContent);
    }
}
