<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metapub Overview</title>
    <link rel="stylesheet" href="/styles/common.css">
</head>
<body>
    <?php include('../partials/navbar.html'); ?>

    <div class="container">
        <h1>Overview</h1>
        
        <h2>Metapub: A Comprehensive Python Library for PubMed Data Retrieval and Manipulation</h2>
        <p><strong>Metapub</strong> is a powerful Python library designed for researchers and developers who need to interact with PubMed, the leading database for biomedical literature. Whether you're conducting large-scale literature reviews, managing bibliographic data, or developing applications that require seamless access to PubMed resources, metapub offers a robust set of tools to streamline your workflow.</p>

        <h3>Key Features</h3>
        <ul>
            <li>
                <strong>Efficient Data Retrieval:</strong> 
                Metapub provides a simple yet efficient way to query PubMed and retrieve metadata for scientific articles. With its intuitive API, you can easily search for articles using various parameters such as keywords, author names, journal titles, and publication dates.
            </li>
            <li>
                <strong>DOI and PMID Handling:</strong>
                The library supports extensive functionalities for handling Digital Object Identifiers (DOIs) and PubMed Identifiers (PMIDs). It includes methods to convert between these identifiers, ensuring you can easily cross-reference and manage your bibliographic data.
            </li>
            <li>
                <strong>Robust Metadata Extraction:</strong>
                Extract detailed metadata from PubMed articles, including titles, abstracts, authors, affiliations, journal information, publication types, and more. This is particularly useful for researchers conducting systematic reviews or meta-analyses.
            </li>
            <li>
                <strong>NCBI API Integration:</strong>
                Metapub integrates seamlessly with the NCBI Entrez Programming Utilities (E-utilities), allowing for efficient and reliable access to the vast PubMed database. The library includes built-in rate limiting and error handling to ensure smooth operation even with extensive queries.
            </li>
            <li>
                <strong>Journal Coverage Insights:</strong>
                The library includes tools to analyze journal coverage, helping you understand the extent of indexing for specific journals in PubMed. This feature is invaluable for researchers aiming to assess the visibility and impact of their work within the biomedical literature landscape.
            </li>
            <li>
                <strong>Extensible and Customizable:</strong>
                Designed with developers in mind, metapub is highly extensible and customizable. You can easily extend its functionalities or integrate it with other tools and libraries in your research workflow.
            </li>
        </ul>

        <h3>Getting Started</h3>
        <p><strong>Installation:</strong></p>
        <pre><code>pip install metapub</code></pre>
        
        <p><strong>Basic Usage:</strong></p>
        <pre><code>from metapub import PubMedFetcher

fetch = PubMedFetcher()
article = fetch.article_by_pmid('29732299')
print(article.title)
print(article.abstract)
</code></pre>

        <p><strong>Documentation and Community:</strong> Comprehensive documentation is available to guide you through advanced features and use cases. Additionally, join the growing community of metapub users and contributors on GitHub to collaborate, share insights, and stay updated with the latest developments.</p>

        <h3>Why Choose Metapub?</h3>
        <ul>
            <li><strong>Reliability:</strong> Built on top of the well-established NCBI E-utilities, metapub ensures reliable access to PubMed data.</li>
            <li><strong>Performance:</strong> Efficient data retrieval and processing capabilities to handle large-scale bibliographic datasets.</li>
            <li><strong>Flexibility:</strong> Suitable for a wide range of applications, from academic research to software development projects.</li>
        </ul>

        <p>By integrating metapub into your workflow, you can significantly enhance your ability to manage and analyze biomedical literature, saving time and effort while gaining deeper insights into your research domain.</p>

        <p>Feel free to explore metapub's capabilities and consider contributing to its development to help advance the biomedical research community!</p>
    </div>

    <?php include('../partials/footer.html'); ?>
</body>
</html>

