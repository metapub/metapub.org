<article class="recipe">
    <h2>Find Open Access Articles from a Specific Journal and Year</h2>
    <p>This recipe helps you learn how many articles from a given year and journal can be retrieved as open-access articles. It uses the FindIt engine to construct valid PDF links for each PMID to check if articles are available as open access.</p>
    <pre>
<code>
import requests
from metapub import PubMedFetcher
from metapub import FindIt

def find_open_access_articles(journal, year):
    fetch = PubMedFetcher()
    pmids = fetch.pmids_for_query(f"{journal}[journal] AND {year}[pdat]")
    open_access_pmids = []

    for pmid in pmids:
        src = FindIt(pmid, verify=True)
        if src.url:
            print(pmid, "available at ", src.url)
            open_access_pmids.append(pmid)
        else:
            print(pmid, "not available: ", src.reason)

    return open_access_pmids

# Example usage
journal = "cell"
year = 2023
open_access_articles = find_open_access_articles(journal, year)

print("Found", len(open_access_articles), "open access in journal", journal, "for year", year)
</code>
</pre>
</article>

