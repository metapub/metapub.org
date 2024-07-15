<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metapub</title>
    <link rel="stylesheet" href="/styles/common.css">
    <link rel="stylesheet" href="/styles/navbar.css">
    <link rel="stylesheet" href="/styles/hero.css">
    <link rel="stylesheet" href="/styles/features.css">
    <link rel="stylesheet" href="/styles/sidebar.css">
    <link rel="stylesheet" href="/styles/footer.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- Navbar -->
    <?php include 'partials/navbar.html'; ?>

    <main>
        <!-- Hero Section -->
        <?php include 'partials/hero.html'; ?>

        <div class="main-container">
            <!-- Features Section -->
            <?php include 'partials/features.html'; ?>

            <!-- Sidebar -->
            <?php include 'partials/sidebar.html'; ?>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'partials/footer.html'; ?>
</body>
</html>

