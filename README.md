# Dama em PHP

> Status do Projeto: Em desenvolvimento :warning:

## 1
O jogo de damas é praticado em um tabuleiro de 64 casas, claras e escuras. A grande diagonal (escura), deve ficar sempre à esquerda de cada jogador. O objetivo do jogo é imobilizar ou capturar todas as peças do adversário.

<img src="img/png1.png"/>

## 2
O jogo de damas é praticado entre dois parceiros, com 12 pedras brancas de um lado e com 12 pedras pretas de outro lado.
O lance inicial cabe sempre a quem estiver com as peças brancas.

<img src="img/png2.png"/>

## 3
A pedra anda só para frente, uma casa de cada vez. Quando a pedra atinge a oitava linha do tabuleiro ela é promovida à dama.

<img src="img/png3.png"/>

## 4
A dama é uma peça de movimentos mais amplos. Ela anda para frente e para trás, quantas casas quiser. A dama não pode saltar uma peça da mesma cor.

<img src="img/png4.png"/>

## 5
A captura é obrigatória.
Não existe sopro.
Duas ou mais peças juntas, na mesma diagonal, não podem ser capturadas.

<img src="img/png5.png"/>

## 6
A pedra captura a dama e a dama captura a pedra. Pedra e dama têm o mesmo valor para capturarem ou serem capturadas.

<img src="img/png6.png"/>

## 7
A pedra e a dama podem capturar tanto para frente como para trás, uma ou mais peças

<img src="img/png7.png"/>

## 8
Se no mesmo lance se apresentar mais de um modo de capturar, é obrigatório executar o lance que capture o maior número de peças (Lei da Maioria).

<img src="img/png8.png"/>

## 9
A pedra que durante o lance de captura de várias peças, apenas passe por qualquer casa de coroação, sem aí parar, não será promovida à dama.

<img src="img/png9.png"/>

## 10
Na execução do lance do lance de captura, é permitido passar mais de uma vez pela mesma casa vazia, não é permitido capturar duas vezes a mesma peça.

<img src="img/png10.png"/>

## 11
Na execução do lance de captura, não é permitido capturar a mesma peça mais de uma vez e as peças capturadas não podem ser retiradas do tabuleiro antes de completar o lance de captura.

<img src="img/png11.png"/>

## 12
Empate:
Após 20 lances sucessivos de damas, sem captura ou deslocamento de pedra, a partida é declarada empatada.
Finais de:
2 damas contra 2 damas;
2 damas contra uma;
2 damas contra uma dama e uma pedra;
uma dama contra uma dama e uma dama contra uma dama e uma pedra, são declarados empatados após 5 lances.

### 📋 Pré-requisitos

Versão do PHP utilizada para o desenvolvimento desse jogo = PHP 7.4.3

<--------------------------------------------------------------------------------------------------------------------------------------->
### Funcionalidades desenvolvidas e não desenvolvidas

- [x] Definição das peças
- [x] Definição do tabuleiro
- [x] Possibilidade de escolher a cor das peças que ira jogar
- [x] Definição do controle
- [x] Botão de resete para recomeçar o jogo (volta para a opção de escolher a cor das peças)
- [x] Selecionar casas e peças de forma interativa clicando com o botão esquerdo do mouse, ao mesmo tempo que preenche as entradas do formulário
- [x] Gerar mensagem de erro se ocorrer um movimento inválido
- [ ] Confirmar a movimentação da peças clicando com o botão direito do mouse
- [ ] Não é possível mexer as peças do outro jogador, cada um só pode movimentar suas peças no seu turno e somente uma vez a cada turno

### Funcionalidades referentes as regras do jogo


- [x] Não ser possível movimentar peças para as casas brancas
- [ ] Não ser possível movimentar um peça para trás (com exceção das damas)
- [ ] O lance inicial cabe sempre a quem estiver com as peças brancas.
- [ ] A peça anda só para frente, uma casa de cada vez.
- [ ] Quando a pedra atinge a oitava linha do tabuleiro ela é promovida à dama.
<--------------------------------------------------------------------------------------------------------------------------------------->

## ✒️ Autores

* **Rafael Arend** - *Todo o projeto* - [Rafael Arend](https://github.com/Ozzy005)

## 📄 Licença

Este projeto está sob a licença (GPLv3) - veja o arquivo [LICENSE.md](https://github.com/Ozzy005/Dama-em-PHP/blob/main/README.md) para detalhes.


---
⌨️ com ❤️ por [Rafael Arend](https://github.com/Ozzy005) 😊