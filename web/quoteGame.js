class Button
{
    constructor(x, y, w, h, color, label = "")
    {
        this.x = x;
        this.y = y;
        this.w = w;
        this.h = h;
        this.color = color;
        this.label = label;
    }

    draw()
    {
        ctx.beginPath();
        ctx.rect(this.x, this.y, this.w, this.h);
        ctx.fillStyle = this.color;
        ctx.fill();
        
        
        ctx.font = "50px Arial";
        ctx.fillStyle = "#FFFFFF"
        ctx.textBaseline = 'middle';
        ctx.textAlign = 'center';
        ctx.fillText(this.label, this.x + this.w / 2, this.y + this.h / 2);
        ctx.closePath();
    }
    isInside(pos)
    {
        return pos.x > this.x && pos.x < this.x+this.w && pos.y < this.y+this.h && pos.y > this.y
    }

}


//Function to get the mouse position
function getMousePos(canvas, event) {
    var rect = canvas.getBoundingClientRect();
    return {
        x: event.clientX - rect.left,
        y: event.clientY - rect.top
    };
}

function think()
{
    
}

function update()
{
    
}

function draw()
{
    ctx.clearRect(0,0, canvas.width, canvas.height);
    
    if(gamestate == 'main')
    {
        //alert("test");
        classicButton.draw();
        coopButton.draw();
        chaosButton.draw();
    }
}

function gameLoop()
{
    think();
    update();
    draw();
}

//main game setup


var gamestate = "main";
var gametype = "none";
var canvas = document.getElementById("gameCanvas");
var ctx = canvas.getContext("2d");

var classicButton = new Button(350, 100, 300, 100, "#2B91D9", "Classic");
var coopButton = new Button(350, 250, 300, 100, "#2B91D9", "Co-op");
var chaosButton = new Button(350, 400, 300, 100, "#2B91D9", "Chaos");






//game 'loop'

    canvas.addEventListener('click', function(evt) 
    {
        var mousePos = getMousePos(canvas, evt);

        if (classicButton.isInside(mousePos)) 
        {
            //alert('clicked inside rect');
            gamestate = "lobbylist";
            gametype = "classic";
        }
        else if (coopButton.isInside(mousePos)) 
        {
            //alert('clicked inside rect');
            gamestate = "lobbylist";
            gametype = "coop";
        }
        else if (chaosButton.isInside(mousePos)) 
        {
            //alert('clicked inside rect');
            gamestate = "lobbylist";
            gametype = "chaos";
        }
        
        else
        {
            //alert('clicked outside rect');
        }   
    }, false);
    
var interval = setInterval(gameLoop, 100);
