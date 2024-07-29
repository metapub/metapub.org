<article class="recipe">
    <h2>Retrieve Article Metadata (including Abstract) by PubMed ID</h2>
    <p>MetaPub's PubMedFetcher retrieves ALL of the metadata included with the PubMedArticle object as per the Entrez XML definition.</p>
    <p>That means you have instant access to all of the following information (and more) with a single request per article:</p>
    <ul><li>Title</li>
        <li>First author, last author, list of authors</li>
        <li>Abstract</li>
        <li>MESH tags</li>
        <li>Keywords</li>
        <li>Year of publication</li>
        <li>Journal</li>
        <li><i>...and everything else PubMed contains for the given pubmed ID</i></li>
    </ul>
    <p>This recipe demonstrates how you could rebuild the PubMed page for yourself using all of the features of the PubMedArticle object.  (Page formatting is left as an exercise to the reader.)</p>
    <pre>
<code>
import argparse
from metapub import PubMedFetcher

def fetch_article_metadata(pmid):
    # Initialize the PubMedFetcher
    fetch = PubMedFetcher()

    # Retrieve the article using the PubMed ID
    article = fetch.article_by_pmid(pmid)

    # Extract and format metadata
    first_author = str(article.author_list[0]) if article.author_list else "N/A"
    last_author = str(article.author_list[-1]) if article.author_list else "N/A"
    authors = ', '.join([str(author) for author in article.author_list]) if article.author_list else "N/A"
    mesh_tags = ', '.join(article.mesh) if article.mesh else 'N/A'
    keywords = ', '.join(article.keywords) if article.keywords else 'N/A'

    # Print metadata
    print(f"Title: {article.title}")
    print(f"First Author: {first_author}")
    print(f"Last Author: {last_author}")
    print(f"Authors: {authors}")
    print(f"Abstract: {article.abstract}")
    print(f"MESH Tags: {mesh_tags}")
    print(f"Keywords: {keywords}")
    print(f"Year of Publication: {article.year}")
    print(f"Journal: {article.journal}")

def main():
    parser = argparse.ArgumentParser(description='Fetch and display metadata for a given PubMed ID.')
    parser.add_argument('pmid', type=str, nargs='?', help='PubMed ID of the article to fetch')
    args = parser.parse_args()

    if not args.pmid:
        args.pmid = input("Please enter a PubMed ID: ")

    fetch_article_metadata(args.pmid)

if __name__ == "__main__":
    main()
</code>
</pre>
</article>

