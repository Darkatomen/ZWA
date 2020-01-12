// Initializes JS - adds event listeners
function init()
{
    var form = document.querySelector("body div.mainPage form");
    form.addEventListener("submit", validate);
}

// Checks if the username and password are filled
function validate(e)
{
    var username = document.querySelector("body div.mainPage form label input#username");
    var password = document.querySelector("body div.mainPage form label input#password");

    // Check username
    if (username.value.trim().length == 0)
    {
        e.preventDefault();
        username.classList.add("error_textbox");
    }
    else
    {
        username.classList.remove("error_textbox");
    }

    // Check password
    if (password.value.trim().length == 0)
    {
        e.preventDefault();
        password.classList.add("error_textbox");
    }
    else
    {
        password.classList.remove("error_textbox");
    }
}