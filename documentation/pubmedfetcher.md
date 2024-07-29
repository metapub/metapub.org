## PubMedFetcher Object Documentation

The `PubMedFetcher` object in the `metapub` library is a tool for interacting with PubMed's vast database of biomedical literature. It provides various methods to search for articles, retrieve metadata, and access full-text content. This documentation covers the available methods, keywords, and advanced query characteristics.

### Initialization

```python
from metapub import PubMedFetcher

fetch = PubMedFetcher()
```

### Methods

#### `__init__(self, method='eutils', **kwargs)`
Initializes the `PubMedFetcher` object with the specified method. Currently, only the 'eutils' method is supported.

**Parameters:**
- `method` (str, optional): The method for querying PubMed. Default is 'eutils'.
- `**kwargs`: Additional keyword arguments, such as `cachedir` for specifying the cache directory.

**Example:**
```python
fetch = PubMedFetcher()
```

#### `article_by_pmid(pmid)`
Fetches an article by its PubMed ID (PMID).

**Parameters:**
- `pmid` (str or int): The PubMed ID of the article.

**Returns:**
- A `PubMedArticle` object containing metadata about the article.

**Example:**
```python
article = fetch.article_by_pmid('12345678')
```

#### `article_by_pmcid(pmcid)`
Fetches an article by its PubMed Central ID (PMCID).

**Parameters:**
- `pmcid` (str or int): The PubMed Central ID of the article.

**Returns:**
- A `PubMedArticle` object containing metadata about the article.

**Example:**
```python
article = fetch.article_by_pmcid('PMC1234567')
```

#### `article_by_doi(doi)`
Fetches an article by its Digital Object Identifier (DOI).

**Parameters:**
- `doi` (str): The DOI of the article.

**Returns:**
- A `PubMedArticle` object containing metadata about the article.

**Example:**
```python
article = fetch.article_by_doi('10.1038/ng.379')
```

#### `pmids_for_query(query='', since=None, until=None, retstart=0, retmax=250, pmc_only=False, **kwargs)`
Returns a list of PMIDs for a given freeform query string and keyword arguments.

**Parameters:**
- `query` (str, optional): The search term. Default is an empty string.
- `since` (str, optional): Start date in 'Y/m/d' format. Default is None.
- `until` (str, optional): End date in 'Y/m/d' format. Default is None.
- `retstart` (int, optional): The starting position for the results. Default is 0.
- `retmax` (int, optional): The maximum number of results to return. Default is 250.
- `pmc_only` (bool, optional): If True, restricts the search to PubMed Central. Default is False.
- `**kwargs`: Additional keyword arguments for advanced queries.

**Returns:**
- A list of PMIDs.

**Example:**
```python
pmids = fetch.pmids_for_query('cancer genomics', retmax=5)
```

#### `pmids_for_clinical_query(query, category, optimization='broad', since=None, until=None, retstart=0, retmax=250, pmc_only=False, **kwargs)`
Returns a list of PMIDs for a clinical query in a specified category.

**Parameters:**
- `query` (str): The search term.
- `category` (str): The clinical query category ('therapy', 'diagnosis', 'etiology', 'prognosis', 'prediction').
- `optimization` (str, optional): The optimization type ('broad' or 'narrow'). Default is 'broad'.
- `since` (str, optional): Start date in 'Y/m/d' format. Default is None.
- `until` (str, optional): End date in 'Y/m/d' format. Default is None.
- `retstart` (int, optional): The starting position for the results. Default is 0.
- `retmax` (int, optional): The maximum number of results to return. Default is 250.
- `pmc_only` (bool, optional): If True, restricts the search to PubMed Central. Default is False.
- `**kwargs`: Additional keyword arguments for advanced queries.

**Returns:**
- A list of PMIDs.

**Example:**
```python
pmids = fetch.pmids_for_clinical_query('cancer', 'therapy')
```

#### `pmids_for_medical_genetics_query(query, category='all', since=None, until=None, retstart=0, retmax=250, pmc_only=False, **kwargs)`
Returns a list of PMIDs for a medical genetics query in a specified category.

**Parameters:**
- `query` (str): The search term.
- `category` (str, optional): The medical genetics query category ('all', 'diagnosis', 'differential_diagnosis', 'clinical_description', 'management', 'genetic_counseling', 'genetic_testing'). Default is 'all'.
- `since` (str, optional): Start date in 'Y/m/d' format. Default is None.
- `until` (str, optional): End date in 'Y/m/d' format. Default is None.
- `retstart` (int, optional): The starting position for the results. Default is 0.
- `retmax` (int, optional): The maximum number of results to return. Default is 250.
- `pmc_only` (bool, optional): If True, restricts the search to PubMed Central. Default is False.
- `**kwargs`: Additional keyword arguments for advanced queries.

**Returns:**
- A list of PMIDs.

**Example:**
```python
pmids = fetch.pmids_for_medical_genetics_query('BRCA1', 'diagnosis')
```

#### `pmids_for_citation(**kwargs)`
Returns a list of PMIDs for a given citation. Requires at least 3 of the following details: journal title, year, volume, first page, author name.

**Parameters:**
- `**kwargs`: Citation details including `journal`, `year`, `volume`, `first_page`, and `author_name`.

**Returns:**
- A list of PMIDs.

**Example:**
```python
pmids = fetch.pmids_for_citation(journal='Science', year='2008', volume='4', first_page='7', author_name='Grant')
```

#### `related_pmids(pmid)`
Returns related PMIDs for a given PMID, organized by type of relation.

**Parameters:**
- `pmid` (str or int): The PubMed ID of the article.

**Returns:**
- A dictionary of related PMIDs organized by relation type.

**Example:**
```python
related = fetch.related_pmids('12345678')
```

#### `pmid_for_bookID(book_id)`
Returns the PMID for a given NCBI Book ID.

**Parameters:**
- `book_id` (str): The NCBI Book ID (e.g., "NBK2020").

**Returns:**
- The PMID if found, None otherwise.

**Example:**
```python
pmid = fetch.pmid_for_bookID('NBK2020')
```

### Keywords and Advanced Query Characteristics

PubMed supports a variety of keywords and query characteristics to refine searches. Here are some examples:

#### Basic Keywords
- `author` (`AU`): Searches for articles by a specific author.
- `title` (`TI`): Searches for articles with specific words in the title.
- `journal` (`TA`): Searches for articles in a specific journal.

**Example:**
```python
articles = fetch.pmids_for_query('author:"Smith J" AND title:"cancer"')
```

#### Boolean Operators
- `AND`: Combines search terms to ensure both terms are in the results.
- `OR`: Combines search terms to ensure either term is in the results.
- `NOT`: Excludes articles containing the specified term.

**Example:**
```python
articles = fetch.pmids_for_query('cancer AND genomics NOT review')
```

#### Field Tags
- `[ti]`: Title
- `[au]`: Author
- `[ta]`: Journal title abbreviation
- `[dp]`: Publication date
- `[mh]`: MeSH (Medical Subject Headings) terms

**Example:**
```python
articles = fetch.pmids_for_query('cancer[ti] AND Smith J[au]')
```

#### Date Filters
- `date[dp]`: Date of publication
- `pdat`: Publication date range

**Example:**
```python
articles = fetch.pmids_for_query('cancer genomics AND ("2020/01/01"[dp] : "2020/12/31"[dp])')
```

#### Additional Filters
- `Review[pt]`: Filters to review articles.
- `Clinical Trial[pt]`: Filters to clinical trials.
- `Free Full Text[filter]`: Filters to free full-text articles.

**Example:**
```python
articles = fetch.pmids_for_query('cancer genomics AND Review[pt]')
```

### Handling Results

Results returned from search queries or fetch methods are typically lists of PMIDs. These PMIDs can

 be further used to fetch detailed article information.

**Example:**
```python
for pmid in pmids:
    article = fetch.article_by_pmid(pmid)
    print(f"Title: {article.title}")
    print(f"Authors: {', '.join(article.authors)}")
    print(f"Journal: {article.journal}")
    print(f"DOI: {article.doi}")
    print(f"Abstract: {article.abstract}")
    print()
```

