// Initializes JS - adds event listeners
function init()
{
    var form = document.querySelector("body div.mainPage form");
    form.addEventListener("submit", validate);
}

// Sets / removes error class to / from the element
function markBoxAsError(element, add = true, scrollToTop = true)
{
    if (add)
    {
        element.classList.add("error_publish");
        if (scrollToTop)
        {
            window.scrollTo(0,0);
        }
    }
    else
    {
        element.classList.remove("error_publish");
    }
}

// Sets / removes error class to / from the element
function markTextBoxAsError(element, add = true, scrollToTop = true)
{
    if (add)
    {
        element.classList.add("error_text");
        if (scrollToTop)
        {
            window.scrollTo(0,0);
        }
    }
    else
    {
        element.classList.remove("error_text");
    }
}

// Gets the file extension
function getFileExtension(path)
{
    return path.lastIndexOf(".") > 0 ? path.split(".").pop() : "";
}

// Checks if all the compulsory fields are filled etc.
function validate(e)
{
    var error_count = 0;

    var title = document.querySelector("body div.mainPage label input#title");
    var category = document.querySelector("body div.mainPage label select#category");
    var image = document.querySelector("body div.mainPage label input#image");
    var summary = document.querySelector("body div.mainPage label textarea#summary");
    var article = document.querySelector("body div.mainPage label textarea#article");

    // Check if title is filled
    if (title.value.length == 0)
    {
        error_count++;
        e.preventDefault();
        markBoxAsError(title);
    }
    else
    {
        markBoxAsError(title, false);
    }

    // Check if category is selected
    if (category.value == "")
    {
        error_count++;
        e.preventDefault();
        markBoxAsError(category);
    }
    else
    {
        markBoxAsError(category, false);
    }

    // Check if image has correct extension
    var accepted_formats = document.querySelector("body div.mainPage form label p#accepted_formats");
    var fileExtension = getFileExtension(image.value);
    if (image.value != "" && fileExtension != "png" && fileExtension != "pjp" && fileExtension != "jpg" && 
        fileExtension != "pjpeg" && fileExtension != "jpeg" && fileExtension != "jfif")
    {
        error_count++;
        e.preventDefault();
        markBoxAsError(image);
        markTextBoxAsError(accepted_formats);
    }
    else
    {
        markBoxAsError(image, false);
        markTextBoxAsError(accepted_formats, false);
    }

    // Check summary length
    var max_characters = document.querySelector("body div.mainPage form label p#max_characters");
    if (summary.value.length > 1000)
    {
        error_count++;
        e.preventDefault();
        markBoxAsError(summary);
        markTextBoxAsError(max_characters);
    }
    else
    {
        markBoxAsError(summary, false);
        markTextBoxAsError(max_characters, false);
    }

    // Check if the article is filled
    if (article.value == "")
    {
        error_count++;
        e.preventDefault();
        markBoxAsError(article, true, false);
    }
    else
    {
        markBoxAsError(article, false);
    }

    // If no error has occured, ask for confirmation to publish the article
    if (error_count == 0 && !confirm("Are you sure you want to publish this article?"))
    {
        e.preventDefault();
    }
}