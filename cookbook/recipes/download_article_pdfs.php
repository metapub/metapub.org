<article class="recipe">
    <h2>Download Article PDFs</h2>
<p>If you've generated a long list of research you need to read and don't want to take the time to click an average of 2.5 times per article to download its fulltext, FindIt is for you.  This recipe demonstrates how simple it is to track down every Open Access PDF you might want from your wish list in a small script.</p> 
    <pre>
<code>
from metapub import PubMedFetcher

def download_article_pdfs(pmid_list, download_dir):
    fetch = PubMedFetcher()
    
    for pmid in pmid_list:
        article = fetch.article_by_pmid(pmid)
        pdf_url = article.pdf_url
        
        if pdf_url:
            response = requests.get(pdf_url)
            with open(f"{download_dir}/{pmid}.pdf", 'wb') as f:
                f.write(response.content)
            print(f"Downloaded PDF for PMID {pmid}")
        else:
            print(f"No PDF available for PMID {pmid}")

# Example usage
pmid_list = ["12345678", "23456789"]
download_dir = "/path/to/download"
download_article_pdfs(pmid_list, download_dir)
</code>
</pre>
</article>

