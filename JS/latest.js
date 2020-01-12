window.addEventListener("load", init);

// Initializes JS - adds event listeners
function init()
{
    latest = document.querySelector("body div#side div#latest");
    window.setInterval(setLatestNews, 10000);
}

function setLatestNews()
{
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "latest.php");
    xhr.responseType = "text";
    xhr.onload = function () 
    {
        latest.innerHTML = xhr.response;
    };
    xhr.send();
}