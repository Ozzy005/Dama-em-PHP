
if(window.history.replaceState)
{
    window.history.replaceState(null,null,window.location.href);
}

let pieces = document.querySelectorAll(".piece");
let piece_current = null;

for(let i = 0 ; i < pieces.length ; i++)
{
    pieces[i].addEventListener('click',function()
    {
        if(piece_current !== null)
        {
            piece_current.style.zIndex = "auto";
            piece_current.style.outline = "none";
            piece_current.style.boxShadow = "none";
            piece_current = null;
        }

        let id_piece = pieces[i].getAttribute('id');
        let input_piece = document.querySelector('#piece-attacking');
        input_piece.value = id_piece;

        let id_column = pieces[i].parentNode.getAttribute('id');
        let input_column = document.querySelector('#column-source');
        input_column.value = id_column;

        let id_line = pieces[i].parentNode.parentNode.getAttribute('id');
        let input_line = document.querySelector('#line-source');
        input_line.value = id_line;

        piece_current = pieces[i];
        piece_current.style.zIndex = "1";
        piece_current.style.outline = "0.25vw solid #ff0000";
        piece_current.style.boxShadow = "0 0 0.25vw 0.25vw #ff0000";
    });
}

let columns = document.querySelectorAll(".column");
let column_current = null;

for(let i = 0 ; i < columns.length ; i++)
{
    columns[i].addEventListener('click',function()
    {
        if(columns[i].childNodes.length === 0)
        {
            if(column_current !== null)
            {
                column_current.style.borderTop = "0.2vw solid black";
                column_current.style.borderLeft = "0.2vw solid black";
                column_current.style.zIndex = "auto";
                column_current.style.outline = "none";
                column_current.style.boxShadow = "none";
                column_current = null;
            }

            let id_column = columns[i].getAttribute('id');
            let input_column = document.querySelector('#column-destiny');
            input_column.value = id_column;

            let id_line = columns[i].parentNode.getAttribute('id');
            let input_line = document.querySelector('#line-destiny');
            input_line.value = id_line;

            column_current = columns[i];
            column_current.style.border = "0";
            column_current.style.zIndex = "1";
            column_current.style.outline = "0.25vw solid #ff0000";
            column_current.style.boxShadow = "0 0 0.25vw 0.25vw #ff0000";
        }
    });
}

for(let i = 0 ; i < columns.length ; i++)
{
    window.addEventListener('DOMContentLoaded', function ()
    {
        var form = document.getElementById('form');

        columns[i].addEventListener('dblclick', function ()
        {
            input = document.createElement('input');
            input.setAttribute('name','method');
            input.setAttribute('value','move');
            form.appendChild(input);
            form.submit();
        });
    });
}

