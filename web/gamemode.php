<!DOCTYPE html>
<html>
      
<head>
    <title>
        How to call PHP function
        on the click of a Button ?
    </title>
</head>
  
<body style="text-align:center;">
      
    <?php
        if(array_key_exists('classicButton', $_POST)) {
            button1();
        }
        else if(array_key_exists('coopButton', $_POST)) {
            button2();
        }
        else if(array_key_exists('chaosButton', $_POST)) {
            button3();
        }
        function button1() {
            header("Location:lobby.php?gamemode=classic");
        }
        function button2() {
            header("Location:lobby.php?gamemode=coop");
        }
        function button3() {
            header("Location:lobby.php?gamemode=chaos");
        }
    ?>
  
    <form method="post">
        <input type="submit" name="classicButton"
                class="button" value="Classic" />
          
        <input type="submit" name="coopButton"
                class="button" value="Coop" />
                
        <input type="submit" name="chaosButton"
                class="button" value="Chaos" />
    </form>
</head>
  
</html>
