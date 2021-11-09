using Microsoft.AspNetCore.Mvc;
using System;
using System.Web;
using System.Diagnostics;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using System.Net.Http;
using System.Net.Http.Headers;

namespace IT490_Project_Site
{
    public class PlayModeController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }

        public void OnGet()
        {
            Console.WriteLine("testtt");
            SendModeGetRequest("mode1");
        }

        public async void OnMode1Click()
        {
            var client = new HttpClient();
            string path = $"{this.Request.Scheme}://{this.Request.Host}{this.Request.PathBase}{this.Request.Path}";
            Console.WriteLine("PATH: " + path);
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
