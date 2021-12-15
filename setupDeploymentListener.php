#!/usr/bin/php
<?php


function copy_dir($source, $dest)
{
    mkdir($dest, 0755);
    foreach (
    $iterator = new \RecursiveIteratorIterator(
    new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST) as $item
    ){
        if ($item->isDir()) 
        {
            if(!is_dir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathname()))
            {
                mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathname());
            }
        } else {
    copy($item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathname());
  }}

}

shell_exec("sudo apt-get install -y php-ssh2");

// # link deploy script to /usr/local/bin

shell_exec("sudo ln -s deploy /usr/local/bin/deploy");

// # ln -l deploy /usr/local/bin/deploy


// # make user/local/deployment

copy_dir("./deployment", "/usr/local/deployment");

// # get machine name from user

echo "Please choose a machine name from one of the values below:".PHP_EOL;
echo "frontendDev".PHP_EOL;
echo "frontendQA".PHP_EOL;
echo "frontendProd".PHP_EOL;
echo "backendDev".PHP_EOL;
echo "backendQA".PHP_EOL;
echo "backendProd".PHP_EOL;
echo "DMZDev".PHP_EOL;
echo "DMZQA".PHP_EOL;
echo "DMZProd".PHP_EOL.PHP_EOL;



$hasName=false;
$machineName="";

while (!$hasName)
{
    $input = readline("Machine Name: ");
    
    switch($input)
    {
        case "frontendDev":
        case "frontendQA":
        case "frontendProd":
        case "backendDev":
        case "backendQA":
        case "backendProd":
        case "DMZDev":
        case "DMZQA":
        case "DMZProd":
            $hasName=true;
            break;
        
        if(!$hasName)
        {
            echo "Please use one of the names above".PHP_EOL.PHP_EOL;
        }
        else
        {
            $machineName=$input;
        }
    }
}

$file = fopen("/usr/local/deployment/machine.txt", "c");
fwrite($file, $machineName);
fclose($file);


// # make tracked.txt, services.txt, scripts.txt

$file = fopen("/usr/local/deployment/tracked.txt", "c");
fwrite($file, "");
fclose($file);

$file = fopen("/usr/local/deployment/services.txt", "c");
fwrite($file, "");
fclose($file);

$file = fopen("/usr/local/deployment/scripts.txt", "c");
fwrite($file, "");
fclose($file);

// # set up listener as systemd

copy("./deploymentListener.php", "/usr/local/deployment");

shell_exec("sudo bash setupDeploymentListener.bash");






?>
