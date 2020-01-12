<?php

// Returnes all articles sorted by date descending
function getArticles() :array
{
    $articles = json_decode(file_get_contents("articles.json"), JSON_OBJECT_AS_ARRAY)["articles"];
    $articlesTimestamps = array_column($articles, "timestamp_created");
    array_multisort($articlesTimestamps, SORT_DESC, $articles);
    return $articles;
}

// Returnes articles from the selected category sorted by date descending
function getArticlesByCategory(string $category) :array
{
    $articles = json_decode(file_get_contents("articles.json"), JSON_OBJECT_AS_ARRAY)["articles"];
    $categorisedArticles = array();
    foreach ($articles as $article)
    {
        if ($article["category"] == $category)
        {
            array_push($categorisedArticles, $article);
        }
    }
    $articlesTimestamps = array_column($categorisedArticles, "timestamp_created");
    array_multisort($articlesTimestamps, SORT_DESC, $categorisedArticles);
    return $categorisedArticles;
}

// Returns the latest article
function getLatestArticle() :array
{
    return getArticles()[0];
}

// Saves the article onto the server
function uploadNewArticle(array $article)
{
    $articles = json_decode(file_get_contents("articles.json"), JSON_OBJECT_AS_ARRAY);
    array_push($articles["articles"], $article);
    file_put_contents("articles.json", json_encode($articles));
}

// Get an article by its id
function getArticleById(string $id) :array
{
    $articles = getArticles();
    foreach ($articles as $article)
    {
        if ($article["id"] == $id)
        {
            return $article;
        }
    }

    return array();
}

// Returns the summary of the article
function getArticleSummary(array $article) :string
{
    // If there is no summary, use a piece of the article instead
    if (strlen($article["summary"]) > 0)
    {
        $summary = $article["summary"];
    }
    else
    {
        if (strlen($article["article"]) > 400)
        {
            $summary = substr($article["article"], 0, 397)."...";
        }
        else
        {
            $summary = $article["article"];
        }
    }
    return $summary;
}

// Replaces placeholders in the text with html tags
function replacePlaceholders(string $text)
    {
        $text = str_replace(htmlspecialchars("<tab>"), "&emsp;", $text);
        $text = str_replace(htmlspecialchars("<t>"), "&emsp;", $text);
        $text = str_replace(htmlspecialchars("<br>"), "<br>", $text);
        $text = str_replace(htmlspecialchars("<brr>"), "<br><br>", $text);
        $text = str_replace(htmlspecialchars("<bt>"), "<br>&emsp;", $text);
        $text = str_replace(htmlspecialchars("<brt>"), "<br><br>&emsp;", $text);
        $text = str_replace(htmlspecialchars("<url>"), "<a href=\"", $text);
        $text = str_replace(htmlspecialchars("</url-here>"), "\">here</a>", $text);
        $text = str_replace(htmlspecialchars("</url-this>"), "\">this</a>", $text);
        return $text;
    }

?>