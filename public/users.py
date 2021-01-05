from random_word import RandomWords
import csv
rw = RandomWords()
users = []
with open('voters.csv', 'rt') as csvfile:
    csvReader = csv.reader(csvfile, delimiter=',')
    for row in csvReader:
        passwd = str(rw.get_random_word())
        users.append([row[0] + ' ' + row[2], row[5], passwd])
with open('users.csv', 'w') as f:
    writer = csv.writer(f)
    writer.writerows(users)
