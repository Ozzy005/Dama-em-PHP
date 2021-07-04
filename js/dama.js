let pecas = document.querySelectorAll(".peca");
let casas = document.querySelectorAll(".casa");

let idPecaAtual = null;
let idCasaAtual = null;

for(let i = 0 ; i < pecas.length ; i++)
{
    pecas[i].addEventListener('click',function()
    {
        //se elemento atual for diferente de null
        if(idPecaAtual != null)
        {
            //seleciona o elemento atual e zera o estilo
            let pecaAtual = document.getElementById(idPecaAtual);
            pecaAtual.style.zIndex = "auto";
            pecaAtual.style.outline = "0";
            pecaAtual.style.boxShadow = "none";

            idPecaAtual = null;
        }

        let idPecaNova = pecas[i].getAttribute('id');
        let inputPeca = document.querySelector('#input-peca');

        inputPeca.value = idPecaNova;

        if(inputPeca.value == idPecaNova && idPecaAtual == null)
        {
            let pecaNova = document.getElementById(idPecaNova);

            idPecaAtual = idPecaNova;

            pecaNova.style.zIndex = "1";
            pecaNova.style.outline = "3px solid #ff0000";
            pecaNova.style.boxShadow = "0px 0px 5px 5px #ff0000";

        }
    });
}

for(let i = 0 ; i < casas.length ; i++)
{
    casas[i].addEventListener('click',function()
    {
        //verifica se o elemento não possue nodes filhos
        if(casas[i].childNodes.length === 0)
        {

            if(idCasaAtual != null)
            {
                let casaAtual = document.getElementById(idCasaAtual);
                casaAtual.style.zIndex = "auto";
                casaAtual.style.outline = "0";
                casaAtual.style.boxShadow = "none";

                idCasaAtual = null;
            }

            //pega o valor do id do elemento clicado
            let idCasaNova = casas[i].getAttribute('id');

            //seleciona o input casa
            let inputCasa = document.querySelector('#input-casa');

            inputCasa.value = idCasaNova;

            //verifica se o valor do input é igual o valor do elemento clicado
            if(inputCasa.value == idCasaNova && idCasaAtual == null)
            {
                let casaNova = document.getElementById(idCasaNova);

                idCasaAtual = idCasaNova;

                casaNova.style.zIndex = "1";
                casaNova.style.outline = "3px solid #ff0000";
                casaNova.style.boxShadow = "0px 0px 5px 5px #ff0000";
            }
        }
    });
}