using System;
using System.Web;
using System.Diagnostics;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System.Net.Http;
using System.Net.Http.Headers;

namespace IT490_Project_Site.Pages
{
    public class PlayModel : PageModel
    {
        public void OnGet()
        {
        }

        public void OnMode1Click()
        {
            Console.WriteLine("hiii");
            SendModeGetRequest("mode1");
        }

        private async void SendModeGetRequest(string modeName)
        {
            HttpClient client = new HttpClient();

            string content = "gameMode=" + modeName;

            string path = $"{this.Request.Scheme}://{this.Request.Host}{this.Request.PathBase}{this.Request.Path}";
            Console.WriteLine("Path: " + path);

            var request = new HttpRequestMessage
            {
                Method = HttpMethod.Get,
                RequestUri = new Uri(path),
                Content = new StringContent(content)
            };

            var response = client.SendAsync(request).ConfigureAwait(false);
            Console.WriteLine("get request sent");

            var responseInfo = response.GetAwaiter().GetResult();
        }
    }
}
