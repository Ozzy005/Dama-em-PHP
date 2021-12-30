<?php

/**
 *
 * @author Rafael Arend
 *
**/

namespace app\controllers;

use Library\{Session, Request, Base, Validar};
use App\Models\{Tabuleiro as TabuleiroModelo, QualLadoDoJogador, JogadorAtual, Regras, Movimento};
use Components\{Jogador, Turno, Historico, Cemiterio};
use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Tabuleiro extends Base
{
    public function montar(Request $request): void
    {
        try {
            $jogadorId = (int) $request->get('jogadorId');
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

            if (Session::notHas('dados')) {
                Session::put('dados', $this->dados);
            };

            $this->exibir();
        } catch (Exception $e) {
            Session::destroy();
            header('Location: /home');
        }
    }

    public function mover(Request $request): void
    {
        try {
            $pecaAtacanteId = (int) $request->get('pecaAtacanteId');
            Validar::peca($pecaAtacanteId);

            $lOrigem = (int) $request->get('linhaOrigem');
            $cOrigem = (int) $request->get('colunaOrigem');
            Validar::casa($lOrigem, $cOrigem);

            $lDestino = (int) $request->get('linhaDestino');
            $cDestino = (int) $request->get('colunaDestino');
            Validar::casa($lDestino, $cDestino);

            $pecaAtacante = $this->dados->tabuleiro->getPeca($lOrigem, $cOrigem);
            $this->dados->pecaAtacante = $pecaAtacante;
            $this->dados->linhaOrigem = $lOrigem;
            $this->dados->colunaOrigem = $cOrigem;
            $this->dados->linhaDestino = $lDestino;
            $this->dados->colunaDestino = $cDestino;

            $regras = new Regras;
            $regras->aplicar();

            $movimento = new Movimento;
            $movimento->fazer();

            $jogadorAtual = new JogadorAtual;
            $jogadorAtual->fazer();

            $this->exibir();
        } catch (Exception $e) {
            $this->dados->alerta = $e->getMessage();
            $this->exibir();
        }
    }

    public function reiniciar(): void
    {
        Session::destroy();
        header('Location: /home');
    }

    public function exibir(): void
    {
        $loader = new FilesystemLoader('../App/Views/Tabuleiro/');
        $twig = new Environment($loader);
        echo $twig->render('Tabuleiro.html', ['dados' => $this->dados]);
    }
}
