#!/usr/bin/php
<?php
require_once('/usr/local/deployment/path.inc');
require_once('/usr/local/deployment/deploymentRabbit.inc');



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

 function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir);
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
           rrmdir($dir. DIRECTORY_SEPARATOR .$object);
         else
           unlink($dir. DIRECTORY_SEPARATOR .$object); 
       } 
     }
     rmdir($dir); 
   } 
 }

function processCreate($packageName, $version, $lastUpdate)
{
    $packageFilename = $packageName."_".$version.".tar.gz";

    echo "CREATE:".PHP_EOL.$packageName.PHP_EOL.$version.PHP_EOL;
    //COPY all tracked files to usr/local/deployment/temp
    mkdir("/usr/local/deployment/temp");
    
    copy("/usr/local/deployment/tracked.txt", "/usr/local/deployment/temp/tracked.txt");
    copy("/usr/local/deployment/services.txt", "/usr/local/deployment/temp/services.txt");
    copy("/usr/local/deployment/scripts.txt", "/usr/local/deployment/temp/scripts.txt");
    
    
    //start with tracked, move all files into temp folder
    $file = @fopen("/usr/local/deployment/tracked.txt", "r");
    
    if($file)
    {
        while(($buffer = fgets($file, 4096)) !== false)
        {
        
            $buffer = trim(preg_replace('/\s\s+/', '', $buffer));
            $fileName = basename($buffer);
            
            if(is_dir($buffer))
            {
                copy_dir($buffer, "/usr/local/deployment/temp/".$fileName);
            }
            else
            {
                copy($buffer, "/usr/local/deployment/temp/".$fileName);
            }
        }
    }
    else
    {
        echo "File could not be opened, ask Eric what the problem is";
        return array("success" => false);
    }
    
    //tarbal all files into archive
    $phar = new PharData("/usr/local/deployment/".$packageFilename);
    $phar->buildFromDirectory("/usr/local/deployment/temp");
    
    //scp them to var/deployment/packages
    if(is_file("/usr/local/deployment/".$packageFilename))
    {
        $connection = ssh2_connect("192.168.194.81");
        ssh2_auth_password($connection, "deployment", "deployment12345");

        ssh2_scp_send($connection, '/usr/local/deployment/'.$packageFilename, '/usr/local/packages/'.$packageFilename,);
        
        echo "/usr/local/deployment/".$packageFilename.PHP_EOL;
        echo "/var/packages/".$packageFilename.PHP_EOL;

    }
    else
    {
        echo "File did not zip properly for sending to deployment server".PHP_EOL;
        return array("success" => false);
    }
    
    //delete temp folder
    //send success to deployment script
    
    rrmdir("/usr/local/deployment/temp/");
    
    
    
    
    
    return array("success" => true);
}

function processInstall($packageName, $version, $path)
{

    $packageFilename = basename($path);

    echo "INSTALL:".PHP_EOL.$packageName.PHP_EOL.$version.PHP_EOL;
    //COPY all tracked files to usr/local/deployment/temp
    mkdir("/usr/local/deployment/temp");
    
    
    //tarbal all files into archive
    //$phar = new PharData("/usr/local/deployment/".$packageFilename);
    //$phar->buildFromDirectory("/usr/local/deployment/temp");
    

    $connection = ssh2_connect("192.168.194.81");
    ssh2_auth_password($connection, "deployment", "deployment12345");
    
    if(!is_dir("/usr/local/deployment/installs"))
    {
        mkdir("/usr/local/deployment/installs");
    }

    ssh2_scp_recv($connection, $path, '/usr/local/deployment/installs/'.$packageFilename);
        
    echo "/usr/local/deployment/".$packageFilename.PHP_EOL;
    echo "/var/packages/".$packageFilename.PHP_EOL;

    
    //delete temp folder
    //send success to deployment script
    
    if(!is_dir("/usr/local/deployment/temp/"))
    {
        mkdir("/usr/local/deployment/temp/");
    }

    
    $phar = new PharData('/usr/local/deployment/installs/'.$packageFilename);
    $phar->extractTo("/usr/local/deployment/temp");
    

    
    //do the reverse of literally everything to move files to the right spots
    
    //first copy all files to new locations
    
    $file = @fopen("/usr/local/deployment/temp/tracked.txt", "r");
    
    if($file)
    {
        while(($buffer = fgets($file, 4096)) !== false)
        {
        
            $buffer = trim(preg_replace('/\s\s+/', '', $buffer));
            $fileName = basename($buffer);
            
            if(is_dir($buffer))
            {
                copy_dir("/usr/local/deployment/temp/".$fileName, $buffer);
            }
            else
            {
                copy("/usr/local/deployment/temp/".$fileName, $buffer);
            }
        }
    }
    
    
    $file = @fopen("/usr/local/deployment/temp/scripts.txt", "r");
    
    if($file)
    {
        while(($buffer = fgets($file, 4096)) !== false)
        {
        
            $buffer = trim(preg_replace('/\s\s+/', '', $buffer));
            $fileName = basename($buffer);
            
            if(is_file($buffer))
            {
                $path_parts = pathinfo($buffer);
                if($path_parts == "bash")
                {
                    shell_exec("bash ".$buffer);
                }
                else
                {
                    shell_exec("./".$buffer);
                }
                
                echo "Running script ".$buffer.PHP_EOL;
            }

        }
    }
    
    $file = @fopen("/usr/local/deployment/temp/services.txt", "r");
    
    if($file)
    {
        while(($buffer = fgets($file, 4096)) !== false)
        {
        
            $buffer = trim(preg_replace('/\s\s+/', '', $buffer));
            
            shell_exec("sudo systemctl restart ".$buffer);
            
            echo "Restarting service ".$buffer.PHP_EOL;

        }
    }
    
    
    rrmdir("/usr/local/deployment/temp/");
    
    return array("success" => true);
}

function processRollback($packageName, $version)
{
    echo "ROLLBACK:".PHP_EOL.$packageName.PHP_EOL.$version.PHP_EOL;
}



function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "create":
      return processCreate($request['packageName'],$request['version']);
    case "rollback":
      return processRollback($request['packageName'],$request['version']);
    case "install":
      return processInstall($request['packageName'],$request['version'], $request['path']);
  }
  
  return array("returnCode" => '0', 'message'=>"request type not found");
}

$server = new deploymentListener("deploymentConn.ini","deploymentServer");

//$foundDB = true;




echo "Started deployment listener".PHP_EOL;

$server->process_requests('requestProcessor');

?>
