(function() {
    var startingTime = new Date().getTime();
    // Load the script
    var script = document.createElement("SCRIPT");
    script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js';
    script.type = 'text/javascript';
    document.getElementsByTagName("head")[0].appendChild(script);

    // Poll for jQuery to come into existance
    var checkReady = function(callback) {
        if (window.jQuery) {
            callback(jQuery);
        }
        else {
            window.setTimeout(function() { checkReady(callback); }, 20);
        }
    };

    // Start polling...
    checkReady(function($) {
        $(function() {
            var endingTime = new Date().getTime();
            var tookTime = endingTime - startingTime;
            //window.alert("jQuery is loaded, after " + tookTime + " milliseconds!");
        });
    });
})();


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

function onClick(canvas, evt)
{
    var mousePos = getMousePos(canvas, evt);

    if (classicButton.isInside(mousePos)) 
    {
            //alert('clicked inside rect');

    }

}

function think()
{
    
}

function update()
{
    time = Math.floor(Date.now() / 1000);
    
    //setup test ajax request
    
    if (time >= roundTime)
    {
        if(gamestate == "preround")
        {
            roundTime = time + 60;
            gamestate == "quotes"
            
            $.ajax({type: "GET", url:"testLog.php"});

            //$.ajax({type: "GET", url: "testLog.php"});
            
        }
        if(gamestate == "quotes")
        {
            roundTime = time + 60;
            gamestate == "judge"
        }
        if(gamestate == "judge")
        {
            roundTime = time + 10;
            gamestate == "endround"
        }
        if(gamestate == "endround")
        {
            roundTime = time + 15;
            gamestate == "preround"
        }
        
    }
}

function drawBaseUI()
{
    ctx.clearRect(0,0, canvas.width, canvas.height);
    
    //draw generic UI
    
    ctx.beginPath();
    ctx.rect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = "#949494";
    ctx.fill();
    
    ctx.beginPath();
    ctx.rect(5, 5, canvas.width - 10, canvas.height - 10);
    ctx.fillStyle = "#FFFFFF";
    ctx.fill();
    
    ctx.beginPath();
    ctx.rect(0, canvas.height - 100, canvas.width, 100);
    ctx.fillStyle = "#949494";
    ctx.fill();
    
    ctx.beginPath();
    ctx.rect(5, canvas.height - 95, canvas.width - 10, 90);
    ctx.fillStyle = "#A1DCFF";
    ctx.fill();
    
    ctx.beginPath();
    ctx.rect(0, 0, 300, canvas.height);
    ctx.fillStyle = "#949494";
    ctx.fill();
    
    ctx.beginPath();
    ctx.rect(5, 5, 290, canvas.height - 10);
    ctx.fillStyle = "#A1DCFF";
    ctx.fill();
    
    //draw player list
    
    //draw Chat
    
    //draw timer
    
    var timeLeft = roundTime - time;
    
    ctx.font = "30px Arial";
    ctx.fillStyle = "#A1DCFF"
    ctx.textBaseline = 'middle';
    ctx.textAlign = 'left';
    ctx.fillText("Time: " + timeLeft, canvas.width - 135, 25);
    ctx.closePath();
    
    //draw game stuff
    

}

function gameLoop()
{
    think();
    update();
    drawBaseUI();
    draw();
}

//main game setup


var gamestate = "preround";
var gametype = "none";
var canvas = document.getElementById("gameCanvas");
var ctx = canvas.getContext("2d");

var time = Math.floor(Date.now() / 1000);
var roundTime = time + 15;




//drawBaseUI();



var classicButton = new Button(350, 100, 300, 100, "#2B91D9", "Classic");



//game 'loop'

canvas.addEventListener('click', function() {onClick(canvas, evt);}, false);
    
var interval = setInterval(gameLoop, 100);
