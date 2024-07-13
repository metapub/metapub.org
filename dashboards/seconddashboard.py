import streamlit as st
import requests
from metapub import PubMedFetcher

# Initialize PubMed fetcher
fetcher = PubMedFetcher()

def fetch_article_details(pmid):
    article = fetcher.article_by_pmid(pmid)
    return {
        "Title": article.title,
        "Authors": ", ".join(article.authors),
        "Journal": article.journal,
        "Publication Year": article.year,
        "Abstract": article.abstract
    }

def search_pubmed(keyword):
    pmids = fetcher.pmids_for_query(keyword)
    articles = []
    for pmid in pmids[:10]:  # Limit to first 10 results
        article = fetcher.article_by_pmid(pmid)
        citation = f"{', '.join(article.authors)}. ({article.year}). {article.title}. {article.journal}."
        articles.append(citation)
    return pmids, articles

def get_total_count(keyword):
    base_url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi"
    params = {
        "db": "pubmed",
        "term": keyword,
        "retmode": "json",
        "retmax": 0
    }
    response = requests.get(base_url, params=params)
    data = response.json()
    return int(data["esearchresult"]["count"])

# Streamlit App
st.title("PubMed Article Fetcher")
st.sidebar.header("Search Controls")

# Sidebar controls
pmid = st.sidebar.text_input("Enter PubMed ID (PMID)", "")
keyword = st.sidebar.text_input("Enter keyword to search PubMed", "")

if st.sidebar.button("Fetch Article"):
    if pmid:
        with st.spinner("Fetching article details..."):
            try:
                details = fetch_article_details(pmid)
                st.success("Article details fetched successfully!")
                for key, value in details.items():
                    st.subheader(key)
                    st.write(value)
            except Exception as e:
                st.error(f"An error occurred: {e}")
    else:
        st.warning("Please enter a PubMed ID.")

if st.sidebar.button("Search PubMed"):
    if keyword:
        with st.spinner("Searching PubMed..."):
            try:
                total_count = get_total_count(keyword)
                pmids, articles = search_pubmed(keyword)
                st.markdown(f"**Total number of results: {total_count}**")
                st.success(f"Found {len(articles)} articles for keyword '{keyword}'")
                for i, article in enumerate(articles, 1):
                    st.write(f"{i}. {article}")
            except Exception as e:
                st.error(f"An error occurred: {e}")
    else:
        st.warning("Please enter a keyword.")

st.sidebar.markdown("---")
st.sidebar.markdown("Created with [Streamlit](https://streamlit.io) and [metapub](https://github.com/metapub/metapub).")

