# Dama em PHP

> Status do Projeto: 🚧  Dama em PHP 🚀 Em construção...  🚧

Para o desenvolvimento desse jogo de dama, foi optado por utilizar as regras de damas brasileiras.

### Screenshot da home page
<img src="screenshot/home.png"/>

### Screenshot da main page
<img src="screenshot/game.png"/>

### 📋 Pré-requisitos

Versão do PHP utilizada para o desenvolvimento desse jogo = PHP 7.4.3

### Funcionalidades

- [x] Definição das peças.
- [x] Definição do tabuleiro.
- [x] Definição do controle.
- [x] Possibilidade de escolher com qual peça jogar (1 = branca, 2 = preta).
- [x] Botão de resete para recomeçar o jogo (volta para a opção de escolher com qual peça jogar).
- [x] Selecionar colunas e peças de forma interativa destacando-as clicando com o botão esquerdo do mouse.
- [x] Confirmar o movimento clicando duas vezes com botão esquerdo na casa de destino.
- [x] Gerar mensagem de erro se ocorrer um movimento inválido.
- [x] Exibir na tela turno e jogador atual.
- [ ] Opção para um jogador.
- [x] Opção para dois jogadores.
- [ ] Opção para jogar online.
- [ ] Opção para desistir.
- [ ] Opção para sugerir empate.
- [ ] Ensinar o computador a jogar (para opção de um jogador).
- [ ] Histórico de movimentos.
- [ ] Opção entrar como visitante com um codinome.
- [ ] Opção entrar com credênciais.
- [ ] Ranking dos melhores jogadores.


### Regras
- [x] O lance inicial cabe sempre a quem estiver com as peças brancas.
- [x] A pedra move-se só para frente, uma casa de cada vez.
- [x] O jogador só pode mover suas peças no seu turno e somente um lance por turno.
- [x] Peças não podem mover-se para casas brancas.
- [x] Peças não podem mover-se para casas ocupadas.
- [x] Captura de única peça.
- [x] Captura de múltiplas peças.
- [x] Permitido a pedra capturar tanto para frente quanto para trás.
- [x] Proibido capturar uma peça da mesma cor.
- [x] Duas ou mais peças juntas, na mesma diagonal, não podem ser capturadas.
- [x] Na execução do lance de captura, é permitido passar mais de uma vez pela mesma casa vazia.

#### Regras referente a lei da maioria (obrigatório executar o lance que captura a maior quantidade de peças)
- [x] 1 peça com várias opções de captura com apenas 1 opção benéfica entre todas. É obrigatório executar a opção mais benéfica.
- [x] 1 peça com várias opções de captura igualmente benéficas com casa de destino diferente. A escolha da opção fica a critério do jogador.
- [x] 1 peça com várias opções de captura igualmente benéficas com casa de destino igual. A escolha da opção fica a critério do algoritmo.
- [x] 1 peça com várias opções de captura igualmente benéficas com casa de destino igual, porém peça atacante passa mais de uma vez pela mesma casa de origem. A escolha da opção fica a critério do algoritmo.


- [ ] Quando a pedra atinge a oitava linha do tabuleiro ela é promovida à dama.
- [ ] A dama move-se para frente e para trás, quantas casas quiser.
- [ ] A dama não pode saltar uma peça da mesma cor.
- [ ] Permitido a dama capturar tanto para frente quanto para trás.
- [ ] A pedra captura a dama e a dama captura a pedra.
- [ ] A pedra que durante o lance de captura de várias peças, apenas passe por qualquer casa de coroação, sem aí parar, não será promovida à dama.
- [ ] Após 20 lances sucessivos de damas, sem captura ou deslocamento de pedra, a partida é declarada empatada.

### 📄 Licença
Este projeto está sob a licença (GPLv3) - veja o arquivo [LICENSE.md](https://github.com/Ozzy005/Dama-em-PHP/blob/main/README.md) para detalhes.

### ✒️ Autores
* **Rafael Arend** - *Todo o projeto* - [Rafael Arend](https://github.com/Ozzy005)

### 📞 Telefone
* **66 9 9604 0978**

### 📧 Email
* **rafinhaarend123@hotmail.com**

