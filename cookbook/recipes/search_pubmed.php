<article class="recipe">
    <h2>Search PubMed by Keyword</h2>
    <pre>
<code>
from metapub import PubMedFetcher

def search_pubmed(keyword):
    fetch = PubMedFetcher()
    pmids = fetch.pmids_for_query(keyword)
    
    articles = []
    for pmid in pmids:
        article = fetch.article_by_pmid(pmid)
        articles.append({
            'title': article.title,
            'authors': article.authors,
            'journal': article.journal,
            'year': article.year,
            'doi': article.doi
        })
    
    return articles

# Example usage
keyword = "COVID-19"
articles = search_pubmed(keyword)
for article in articles:
    print(article)
</code>
</pre>
</article>

