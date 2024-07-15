<article class="recipe">
    <h2>Retrieve Article Metadata by PubMed ID</h2>
    <pre>
<code>
from metapub import PubMedFetcher

def get_article_metadata(pmid):
    fetch = PubMedFetcher()
    article = fetch.article_by_pmid(pmid)
    
    metadata = {
        'title': article.title,
        'authors': article.authors,
        'journal': article.journal,
        'year': article.year,
        'doi': article.doi
    }
    
    return metadata

# Example usage
pmid = "12345678"
metadata = get_article_metadata(pmid)
print(metadata)
</code>
</pre>
</article>

