import metapub.findit.journals.aaas as aaas
import metapub.findit.journals.biochemsoc as biochemsoc
import metapub.findit.journals.bmc as bmc
import metapub.findit.journals.cell as cell
import metapub.findit.journals.degruyter as degruyter
import metapub.findit.journals.dustri as dustri
import metapub.findit.journals.endo as endo
import metapub.findit.journals.jama as jama
import metapub.findit.journals.jstage as jstage
import metapub.findit.journals.karger as karger
import metapub.findit.journals.lancet as lancet
import metapub.findit.journals.nature as nature
import metapub.findit.journals.misc_vip as misc_vip
import metapub.findit.journals.scielo as scielo
import metapub.findit.journals.sciencedirect as sciencedirect
import metapub.findit.journals.springer as springer
import metapub.findit.journals.spandidos as spandidos
import metapub.findit.journals.wiley as wiley
import metapub.findit.journals.wolterskluwer as wolterskluwer
import metapub.findit.journals.cantdo_list as cantdo_list

# Additional journals
jci_journals = ['J Clin Invest']
najms_journals = ['N Am J Med Sci']
doi2step_journals = ['J Public Health Policy']
doiserbia_journals = ['Genetika']

additional_journals = jci_journals + najms_journals + doi2step_journals + doiserbia_journals

def extract_journal_names(journal_dict):
    return list(journal_dict.keys())

# Combine all the journal lists
all_journals = set(
    extract_journal_names(aaas.aaas_journals) +
    extract_journal_names(biochemsoc.biochemsoc_journals) +
    extract_journal_names(bmc.BMC_journals) +
    extract_journal_names(cell.cell_journals) +
    extract_journal_names(degruyter.degruyter_journals) +
    extract_journal_names(dustri.dustri_journals) +
    extract_journal_names(endo.endo_journals) +
    extract_journal_names(jama.jama_journals) +
    extract_journal_names(jstage.jstage_journals) +
    extract_journal_names(karger.karger_journals) +
    extract_journal_names(lancet.lancet_journals) +
    extract_journal_names(nature.nature_journals) +
    extract_journal_names(misc_vip.vip_journals) +
    extract_journal_names(misc_vip.vip_journals_nonstandard) +
    extract_journal_names(scielo.scielo_journals) +
    extract_journal_names(sciencedirect.sciencedirect_journals) +
    extract_journal_names(springer.springer_journals) +
    extract_journal_names(spandidos.spandidos_journals) +
    extract_journal_names(wiley.wiley_journals) +
    extract_journal_names(wolterskluwer.wolterskluwer_journals) +
    cantdo_list.JOURNAL_CANTDO_LIST +
    additional_journals
)

# Sort and print the journal list
sorted_journal_list = sorted(all_journals)
for journal in sorted_journal_list:
    print(journal)

# Optionally, write the list to a file
with open("journal_list.txt", "w") as f:
    for journal in sorted_journal_list:
        f.write(journal + "\n")

