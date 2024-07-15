<article class="recipe">
    <h2>Analyze Citations from Article Metadata</h2>
    <pre>
<code>
from metapub import PubMedFetcher

def analyze_citations(pmid):
    fetch = PubMedFetcher()
    article = fetch.article_by_pmid(pmid)
    
    citations = article.citations
    citation_data = []
    
    for citation in citations:
        citation_data.append({
            'title': citation.title,
            'authors': citation.authors,
            'journal': citation.journal,
            'year': citation.year,
            'doi': citation.doi
        })
    
    return citation_data

# Example usage
pmid = "12345678"
citations = analyze_citations(pmid)
for citation in citations:
    print(citation)
</code>
</pre>
</article>

