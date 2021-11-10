using System;
using System.Configuration;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using System.Data.SqlClient;
using System.Data;

namespace IT490_Project_Site.Pages
{
    public class FriendsModel : PageModel
    {
        public string[] friendRequestNames = { 
          "john", "james", "jack"  
        };

        public string test = "this is a test";

        public void OnGet()
        {
            //Console.WriteLine("GET");
        }

        public void OnPost()
        {
        }

        public async Task<IActionResult> OnPostAddFriend(string friendUsername)
        {
            //DBCommunicator.AddFriend("jwlondon98", friendUsername);

            return RedirectToPage();
        }

        public async Task<IActionResult> OnPostAcceptFriend(string friendUsername)
        {
            return RedirectToPage();
        }
    }
}
