from metapub import FindIt

src = FindIt("23747781")
print(src.url)

if src.url is None:
    print(src.reason)


