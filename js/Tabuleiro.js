
if(window.history.replaceState)
{
    window.history.replaceState(null,null,window.location.href);
}

let pecas = document.querySelectorAll(".peca");
let pecaAtual = null;

for(let i = 0 ; i < pecas.length ; i++)
{
    pecas[i].addEventListener('click',function()
    {
        if(pecaAtual != null)
        {
            pecaAtual.style.zIndex = "auto";
            pecaAtual.style.outline = "0";
            pecaAtual.style.boxShadow = "none";
            pecaAtual = null;
        }

        let idPeca = pecas[i].getAttribute('id');
        let inputPeca = document.querySelector('#input-peca');

        inputPeca.value = idPeca;

        if(inputPeca.value == idPeca && pecaAtual == null)
        {
            pecaAtual = pecas[i];

            pecas[i].style.zIndex = "1";
            pecas[i].style.outline = "3px solid #ff0000";
            pecas[i].style.boxShadow = "0px 0px 3px 3px #ff0000";
        }
    });
}

let colunas = document.querySelectorAll(".coluna");
let colunaAtual = null;

for(let i = 0 ; i < colunas.length ; i++)
{
    colunas[i].addEventListener('click',function()
    {
        if(colunas[i].childNodes.length === 0)
        {
            if(colunaAtual != null)
            {
                colunaAtual.style.borderTop = "2px solid black";
                colunaAtual.style.borderLeft = "2px solid black";
                colunaAtual.style.zIndex = "auto";
                colunaAtual.style.outline = "0";
                colunaAtual.style.boxShadow = "none";

                colunaAtual = null;
            }

            let idColuna = colunas[i].getAttribute('id');
            let inputColuna = document.querySelector('#input-coluna');
            inputColuna.value = idColuna;

            let idLinha = colunas[i].parentNode.getAttribute('id');
            let inputLinha = document.querySelector('#input-linha');
            inputLinha.value = idLinha;


            if(inputColuna.value == idColuna && colunaAtual == null)
            {
                colunas[i].style.border = "0";
                colunas[i].style.zIndex = "1";
                colunas[i].style.outline = "3px solid #ff0000";
                colunas[i].style.boxShadow = "0px 0px 3px 3px #ff0000";

                colunaAtual = colunas[i];
            }
        }
    });
}