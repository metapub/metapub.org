<?php
// Include Parsedown library
include 'Parsedown.php';

// Function to get list of markdown files
function getMarkdownFiles($dir) {
    $files = [];
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if (pathinfo($file, PATHINFO_EXTENSION) == 'md') {
                    $files[] = $file;
                }
            }
            closedir($dh);
        }
    }
    return $files;
}

// Get list of markdown files
$markdownFiles = getMarkdownFiles(__DIR__);

// Initialize Parsedown
$Parsedown = new Parsedown();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Documentation Index</title>
    <link rel="stylesheet" href="../styles/common.css">
</head>
<body>
    <?php include('../partials/navbar.html'); ?>
    
    <h1>Documentation</h1>
    <ul>
        <?php
        // Generate table of contents
        foreach ($markdownFiles as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            echo '<li><a href="?page=' . $filename . '">' . $filename . '</a></li>';
        }
        ?>
    </ul>
    <div>
        <?php
        // Display selected markdown file
        if (isset($_GET['page'])) {
            $page = $_GET['page'] . '.md';
            if (in_array($page, $markdownFiles)) {
                $content = file_get_contents($page);
                echo $Parsedown->text($content);
            } else {
                echo '<p>Page not found.</p>';
            }
        } else {
            echo '<p>Select a document to read.</p>';
        }
        ?>
    </div>

    <?php include('../partials/footer.html'); ?>
</body>
</html>

