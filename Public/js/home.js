
if(window.history.replaceState)
{
    window.history.replaceState(null,null,window.location.href);
}

let color_black = document.getElementById('color-black');
let color_white = document.getElementById('color-white');
let piece_chosen = document.getElementById('piece-chosen');

color_black.addEventListener('click',function()
{
    piece_chosen.value = color_black.getAttribute('id');
});

color_white.addEventListener('click',function()
{
    piece_chosen.value = color_white.getAttribute('id');
});