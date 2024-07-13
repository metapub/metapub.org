import streamlit as st
import os
import requests
from metapub import PubMedFetcher

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
            "Full Text URL": article.url
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
if 'query' in st.session_state:
    total_count = get_total_count(st.session_state.query, api_key=os.environ.get("NCBI_API_KEY"))
    articles = search_pubmed_advanced(st.session_state.query, st.session_state.page)
    
    st.markdown(f"**Total number of results: {total_count}**")
    st.success(f"Showing page {st.session_state.page + 1} with {len(articles)} articles")

    for i, article in enumerate(articles, 1 + st.session_state.page * 10):
        author_url = f"https://pubmed.ncbi.nlm.nih.gov/?term={article['First Author'].replace(' ', '%20')}"
        st.write(f"### {i}. {article['Title']}")
        st.markdown(f"**First Author:** [{article['First Author']}]({author_url})")
        st.markdown(f"**PubMed ID:** [{article['PubMed ID']}](https://pubmed.ncbi.nlm.nih.gov/{article['PubMed ID']}/)")
        if article['DOI']:
            st.markdown(f"**DOI:** [{article['DOI']}](https://doi.org/{article['DOI']})")
        if article['Full Text URL']:
            st.markdown(f"**Full Text URL:** [Link]({article['Full Text URL']})")

    col1, col2, col3 = st.columns(3)
    if st.session_state.page > 0:
        if col1.button("Previous"):
            st.session_state.page -= 1
    if (st.session_state.page + 1) * 10 < total_count:
        if col3.button("Next"):
            st.session_state.page += 1

st.sidebar.markdown("---")
st.sidebar.markdown("Created with [Streamlit](https://streamlit.io) and [metapub](https://github.com/metapub/metapub).")

