<article class="recipe">
    <h2>Build a Citation Graph</h2>

    <p>This recipe demonstrates how to create a citation network using the Metapub library. The script below starts with a given PubMed ID and recursively builds a directed acyclic graph (DAG) of citations up to a specified depth. Each node in the graph represents a paper, and each directed edge indicates a citation from one paper to another.</p>

    <ul>
        <li><strong>Input:</strong> Accepts a PubMed ID and optional depth parameter.</li>
        <li><strong>Output:</strong> Prints a dictionary containing nodes and edges of the citation network.</li>
        <li><strong>Logging:</strong> Provides detailed logs of the process, including node and edge additions, fetching actions, and error handling.</li>
    </ul>

    <h3>Usage:</h3>

    <pre><code>python build_citation_graph.py --depth 3 30848465</code></pre>

    <h3>Code Explanation:</h3>
    <p>1. <strong>Initialize Logging:</strong> Configures logging to output to stdout for detailed tracking.</p>
    <p>2. <strong>Fetch and Process Articles:</strong> Uses <code>PubMedFetcher</code> to retrieve articles and their citations.</p>
    <p>3. <strong>Build the Network:</strong> Adds nodes and edges recursively, building the citation network up to the specified depth.</p>
    <p>4. <strong>Error Handling:</strong> Logs errors encountered during fetching to ensure smooth execution.</p>

    <p>This script is a practical example for researchers and developers looking to leverage Metapub for bibliometric analysis and visualization of citation networks.</p>

<pre>
<code>
import argparse
import logging
from metapub import PubMedFetcher

# Configure logging to output to stdout
logging.basicConfig(level=logging.DEBUG, format='%(asctime)s - %(levelname)s - %(message)s')
logger = logging.getLogger()

def fetch_citation_network(pmid, depth=1, max_depth=3):
    fetch = PubMedFetcher()
    citation_graph = {'nodes': [], 'edges': []}

    def add_node(pmid):
        if pmid not in citation_graph['nodes']:
            citation_graph['nodes'].append(pmid)
            logger.debug(f'Added node: {pmid}')

    def add_edge(citing_pmid, cited_pmid):
        if (citing_pmid, cited_pmid) not in citation_graph['edges']:
            citation_graph['edges'].append((citing_pmid, cited_pmid))
            logger.debug(f'Added edge from {citing_pmid} to {cited_pmid}')

    def build_network(pmid, current_depth):
        if current_depth > max_depth:
            logger.debug(f'Max depth {max_depth} reached at PMID: {pmid}')
            return
        logger.info(f'Fetching article for PMID: {pmid}')
        try:
            article = fetch.article_by_pmid(pmid)
            add_node(pmid)
        except Exception as e:
            logger.error(f'Error fetching article for PMID {pmid}: {e}')
            return

        logger.info(f'Fetching related PMIDs (citedin) for: {pmid}')
        try:
            related_pmids = fetch.related_pmids(pmid).get('citedin', [])
            if not related_pmids:
                logger.debug(f'No related PMIDs (citedin) found for PMID: {pmid}')
            for related_pmid in related_pmids:
                add_node(related_pmid)
                add_edge(pmid, related_pmid)
                build_network(related_pmid, current_depth + 1)
        except Exception as e:
            logger.error(f'Error fetching related PMIDs for PMID {pmid}: {e}')

    build_network(pmid, depth)
    return citation_graph

def main():
    parser = argparse.ArgumentParser(description='Create a citation network for a given PubMed ID.')
    parser.add_argument('pmid', type=str, help='PubMed ID of the article to start with')
    parser.add_argument('--depth', type=int, default=3, help='Depth of the citation network')
    args = parser.parse_args()

    logger.info(f'Starting citation network creation for PMID: {args.pmid} with depth: {args.depth}')
    citation_network = fetch_citation_network(args.pmid, max_depth=args.depth)
    logger.info('Citation network creation completed')
    print(citation_network)

if __name__ == "__main__":
    main()
</code>
</pre>
</article>

