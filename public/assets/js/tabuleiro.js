if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href)
}

let pecas = document.querySelectorAll(".peca")
let pecaAtual = null

for (let i = 0; i < pecas.length; i++) {
  pecas[i].addEventListener("click", function () {
    if (pecaAtual !== null) {
      pecaAtual.style.zIndex = "auto"
      pecaAtual.style.outline = "none"
      pecaAtual.style.boxShadow = "none"
      pecaAtual = null
    }

    let pecaId = pecas[i].getAttribute("id")
    let inputPeca = document.querySelector("#pecaAtacanteId")
    inputPeca.value = pecaId

    let colunaId = pecas[i].parentNode.getAttribute("id")
    let inputColuna = document.querySelector("#colunaOrigem")
    inputColuna.value = colunaId

    let linhaId = pecas[i].parentNode.parentNode.getAttribute("id")
    let inputLinha = document.querySelector("#linhaOrigem")
    inputLinha.value = linhaId

    pecaAtual = pecas[i]
    pecaAtual.style.zIndex = "1"
    pecaAtual.style.outline = "0.25vw solid #ff0000"
    pecaAtual.style.boxShadow = "0 0 0.25vw 0.25vw #ff0000"
  })
}

let colunas = document.querySelectorAll(".coluna")
let colunaAtual = null

for (let i = 0; i < colunas.length; i++) {
  colunas[i].addEventListener("click", function () {
    if (colunaAtual !== null) {
      colunaAtual.style.borderTop = "0.2vw solid black"
      colunaAtual.style.borderLeft = "0.2vw solid black"
      colunaAtual.style.zIndex = "auto"
      colunaAtual.style.outline = "none"
      colunaAtual.style.boxShadow = "none"
      colunaAtual = null
    }

    let colunaId = colunas[i].getAttribute("id")
    let inputColuna = document.querySelector("#colunaDestino")
    inputColuna.value = colunaId

    let linhaId = colunas[i].parentNode.getAttribute("id")
    let inputLinha = document.querySelector("#linhaDestino")
    inputLinha.value = linhaId

    colunaAtual = colunas[i]
    colunaAtual.style.border = "0"
    colunaAtual.style.zIndex = "1"
    colunaAtual.style.outline = "0.25vw solid #ff0000"
    colunaAtual.style.boxShadow = "0 0 0.25vw 0.25vw #ff0000"
  })
}

for (let i = 0; i < colunas.length; i++) {
  window.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector("#form")

    colunas[i].addEventListener("dblclick", function () {
      input = document.createElement("input")
      input.setAttribute("name", "metodo")
      input.setAttribute("value", "mover")
      form.appendChild(input)
      form.submit()
    })
  })
}
