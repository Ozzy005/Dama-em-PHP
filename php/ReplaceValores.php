<?php

/**
 *
 * @author Rafael Arend
 *
 **/

function ReplaceValores($tabuleiro,$msgerror,$ultimoMovimento,$contadorTurno,$pecaEscolhida)
{
    if($ultimoMovimento === null)
    {
        $jogadorControle = 'Jogador 1';
    }
    elseif($ultimoMovimento === 'preta')
    {
        $jogadorControle = 'Jogador 1';
    }
    else
    {
        $jogadorControle = 'Jogador 2';
    }

    if($pecaEscolhida === 'brancas')
    {
        if($jogadorControle === 'Jogador 2')
        {
            $div = "<div class='jogador-atual jogador-superior'>";
        }
        else
        {
            $div = "<div class='jogador-superior'>";
        }

        $jogadorSuperior = $div;
        $jogadorSuperior .= "<span>J</span>
                            <span>O</span>
                            <span>G</span>
                            <span>A</span>
                            <span>D</span>
                            <span>O</span>
                            <span>R</span>
                            <span>2</span>
                            </div>";

        if($jogadorControle === 'Jogador 1')
        {
            $div = "<div class='jogador-atual jogador-inferior'>";
        }
        else
        {
            $div = "<div class='jogador-inferior'>";
        }

        $jogadorInferior = $div;
        $jogadorInferior .= "<span>J</span>
                            <span>O</span>
                            <span>G</span>
                            <span>A</span>
                            <span>D</span>
                            <span>O</span>
                            <span>R</span>
                            <span>1</span>
                            </div>";
    }
    else
    {
        if($jogadorControle === 'Jogador 1')
        {
            $div = "<div class='jogador-atual jogador-superior'>";
        }
        else
        {
            $div = "<div class='jogador-superior'>";
        }

        $jogadorSuperior = $div;

        $jogadorSuperior .= "<span>J</span>
                            <span>O</span>
                            <span>G</span>
                            <span>A</span>
                            <span>D</span>
                            <span>O</span>
                            <span>R</span>
                            <span>1</span>
                            </div>";

                            
        if($jogadorControle === 'Jogador 2')
        {
            $div = "<div class='jogador-atual jogador-inferior'>";
        }
        else
        {
            $div = "<div class='jogador-inferior'>";
        }

        $jogadorInferior = $div;

        $jogadorInferior .= "<span>J</span>
                            <span>O</span>
                            <span>G</span>
                            <span>A</span>
                            <span>D</span>
                            <span>O</span>
                            <span>R</span>
                            <span>2</span>
                            </div>";
    }



    $replace = Replace();
    $pagina = file_get_contents('html/dama.html');
    $valores = [$msgerror,$contadorTurno,$jogadorControle];

    foreach($tabuleiro as $keyLine => $valueLine)
    {
        foreach($valueLine as $keyCasa => $valueCasa)
        {
            $casaKeyParts = explode("-",$keyCasa);
            $casaValueParts = explode("-",$valueCasa);

            $tag = "<div type='text' class='{$casaKeyParts[0]} {$casaKeyParts[0]}-{$casaKeyParts[2]}' id='$keyCasa'>";

            if($valueCasa !== null)
            {
                $tag .= "<div class='peca {$casaValueParts[0]}-{$casaValueParts[1]}' id='$valueCasa'></div>";
            }

            $tag .= "</div>";

            $valores[] = $tag;
        }
    }

    $valores[] = $jogadorSuperior;
    $valores[] = $jogadorInferior;

    $pagina = str_replace($replace,$valores,$pagina);
    return $pagina;
}

function Replace()
{
    return
    [
        '{msgerror}',
        '{turno}',
        '{jogador-controle}',
        '{line1-casaA}',
        '{line1-casaB}',
        '{line1-casaC}',
        '{line1-casaD}',
        '{line1-casaE}',
        '{line1-casaF}',
        '{line1-casaG}',
        '{line1-casaH}',
        '{line2-casaA}',
        '{line2-casaB}',
        '{line2-casaC}',
        '{line2-casaD}',
        '{line2-casaE}',
        '{line2-casaF}',
        '{line2-casaG}',
        '{line2-casaH}',
        '{line3-casaA}',
        '{line3-casaB}',
        '{line3-casaC}',
        '{line3-casaD}',
        '{line3-casaE}',
        '{line3-casaF}',
        '{line3-casaG}',
        '{line3-casaH}',
        '{line4-casaA}',
        '{line4-casaB}',
        '{line4-casaC}',
        '{line4-casaD}',
        '{line4-casaE}',
        '{line4-casaF}',
        '{line4-casaG}',
        '{line4-casaH}',
        '{line5-casaA}',
        '{line5-casaB}',
        '{line5-casaC}',
        '{line5-casaD}',
        '{line5-casaE}',
        '{line5-casaF}',
        '{line5-casaG}',
        '{line5-casaH}',
        '{line6-casaA}',
        '{line6-casaB}',
        '{line6-casaC}',
        '{line6-casaD}',
        '{line6-casaE}',
        '{line6-casaF}',
        '{line6-casaG}',
        '{line6-casaH}',
        '{line7-casaA}',
        '{line7-casaB}',
        '{line7-casaC}',
        '{line7-casaD}',
        '{line7-casaE}',
        '{line7-casaF}',
        '{line7-casaG}',
        '{line7-casaH}',
        '{line8-casaA}',
        '{line8-casaB}',
        '{line8-casaC}',
        '{line8-casaD}',
        '{line8-casaE}',
        '{line8-casaF}',
        '{line8-casaG}',
        '{line8-casaH}',
        '{jogador-superior}',
        '{jogador-inferior}'
    ];
}

?>