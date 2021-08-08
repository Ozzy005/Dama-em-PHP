
if(window.history.replaceState)
{
    window.history.replaceState(null,null,window.location.href);
}

let color_black = document.getElementById('2');
let color_white = document.getElementById('1');
let piece_chosen = document.getElementById('color-chosen');

color_black.addEventListener('click',function()
{
    piece_chosen.value = color_black.getAttribute('id');
});

color_white.addEventListener('click',function()
{
    piece_chosen.value = color_white.getAttribute('id');
});