<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metapub Cookbook</title>
    <link rel="stylesheet" href="/styles/common.css">
    <link rel="stylesheet" href="/styles/navbar.css">
    <link rel="stylesheet" href="/styles/cookbook.css">
    <link rel="stylesheet" href="/styles/footer.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- Navbar -->
    <?php include '../partials/navbar.html'; ?>

    <main>
        <div class="container">
            <section class="cookbook">
                <h1>Metapub Cookbook</h1>
                <p>How to do some stuff you might want to do with Metapub.</p>

                <!-- Include recipe partials -->
                <?php
                // Define the directory containing the recipe partials
                $dir = 'recipes/';

                // Open the directory
                if ($handle = opendir($dir)) {
                    // Read each file in the directory
                    while (false !== ($entry = readdir($handle))) {
                        // Skip '.' and '..'
                        if ($entry != "." && $entry != "..") {
                            // Include the recipe file
                            include $dir . $entry;
                            echo "<hr>";
                        }
                    }
                    // Close the directory handle
                    closedir($handle);
                }
                ?>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <?php include '../partials/footer.html'; ?>
</body>
</html>

