### FindIt Class Documentation

The `FindIt` class in the `metapub` library is designed to help locate an article's full-text PDF based on its PubMed ID (PMID) or DOI. The preferred usage is to initialize `FindIt` with a PMID or DOI. Setting `verify=False` will speed up the process of locating a URL by not verifying that the links can be reached. 

FindIt is backed by a cache engine keyed to the PMID or DOI of each paper, so you don't have to map IDs to URLs more than once.

**Usage Examples:**

```python
from metapub.findit import FindIt

# Preferred usage with a PubMed ID (default argument)
src = FindIt('1234567')

# Optional: Speed up by disabling verification
src = FindIt('1234567', verify=False)

# Usage with a DOI
src = FindIt(doi='10.xxxx/xxx.xxx')
```

**Note:** The `DEFAULT_CACHE_DIR` is set to the user's home directory + "/.cache".

### Attributes

- **pmid**: The PubMed ID of the article.
- **doi**: The DOI of the article.
- **url**: The URL of the article's full-text PDF.
- **reason**: The reason for the PDF retrieval status.
- **doi_score**: The DOI score indicating the source reliability.

### Methods

#### `__init__(self, pmid=None, cachedir=DEFAULT_CACHE_DIR, **kwargs)`

Initializes the `FindIt` object with either a PubMed ID or a DOI.

**Parameters:**
- `pmid` (str or int, optional): The PubMed ID of the article.
- `doi` (str, optional): The DOI of the article.
- `cachedir` (str, optional): The directory for caching results. Default is `DEFAULT_CACHE_DIR`.
- `**kwargs`: Additional keyword arguments.

#### `load(self, verify=True)`

Fetches the article's full-text URL based on its metadata.

**Parameters:**
- `verify` (bool, optional): Whether to verify the URL. Default is `True`.

**Returns:**
- `(url, reason)`: Tuple containing the URL of the PDF and the reason if not found.

#### `load_from_cache(self, verify=True, retry_errors=False)`

Attempts to load the article's full-text URL from cache. If not found in cache, fetches it and stores it in the cache.

**Parameters:**
- `verify` (bool, optional): Whether to verify the URL. Default is `True`.
- `retry_errors` (bool, optional): Whether to retry on errors. Default is `False`.

**Returns:**
- `(url, reason)`: Tuple containing the URL of the PDF and the reason if not found.

#### `backup_url(self)`

**Experimental!** Provides a backup URL to try if the primary URL does not work.

**Returns:**
- `backup_url`: The backup URL for the article's PDF.

#### `to_dict(self)`

Returns a dictionary containing the public attributes of the `FindIt` object.

**Returns:**
- `dict`: A dictionary with keys `pmid`, `doi`, `reason`, `url`, `doi_score`.

### Please Note

- FindIt does not download PDFs. It only finds URLs to the PDFs.
- Most PDFs can be downloaded by a script using these URLs. However, some URLs will need to be visited by a human using a browser.
