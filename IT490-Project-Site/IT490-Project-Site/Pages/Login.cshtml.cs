using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;

namespace IT490_Project_Site.Pages
{
    public class LoginModel : PageModel
    {
        public void OnGet()
        {
        }

        public async Task<IActionResult> OnPostLogin(string username, string password)
        {
            string[] args = { username, password };
            Response resp = DBCommunicator.Request("login", args);
            await resp.WaitForResponse();
            string response = resp.response;
            Console.WriteLine("LOGIN RECEIVED RESPONSE: " + response);

            return RedirectToPage();
        }
    }
}
