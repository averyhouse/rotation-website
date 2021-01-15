import csv
import random
import requests

word_site = "https://www.mit.edu/~ecprice/wordlist.10000"

response = requests.get(word_site)
WORDS = response.content.splitlines()
NUM_WORDS = len(WORDS)

def random_word():
    i = random.randint(0, NUM_WORDS-1)
    return WORDS[i].decode('UTF-8')

# Read in voters and assign password
users = []
with open('voters.csv', 'rt') as csvfile:
    csvReader = csv.reader(csvfile, delimiter='\t')
    for row in csvReader:
        passwd = random_word()
        users.append([row[0] + ' ' + row[2], row[3], passwd])

# Save users
with open('users.csv', 'w') as f:
    writer = csv.writer(f)
    writer.writerows(users)
