
if(window.history.replaceState)
{
    window.history.replaceState(null,null,window.location.href);
}

let player_black = document.getElementById('2');
let player_white = document.getElementById('1');
let player_chosen = document.getElementById('player-chosen');

player_black.addEventListener('click',function()
{
    player_chosen.value = player_black.getAttribute('id');
});

player_white.addEventListener('click',function()
{
    player_chosen.value = player_white.getAttribute('id');
});