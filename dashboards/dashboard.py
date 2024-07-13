import requests
import streamlit as st
import os
from metapub import PubMedFetcher
from metapub import FindIt

# Initialize PubMed fetcher
fetcher = PubMedFetcher()

# State variables for pagination
if 'page' not in st.session_state:
    st.session_state.page = 0

def search_pubmed_advanced(query, page, retmax=10):
    pmids = fetcher.pmids_for_query(query, retstart=page*retmax, retmax=retmax)
    articles = []
    for pmid in pmids:
        article = fetcher.article_by_pmid(pmid)
        articles.append({
            "First Author": article.authors[0] if article.authors else "N/A",
            "Title": article.title,
            "PubMed ID": article.pmid,
            "DOI": article.doi,
            "Full Text URL": article.url or article.findit(),
            "Journal": article.journal,
            "Year": article.year
        })
    return articles

def get_total_count(query, api_key=None):
    base_url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi"
    params = {
        "db": "pubmed",
        "term": query,
        "retmode": "json",
        "retmax": 0,
        "api_key": api_key
    }
    response = requests.get(base_url, params=params)
    data = response.json()
    return int(data["esearchresult"]["count"])

# Streamlit App
st.title("PubMed Article Fetcher")
st.sidebar.header("Advanced Search Controls")

# Sidebar controls for advanced search
first_author = st.sidebar.text_input("First Author")
title = st.sidebar.text_input("Title")
journal = st.sidebar.text_input("Journal")
year = st.sidebar.text_input("Publication Year")
keyword = st.sidebar.text_input("Keyword")

# Handling NCBI API Key
if not os.environ.get("NCBI_API_KEY"):
    api_key = st.sidebar.text_input("Enter NCBI API Key", "")
    if api_key:
        st.sidebar.success("API Key set successfully!")
        os.environ["NCBI_API_KEY"] = api_key
else:
    st.sidebar.write("NCBI_API_KEY set")

# Button to trigger search
if st.sidebar.button("Search PubMed"):
    query = ""
    if first_author:
        query += f"{first_author}[Author] "
    if title:
        query += f"{title}[Title] "
    if journal:
        query += f"{journal}[Journal] "
    if year:
        query += f"{year}[Publication Date] "
    if keyword:
        query += f"{keyword}[All Fields]"

    if query.strip():
        st.session_state.query = query.strip()
        st.session_state.page = 0
    else:
        st.warning("Please enter at least one search criterion.")

# Navigation buttons
def display_navigation_controls(position):
    col1, col2, col3 = st.columns(3)
    if st.session_state.page > 0:
        if col1.button("Previous", key=f"previous_{position}"):
            st.session_state.page -= 1
    if (st.session_state.page + 1) * 10 < total_count:
        if col3.button("Next", key=f"next_{position}"):
            st.session_state.page += 1

if 'query' in st.session_state:
    total_count = get_total_count(st.session_state.query, api_key=os.environ.get("NCBI_API_KEY"))
    articles = search_pubmed_advanced(st.session_state.query, st.session_state.page)

    st.markdown(f"**Total number of results: {total_count}**")
    st.success(f"Showing page {st.session_state.page + 1} with {len(articles)} articles")

    display_navigation_controls("top")

    if articles:
        st.write("### Search Results")
        header_cols = st.columns([1, 2, 2, 1, 1, 1, 1])
        headers = ["First Author", "Title", "Journal", "Year", "PubMed ID", "DOI", "Full Text"]
        for col, header in zip(header_cols, headers):
            col.write(f"**{header}**")

        for article in articles:
            src = FindIt(article['PubMed ID'])

            cols = st.columns([1, 2, 2, 1, 1, 1, 1])
            cols[0].write(f"[{article['First Author']}](https://pubmed.ncbi.nlm.nih.gov/?term={article['First Author'].replace(' ', '%20')})")
            cols[1].write(f"[{article['Title']}](https://pubmed.ncbi.nlm.nih.gov/{article['PubMed ID']}/)")
            cols[2].write(article['Journal'])
            cols[3].write(article['Year'])
            cols[4].write(f"[{article['PubMed ID']}](https://pubmed.ncbi.nlm.nih.gov/{article['PubMed ID']}/)")
            cols[5].write(f"[{article['DOI']}](https://doi.org/{article['DOI']})" if article['DOI'] else "N/A")
            cols[6].write(f"[Link]({src.url})" if src.url else src.reason)

    display_navigation_controls("bottom")

st.sidebar.markdown("---")
st.sidebar.markdown("Created with [Streamlit](https://streamlit.io) and [metapub](https://github.com/metapub/metapub).")

