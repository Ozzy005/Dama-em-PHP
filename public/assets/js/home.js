if (window.history.replaceState) {
	window.history.replaceState(null, null, window.location.href);
}

let jogadorBranco = document.getElementById('1');
let jogadorPreto = document.getElementById('2');
let jogador = document.getElementById('jogadorId');

jogadorPreto.addEventListener('click', () => {
	jogador.value = jogadorPreto.getAttribute('id');
});

jogadorBranco.addEventListener('click', function () {
	jogador.value = jogadorBranco.getAttribute('id');
});
