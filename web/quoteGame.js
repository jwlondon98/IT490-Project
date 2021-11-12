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
        return pos.x > this.x && pos.x < this.x+this.w && pos.y < this.y+this.h && pos.y > this.y;
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

function wordWrap(str, maxWidth) {
    var newLineStr = "\n"; done = false; res = '';
    while (str.length > maxWidth) {                 
        found = false;
        // Inserts new line at first whitespace of the line
        for (i = maxWidth - 1; i >= 0; i--) {
            if (testWhite(str.charAt(i))) {
                res = res + [str.slice(0, i), newLineStr].join('');
                str = str.slice(i + 1);
                found = true;
                break;
            }
        }
        // Inserts new line at maxWidth position, the word is too long to wrap
        if (!found) {
            res += [str.slice(0, maxWidth), newLineStr].join('');
            str = str.slice(maxWidth);
        }

    }

    return res + str;
}


function testWhite(x) {
    var white = new RegExp(/^\s$/);
    return white.test(x.charAt(0));
};

function think()
{
    
}

function update()
{
    time = Math.floor(Date.now() / 1000);
    
    
    if(!nextQuote)
    {
        
        nextQuote = "getting"
        
            $.ajax({type: "GET", url:"apiClient.php", async:true,
            success:function(data)
            {
                nextQuote = data;
                
                
            },
            failure:function(data)
            {
                nextQuote = "Failure";

            }
        });
            
    
    //nextQuote = "Don't be NOUN . Be NOUN . Be NOUN . Be NOUN . Start VERB";
        
        
    }
    
    //setup test ajax request
    
    if (time >= roundTime)
    {
        if(gamestate == "preround")
        {
            roundTime = time + 60;
            gamestate = "quotes"
            
            if(nextQuote == "getting")
            {
                alert("API call failed, reloading");
                window.location.reload();
            }
            
            quoteList = nextQuote.split(" ");
            quote = "";
            var index = -1;
            
            for(var count = 0; count < quoteList.length; count++)
            {
                if(quoteList[count] == "NOUN" || quoteList[count] == "VERB")
                {
                    tokens[tokens.length] = quoteList[count];
                    quoteList[count] = "___"
                }
                
                if(count % 10 == 0)
                {
                    index++;
                    strList[index] = "";
                }
                
                strList[index] = strList[index] + quoteList[count] + " ";
            }
            
            
            
             
            
        }
        else if(gamestate == "quotes")
        {
            roundTime = time + 60;
            gamestate = "judge"
            currentInput = "";
        }
        else if(gamestate == "judge")
        {
            roundTime = time + 10;
            gamestate = "preround"
            
            //send stat update to server
            
            
            
            $.ajax({type: "POST", url:"apiClient.php", async:true,
            success:function(data)
            {
                nextQuote = data;
                
                
            },
            failure:function(data)
            {
                nextQuote = "Failure";

            }
        });
            
            //reset all variables

            currentInput = "";

            nextQuote = null;
            quote = null;
            quoteList = null;

            showtoken = 0;

            finishedQuote = [];

            tokens = [];
            currentToken = 0;
            strList = [];
            response = [];
            
            
        }

    }
    
    if(gamestate == "quotes" && response.length == tokens.length)
    {
            roundTime = time + 15;
            gamestate = "judge"
            currentInput = "";
            
            //finishedQuote = "";
            index = -1;
            var tokensUsed = 0;
            //quoteList = nextQuote.split(" ");
            
            
            for(var count = 0; count < quoteList.length; count++)
            {
                //alert("test");
                
                if(count % 10 == 0)
                {
                    index++;
                    finishedQuote[index] = "";
                }
                
                if(quoteList[count] == "___")
                {

                    finishedQuote[index] = finishedQuote[index] + response[tokensUsed] + " ";
                    //finishedQuote[index] = finishedQuote[index] + quoteList[count] + " ";
                    
                    tokensUsed++;
                }
                else
                {
                    //alert(quoteList[count]);
                    finishedQuote[index] = finishedQuote[index] + quoteList[count] + " ";
                }
                
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
    
    ctx.beginPath();
    ctx.font = "30px Arial";
    ctx.fillStyle = "#A1DCFF"
    ctx.textBaseline = 'middle';
    ctx.textAlign = 'left';
    ctx.fillText("Time: " + timeLeft, canvas.width - 135, 25);
    ctx.closePath();
    
    
    if(gamemode == "classic")
    {
        ctx.beginPath();
        ctx.font = "30px Arial";
        ctx.fillStyle = "#A1DCFF"
        ctx.textBaseline = 'middle';
        ctx.textAlign = 'center';
        ctx.fillText("Classic", (canvas.width) / 2 + 150, 25);
        ctx.closePath();
    }
    else if(gamemode == "chaos")
    {
        ctx.beginPath();
        ctx.font = "30px Arial";
        ctx.fillStyle = "#A1DCFF"
        ctx.textBaseline = 'middle';
        ctx.textAlign = 'center';
        ctx.fillText("Chaos", (canvas.width) / 2 + 150, 25);
        ctx.closePath();
    }
    else if(gamemode == "blind")
    {
        ctx.beginPath();
        ctx.font = "30px Arial";
        ctx.fillStyle = "#A1DCFF"
        ctx.textBaseline = 'middle';
        ctx.textAlign = 'center';
        ctx.fillText("Blind", (canvas.width) / 2 + 150, 25);
        ctx.closePath();
    }

    
    if(tokens[showtoken])
    {
        if(gamemode == "classic" || gamemode == "chaos")
        {
            ctx.beginPath();
            ctx.font = "30px Arial";
            ctx.fillStyle = "#000000"
            ctx.textBaseline = 'middle';
            ctx.textAlign = 'left';
            ctx.fillText(tokens[showtoken] + ": " + currentInput, 300 + 25, 550);
            ctx.closePath();
        }
        else if(gamemode == "blind")
        {
            ctx.beginPath();
            ctx.font = "30px Arial";
            ctx.fillStyle = "#000000"
            ctx.textBaseline = 'middle';
            ctx.textAlign = 'left';
            ctx.fillText("WORD: " + currentInput, 300 + 25, 550);
            ctx.closePath();
        }
    }
    

    
    //draw game stuff
    

}

function draw()
{
    if (gamestate == "quotes")
    {
        //alert("test");
        
        if(gamemode == "classic")
        {
            for(var i = 0; i < strList.length; i++)
            {
                ctx.beginPath();
                ctx.font = "20px Arial";
                ctx.fillStyle = "#000000";
                ctx.textBaseline = 'middle';
                ctx.textAlign = 'center';
                ctx.fillText(strList[i], (canvas.width) / 2 + 150, canvas.height / 2 - 100 + (30 * i));
                ctx.closePath();
            }
        }
        else if(gamemode == "chaos" || gamemode == "blind")
        {
            ctx.beginPath();
            ctx.font = "50 Arial";
            ctx.fillStyle = "#000000";
            ctx.textBaseline = 'middle';
            ctx.textAlign = 'center';
            ctx.fillText("Write Some Words!", (canvas.width) / 2 + 150, canvas.height / 2 - 100);
            ctx.closePath();
        }
        


    }
    else if (gamestate == "judge")
    {
//         alert(finishedQuote.length);
        
        for(var i = 0; i < finishedQuote.length; i++)
        {
            ctx.beginPath();
            ctx.font = "20px Arial";
            ctx.fillStyle = "#000000";
            ctx.textBaseline = 'middle';
            ctx.textAlign = 'center';
            ctx.fillText(finishedQuote[i], (canvas.width) / 2 + 150, canvas.height / 2 - 100 + (30 * i));
            ctx.closePath();
            
        }
        
            ctx.beginPath();
            ctx.font = "30px Arial";
            ctx.fillStyle = "#000000";
            ctx.textBaseline = 'middle';
            ctx.textAlign = 'center';
            ctx.fillText("Round Won!", (canvas.width) / 2 + 150, 450);
            ctx.closePath();

    }

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
var roundTime = time + 5;


var gamemode = document.getElementById("gameScript").getAttribute("data-gamemode");

var currentInput = "";

var nextQuote;
var quote;
var quoteList;

var showtoken = 0;

var finishedQuote = [];

var tokens = [];
var currentToken = 0;
var strList = [];
var response = [];

var wordsPlayed = 0;
var gamesPlayed = 0;
var gamesWon = 0;


//alert(gamemode + " " + lobbyid + " " + host);


//drawBaseUI();



//game 'loop'

canvas.addEventListener('click', function() {onClick(canvas, evt);}, false);

document.addEventListener('keypress', (event) => {
    
    if(gamestate == "quotes")
    {
        if(event.keyCode === 13)
        {
            response[response.length] = currentInput;
            currentInput = "";
            showtoken++;
            wordsPlayed++;
        }
        else
        {
            currentInput = currentInput + event.key;
        }
    }
    

    
}, false);
    
var interval = setInterval(gameLoop, 100);
