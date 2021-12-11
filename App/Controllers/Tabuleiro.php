<?php

/**
 *
 * @author Rafael Arend
 *
 **/

namespace App\Controllers;

use Library\{Session, Post, Base};
use App\Models\{Validar, Tabuleiro as TabuleiroModelo, QualLadoDoJogador, JogadorAtual, Regras, Movimento};
use Components\{Jogador, Turno, Historico, Cemiterio};
use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Tabuleiro extends Base
{
    public function montar()
    {
        try {
            if (Session::notHas('dados')) {
                $jogadorId = (int) Post::get('jogadorId');
                Validar::jogador($jogadorId);
                $this->dados->jogador = new Jogador($jogadorId);

                $modeloTabuleiro = new TabuleiroModelo;
                $modeloTabuleiro->fazer();

                $this->dados->turno = new Turno;
                $this->dados->historico = new Historico;
                $this->dados->cemiterio = new Cemiterio;

                $qualLadoDoJogador = new QualLadoDoJogador;
                $qualLadoDoJogador->fazer();
                $jogadorAtual = new JogadorAtual;
                $jogadorAtual->fazer();
            }
        } catch (Exception $e) {
            Session::destroy();
            header('Location: index.php');
        }
    }

    public function mover()
    {
        try {
            $pecaAtacanteId = (int) Post::get('pecaAtacanteId');
            Validar::peca($pecaAtacanteId);

            $lOrigem = (int) Post::get('linhaOrigem');
            $cOrigem = (int) Post::get('colunaOrigem');
            Validar::casa($lOrigem, $cOrigem);

            $lDestino = (int) Post::get('linhaDestino');
            $cDestino = (int) Post::get('colunaDestino');
            Validar::casa($lDestino, $cDestino);

            $pecaAtacante = $this->dados->tabuleiro->getPeca($lOrigem, $cOrigem);
            $this->dados->pecaAtacante = $pecaAtacante;
            $this->dados->linhaOrigem = $lOrigem;
            $this->dados->colunaOrigem = $cOrigem;
            $this->dados->linhaDestino = $lDestino;
            $this->dados->colunaDestino = $cDestino;

            $regras = new Regras();
            $regras->aplicar();
            
            $movimento = new Movimento();
            $movimento->fazer();
            
            $jogadorAtual = new JogadorAtual();
            $jogadorAtual->fazer();
        } catch (Exception $e) {
            $this->dados->alerta = $e->getMessage();
        }
    }

    public function reiniciar()
    {
        Session::destroy();
        header('Location: index.php');
    }

    public function exibir()
    {
        if (Session::notHas('dados')) {
            Session::put('dados', $this->dados);
        };

        $loader = new FilesystemLoader('../App/Views/Tabuleiro/');
        $twig = new Environment($loader);
        echo $twig->render('tabuleiro.html', ['dados' => $this->dados]);
    }
}
