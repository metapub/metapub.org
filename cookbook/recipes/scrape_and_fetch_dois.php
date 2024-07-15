<article class="recipe">
    <h2>Scrape Citations and Fetch DOIs</h2>
    <p>This recipe demonstrates how to scrape a webpage that has citations in the form of a title and an author, but you don't have all of their DOIs.  We'll scrape metapub.org/citations and use beautifulsoup to break apart the HTML, just for the purposes of demonstrating here, but you'll have to replace with your own scraping function.</p>
    <p>This recipes also demonstrates the complementary functions of PubMedFetcher and CrossRefFetcher and how to navigate their usage discrepancies -- for example, the fact that you want "year" from PubMedArticle but "pubdate" from a CrossRefWork.  <i>(This is a potential avenue of API improvement for metapub...)</i></p>
    <pre>

import requests
from bs4 import BeautifulSoup
from metapub import PubMedFetcher, CrossRefFetcher

# Function to scrape citations from the webpage
def scrape_citations(url):
    response = requests.get(url)
    soup = BeautifulSoup(response.text, 'html.parser')

    citations = soup.find_all('article', class_='citation')
    citation_data = []

    for citation in citations:
        title = citation.find('a').get_text()
        authors = citation.find_all('p')[1].get_text().replace('Authors: ', '')
        doi_element = citation.find('a', href=lambda href: href and 'doi.org' in href)
        doi = doi_element.get_text() if doi_element else None
        citation_data.append({'title': title, 'authors': authors, 'doi': doi, 'year': None, 'journal': None})

    return citation_data

# Function to check DOI using PubMedFetcher
def check_Pubmed(citation):
    fetch = PubMedFetcher()
    query = f"{citation['title']} {citation['authors']}"
    pmids = fetch.pmids_for_query(query)

    for pmid in pmids:
        article = fetch.article_by_pmid(pmid)
        if article and citation['title'].lower() in article.title.lower():
            year = article.year
            journal = article.journal
            doi = article.doi if article.doi else None
            return doi, year, journal
    return None, None, None

# Function to check DOI using CrossRefFetcher
def check_CrossRef(citation):
    cr = CrossRefFetcher()
    results = cr.article_by_title(citation['title'])

    if not results:
        return None, None, None

    # If results is not a list, assume it's the correct result
    if not isinstance(results, list):
        return results.doi if results.doi else None, results.year, results.journal

    # If results is a list, check each result for a match
    for result in results:
        if result.title and citation['title'].lower() == result.title.lower() and citation['authors'].split(",")[0].lower() in [author['family'].lower() for author in result.authors]:
            return result.doi if result.doi else None, result.year, result.journal
    return None, None, None

# Function to get DOI using both PubMedFetcher and CrossRefFetcher
def get_doi(citation):
    doi, year, journal = check_Pubmed(citation)

    if not doi:
        doi, crossref_year, crossref_journal = check_CrossRef(citation)
        if doi:
            year = year if year else crossref_year
            journal = journal if journal else crossref_journal

    return doi, year, journal

# Main script
def main():
    url = 'https://metapub.org/citations/'
    citations = scrape_citations(url)

    for citation in citations:
        if not citation['doi']:
            doi, year, journal = get_doi(citation)
            citation['doi'] = doi if doi else 'DOI not found'
            citation['year'] = year if year else 'Year not found'
            citation['journal'] = journal if journal else 'Journal not found'

        print(f"Citation: {citation['title']}")
        print(f"Authors: {citation['authors']}")
        print(f"DOI: {citation['doi']}")
        print(f"Year: {citation['year']}")
        print(f"Journal: {citation['journal']}\n")

if __name__ == "__main__":
    main()
</code>
</pre>
</article>

