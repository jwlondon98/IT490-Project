using System;
using System.IO;
using System.Diagnostics;
using System.Threading.Tasks;

public class Response 
{
    public Process process { get; private set; }
    public string response { get; private set; }
    public int requestIndex { get; private set; }

    public Response(Process process, int requestIndex)
    {
        this.requestIndex = requestIndex;
    }

    public async Task WaitForResponse()
    {
        if (process == null)
        {
            Console.WriteLine("PROCESS IS NULL");
            return;
        }

        string output = process.StandardOutput.ReadToEnd();
        string initiator = "(RESPONSE-START " + requestIndex + "): ";
        string terminator = "(RESPONSE-END " + requestIndex + ")";

        while (!output.Contains(initiator))
        {
            output = process.StandardOutput.ReadToEnd();
            await Task.Delay(TimeSpan.FromSeconds(1));
        }

        int initIndex = output.IndexOf(initiator);
        int termIndex = output.IndexOf(terminator);
        int start = initIndex + initiator.Length + 1;
        int length = termIndex - start;

        response = output.Substring(start, length);
    }
}