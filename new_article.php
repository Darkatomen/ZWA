<?php
    include("_users.php");
    include("_articles.php");

    session_start();
    
    $latestArticle = getLatestArticle();

    $user = isset($_SESSION["userId"]) ? getUserById($_SESSION["userId"], $users) : NULL;

    if (!$user || $user["userRole"] != "admin")
    {
        header("Location: novinky.php");
    }

    // Validate form
    $error_publish = array();
    if (isset($_POST["publish"]))
    {
        // Title
        if (strlen($_POST["title"]) == 0)
        {
            array_push($error_publish, "title");
        }
        //Category
        if ($_POST["category"] == "")
        {
            array_push($error_publish, "category");
        }
        // Summary
        if (strlen($_POST["summary"]) > 1000)
        {
            array_push($error_publish, "summary");
        }
        // Article
        if (strlen($_POST["article"]) == 0)
        {
            array_push($error_publish, "article");
        }
        // Image - must be last, so that we don't save the image unless the upload was OK
        $fileId = false;
        if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0)
        {
            $contentType = mime_content_type($_FILES["image"]["tmp_name"]);
            if ($contentType == "image/jpeg" || $contentType == "image/png")
            {
                if (count($error_publish) == 0) // Only save the image if the article is OK
                {
                    $fileId = uniqid();
                    mkdir("uploads/".$fileId);
                    $filepath = "uploads/".$fileId."/".basename($_FILES["image"]["name"]);
                    move_uploaded_file($_FILES["image"]["tmp_name"], $filepath);
                }
                else
                {
                    array_push($error_publish, "image_reupload");
                }
            }
            else
            {
                array_push($error_publish, "image");
            }
        }

        // Upload the article
        if (count($error_publish) == 0)
        {
            $articleId = uniqid();
            $url = "article.php?id=".$articleId;
            $article = array(
                "id" => $articleId,
                "title" => $_POST["title"],
                "summary" => $_POST["summary"],
                "article" => $_POST["article"],
                "url" => $url,
                "image" => $fileId ? $filepath : "",
                "image_description" => $_POST["image_description"],
                "category" => $_POST["category"],
                "authorId" => $user["id"],
                "timestamp_created" => time()
            );
            uploadNewArticle($article);
            header("Location: ".$url);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- TITLE AND LOGO -->
    <title>ZWA News</title>
    <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
    <!-- CSS -->
    <link rel="stylesheet" href="CSS/head.css" media="all"/>
    <link rel="stylesheet" href="CSS/navigation_menu.css" media="all"/>
    <link rel="stylesheet" href="CSS/side_panel.css" media="all"/>
    <link rel="stylesheet" href="CSS/main_page.css" media="all"/>
    <link rel="stylesheet" href="CSS/new_article.css" media="all"/>
    <link rel="stylesheet" href="CSS/print.css" media="print"/>
    <!-- JAVASCRIPT -->
    <script src="JS/new_article.js"></script>
    <script src="JS/latest.js"></script>
</head>
<body>
    <!-- HEAD PANEL -->
    <div id="head">
        <h1><a href="novinky.php">ZWA News</a></h1>
        <h2><?php echo date("l - d.m.Y").", ".(date("W") % 2 == 0 ? "even" : "odd")." week";?></h2>
    </div>
    <!-- NAVIGATION MENU -->
    <nav id="navigation">
        <a href="novinky.php">ZWA News</a>
        <a href="novinky.php?category=home">Home</a>
        <a href="novinky.php?category=abroad">Abroad</a>
        <!-- logout -->
        <div id="user">
            <a class="active" href="new_article.php">New article</a>
            <a href="logout.php"><?php echo htmlspecialchars($user["firstname"]) ?> - Logout</a>
        </div>
    </nav>
    <!-- PANEL WITH LATEST NEWS-->
    <div id="side">
        <div id="latest" class="panel">
        <h2>Latest</h2>
        <?php
            $author = getUserById($latestArticle["authorId"], $users);
            echo "<h3><a href=\"".$latestArticle["url"]."\">".htmlspecialchars($latestArticle["title"])."</a></h3>";
            echo "<p class=\"author\">".date("d.m.Y, H:i e", $latestArticle["timestamp_created"]);
            echo " - ".htmlspecialchars($author["firstname"])." ".htmlspecialchars($author["lastname"])."</p>";
            echo "<p>".replacePlaceholders(htmlspecialchars(getArticleSummary($latestArticle)))."</p>";
        ?>
        </div>
    </div>
    <!-- NEW ARTICLE -->
    <div class="mainPage">
        <form action="" method="post" enctype="multipart/form-data">
            <h1>New Article</h1>
            <!-- TITLE -->
            <label>
                <h2 class="required">Title:</h2>
                <input id="title" type="text" required name="title" placeholder="New title" <?php echo in_array("title", $error_publish) ? "class=\"error_publish\"" : ""; ?> <?php echo isset($_POST["title"]) ? "value=\"".htmlspecialchars($_POST["title"])."\"" : ""; ?>>
            </label>
            <!-- CATEGORY -->
            <label>
                <h2 class="required">Category:</h2>
                <select id="category" required name="category" <?php echo in_array("category", $error_publish) ? "class=\"error_publish\"" : ""; ?>>
                    <option value="">-----------------------</option>
                    <option value="all" <?php echo isset($_POST["category"]) && $_POST["category"] == "all" ? " selected" : ""; ?>>All</option>
                    <option value="home" <?php echo isset($_POST["category"]) && $_POST["category"] == "home" ? " selected" : ""; ?>>Home</option>
                    <option value="abroad" <?php echo isset($_POST["category"]) && $_POST["category"] == "abroad" ? " selected" : ""; ?>>Abroad</option>
                </select>
            </label>
            <!-- IMAGE -->
            <label>
                <h2>Image:</h2>
                <p id="accepted_formats" class="paragraph <?php echo in_array("image", $error_publish) ? " error_text" : ""; ?>">Only jpeg and png files are allowed.</p>
                <?php
                    if (in_array("image_reupload", $error_publish))
                    {
                        echo "<p  class=\"paragraph error_text\">Please reupload the image.</p>";
                    }
                ?>
                <input id="image" type="file" name="image" accept="image/png, image/jpeg">
            </label>
            <label>
                    <h3>Image description</h3>
                    <input type="text" name="image_description" placeholder="E.g. a picture of a cat...">
            </label>
            <!-- SUMMARY -->
            <label>
                <h2>Summary:</h2>
                <p id="max_characters" class="paragraph<?php echo in_array("summary", $error_publish) ? " error_text" : ""; ?>">Maximum 1000 characters</p>
                <textarea id="summary" name="summary" cols="30" rows="10" <?php echo in_array("summary", $error_publish) ? " class=\"error_publish\"" : ""; ?>><?php echo isset($_POST["summary"]) ? htmlspecialchars($_POST["summary"]) : ""; ?></textarea>
            </label>
            <!-- ARTICLE -->
            <label>
                <h2 class="required">Article:</h2>
                <textarea id="article" name="article" required cols="30" rows="10" <?php echo in_array("article", $error_publish) ? "class=\"error_publish\"" : ""; ?>><?php echo isset($_POST["article"]) ? htmlspecialchars($_POST["article"]) : ""; ?></textarea>
            </label>
            <input id="publish" type="submit" value="Publish" name="publish">
        </form>
    </div>
</body>
</html>