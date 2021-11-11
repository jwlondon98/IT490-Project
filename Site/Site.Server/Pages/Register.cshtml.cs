using System;
using System.Diagnostics;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;

namespace IT490_Project_Site.Pages
{
    public class RegisterModel : PageModel
    {
        public void OnGet()
        {

        }

        //public async Task<IActionResult> OnPostRegister(string email, string username, string password)
        //{
        //    Debug.WriteLine("ON POST REGISTER");

        //    //string[] args = { email, username, password };
        //    //Response resp = DBCommunicator.Request("register", args);
        //    //await resp.WaitForResponse();
        //    //string response = resp.response;
        //    //Console.WriteLine("REGISTER RECEIVED RESPONSE: " + response);

        //    return RedirectToPage("DatabaseCommunicator.php");
        //}
    }
}
