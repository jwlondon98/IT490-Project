using System;
using System.IO;
using System.Diagnostics;
using System.Threading.Tasks;

public static class DBCommunicator
{
    public static int requestCount = -1;
    public static string rootPath = "";

    private static string GetPath()
    {
        string path = Path.GetDirectoryName(Process.GetCurrentProcess().MainModule.FileName);
        string dirName = "IT490-Project";
        int dirIndex = path.IndexOf(dirName);

        string retStr = path.Substring(0, dirIndex + dirName.Length) + "/";
        return retStr;
    }

    private static string GetPHPExePath()
    {
        string path = GetPath() + "phpExePath.txt";
        FileStream fStream = File.OpenRead(path);
        StreamReader reader = new StreamReader(fStream);
        return reader.ReadLine();
    }

    private static string GetDBCommPath()
    {
        return GetPath() + "DatabaseCommunicator.php";
    }

    private static Process RunPHP(string args)
    {
        string phpExePath =  GetPHPExePath();
        string dbCommPath =  GetDBCommPath();

        // string linCmd = "gnome-terminal -x bash -ic 'cd $HOME; ls; bash'";
        // string command = phpExePath + " " + dbCommPath + " " + args;
        string command = "php " + dbCommPath + " " + args;
        ProcessStartInfo info = new ProcessStartInfo("/usr/bin/bash");// -x bash -c '" + command + "; exec bash'");
        info.RedirectStandardOutput = true;
        info.RedirectStandardInput = true;
        info.UseShellExecute = false;
        Process process = new Process();
        process.StartInfo = info;
        bool started = process.Start();

        Console.WriteLine("STARTED " + (process != null) + ": " + started);

        process.StandardInput.WriteLine(command);
        process.StandardInput.Flush();
        process.StandardInput.Close();

        Console.WriteLine(process.StandardOutput.ReadToEnd());

        process.WaitForExit();

        return process;
    }

    private static void LogRequest(string requestType, string argStr)
    {
        Console.WriteLine("\n[DBComm] Making Request of type: " + requestType);
        Console.WriteLine("[DBComm] Request Args: " + argStr + "\n");
    }

    private static string BuildArgs(string[] args)
    {
        string retStr = "";
        for (int i = 0; i < args.Length; i++)
            retStr += " " + args[i];
        return retStr;
    }

    public static Response Request(string requestType, string[] args)
    {
        string builtArgs = BuildArgs(args);
        LogRequest(requestType, builtArgs);

        int requestIndex = requestCount++;
        Process process = RunPHP(requestType + " " + requestIndex + builtArgs);
        
        return new Response(process, requestIndex);
    }
}