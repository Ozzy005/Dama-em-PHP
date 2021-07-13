<?php

/**
 *
 * @author Rafael Arend
 *
 **/

class Tabuleiro
{
    private $tabuleiro;
    private $peca_escolhida;
    private $pecas_brancas;
    private $pecas_pretas;

    public function __construct( $peca_escolhida, $pecas_brancas, $pecas_pretas )
    {
        $this->peca_escolhida = $peca_escolhida;
        $this->pecas_brancas = $pecas_brancas;
        $this->pecas_pretas = $pecas_pretas;

        $this->setTabuleiro();
    }

    public function mountTabuleiro()
    {
        if( $this->peca_escolhida === 'cor-preta' )
        {
            $this->selectedColor( $this->pecas_brancas, $this->pecas_pretas );
        }
        if( $this->peca_escolhida === 'cor-branca' )
        {
            $this->selectedColor( $this->pecas_pretas, $this->pecas_brancas );
        }
    }

    public function getTabuleiro()
    {
        return $this->tabuleiro;
    }

    private function selectedColor( $pecas1, $pecas2 )
    {
        $n8 = 4;  //4-3-2-1
        $n7 = 8;  //8-7-6-5
        $n6 = 12; //12-11-10-9

        $n3 = 9;  //9-10-11-12
        $n2 = 5;  //5-6-7-8
        $n1 = 1;  //1-2-3-4

        foreach( $this->tabuleiro as $chave_linha => $valor_linha )
        {
            foreach( $valor_linha as $chave_coluna => $valor_coluna )
            {
                $linha_explode = explode('-',$chave_linha);
                $coluna_explode = explode('-',$chave_coluna);

                settype($linha_explode[1],'integer');

                //organiza as peça do lado de cima do tabuleiro
                if( $linha_explode[1] <= 8 && $linha_explode[1] >= 6 && $coluna_explode[2] === 'preta' )
                {
                    if( $linha_explode[1] === 8 && $n8 <= 4 && $n8 >= 1 )
                    {
                        $this->tabuleiro[$chave_linha][$chave_coluna] = $pecas1[$n8];
                        $n8--;
                    }
                    if( $linha_explode[1] === 7 && $n7 <= 8 && $n7 >= 5 )
                    {
                        $this->tabuleiro[$chave_linha][$chave_coluna] = $pecas1[$n7];
                        $n7--;
                    }
                    if( $linha_explode[1] === 6 && $n6 <= 12 && $n6 >= 9 )
                    {
                        $this->tabuleiro[$chave_linha][$chave_coluna] = $pecas1[$n6];
                        $n6--;
                    }
                }

                //organiza as peças do lado de baixo do tabuleiro
                if( $linha_explode[1] <= 3 && $linha_explode[1] >= 1 && $coluna_explode[2] === 'preta' )
                {
                    if( $linha_explode[1] === 3 && $n3 >= 9 && $n3 <= 12 )
                    {
                        $this->tabuleiro[$chave_linha][$chave_coluna] = $pecas2[$n3];
                        $n3++;
                    }
                    if( $linha_explode[1] === 2 && $n2 >= 5 && $n2 <= 8 )
                    {
                        $this->tabuleiro[$chave_linha][$chave_coluna] = $pecas2[$n2];
                        $n2++;
                    }
                    if( $linha_explode[1] === 1 && $n1 >= 1 && $n1 <= 4 )
                    {
                        $this->tabuleiro[$chave_linha][$chave_coluna] = $pecas2[$n1];
                        $n1++;
                    }
                }
            }
        }
    }

    private function setTabuleiro()
    {
        $this->tabuleiro =
        [
            'linha-8' =>
            [
                'coluna-a-branca' => null,
                'coluna-b-preta' => null,
                'coluna-c-branca' => null,
                'coluna-d-preta' => null,
                'coluna-e-branca' => null,
                'coluna-f-preta' => null,
                'coluna-g-branca' => null,
                'coluna-h-preta' => null
            ],
            'linha-7' =>
            [
                'coluna-a-preta' => null,
                'coluna-b-branca' => null,
                'coluna-c-preta' => null,
                'coluna-d-branca' => null,
                'coluna-e-preta' => null,
                'coluna-f-branca' => null,
                'coluna-g-preta' => null,
                'coluna-h-branca' => null
            ],
            'linha-6' =>
            [
                'coluna-a-branca' => null,
                'coluna-b-preta' => null,
                'coluna-c-branca' => null,
                'coluna-d-preta' => null,
                'coluna-e-branca' => null,
                'coluna-f-preta' => null,
                'coluna-g-branca' => null,
                'coluna-h-preta' => null
            ],
            'linha-5' =>
            [
                'coluna-a-preta' => null,
                'coluna-b-branca' => null,
                'coluna-c-preta' => null,
                'coluna-d-branca' => null,
                'coluna-e-preta' => null,
                'coluna-f-branca' => null,
                'coluna-g-preta' => null,
                'coluna-h-branca' => null
            ],
            'linha-4' =>
            [
                'coluna-a-branca' => null,
                'coluna-b-preta' => null,
                'coluna-c-branca' => null,
                'coluna-d-preta' => null,
                'coluna-e-branca' => null,
                'coluna-f-preta' => null,
                'coluna-g-branca' => null,
                'coluna-h-preta' => null
            ],
            'linha-3' =>
            [
                'coluna-a-preta' => null,
                'coluna-b-branca' => null,
                'coluna-c-preta' => null,
                'coluna-d-branca' => null,
                'coluna-e-preta' => null,
                'coluna-f-branca' => null,
                'coluna-g-preta' => null,
                'coluna-h-branca' => null
            ],
            'linha-2' =>
            [
                'coluna-a-branca' => null,
                'coluna-b-preta' => null,
                'coluna-c-branca' => null,
                'coluna-d-preta' => null,
                'coluna-e-branca' => null,
                'coluna-f-preta' => null,
                'coluna-g-branca' => null,
                'coluna-h-preta' => null
            ],
            'linha-1' =>
            [
                'coluna-a-preta' => null,
                'coluna-b-branca' => null,
                'coluna-c-preta' => null,
                'coluna-d-branca' => null,
                'coluna-e-preta' => null,
                'coluna-f-branca' => null,
                'coluna-g-preta' => null,
                'coluna-h-branca' => null
            ]
        ];
    }
}
?>