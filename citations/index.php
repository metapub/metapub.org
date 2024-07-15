<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metapub Citations</title>
    <link rel="stylesheet" href="/styles/common.css">
    <link rel="stylesheet" href="/styles/navbar.css">
    <link rel="stylesheet" href="/styles/citations.css">
    <link rel="stylesheet" href="/styles/footer.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- Navbar -->
    <?php include '../partials/navbar.html'; ?>

    <main>
        <div class="container">
            <section class="citations">
                <h1>Metapub Citations</h1>
                <p><i>Research citing metapub in PubMed journals, posters, and beyond.</i></p>
		<hr />

                <?php
                // Define the directory containing the citation partials
                $dir = 'citations/';

                // Initialize an array to hold the partial file names and their first author's last name
                $partials = [];

                // Open the directory
                if ($handle = opendir($dir)) {
                    // Read each file in the directory
                    while (false !== ($entry = readdir($handle))) {
                        // Skip '.' and '..'
                        if ($entry != "." && $entry != "..") {
                            // Read the content of the file
                            $content = file_get_contents($dir . $entry);

                            // Extract the first author's last name using regex
                            if (preg_match('/<p><strong>Authors:<\/strong> ([^,]+),/', $content, $matches)) {
                                $lastName = $matches[1];
                                // Add the file to the array with the last name
                                $partials[] = ['file' => $entry, 'lastName' => $lastName];
                            }
                        }
                    }
                    // Close the directory handle
                    closedir($handle);
                }

                // Sort the partials by the first author's last name
                usort($partials, function($a, $b) {
                    return strcmp($a['lastName'], $b['lastName']);
                });

                // Include each partial file in the sorted order
                foreach ($partials as $partial) {
                    include $dir . $partial['file'];
                    echo "<hr>";
                }
                ?>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <?php include '../partials/footer.html'; ?>
</body>
</html>

