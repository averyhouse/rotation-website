import sys
import csv
import email.utils
import smtplib
import socket
import time

from getpass import getpass

# Select mail server
print("Reccomended mail servers:\n"
    "\tCaltech/Outlook outgoing mail server: outlook.office365.com\n"
    "\tGmail outgoing mail server: smtp.gmail.com")
valid_server = False
while not valid_server:
    try:
        mail_server = input("Select a mail server (or empty to quit): ")
        if mail_server is None or len(mail_server) == 0:
            break
        server = smtplib.SMTP(mail_server, 587)
        valid_server = True
    except socket.gaierror:
        print("Error validating server! Try again.", file=sys.stderr)

if not valid_server:
    exit(-1)

server.ehlo()
server.starttls()
server.ehlo()

# Log into sender email account
logged_in = False
while not logged_in:
    try:
        sender = input("Sender email (or empty to quit): ")
        if sender is None or len(sender) == 0:
            break
        passwd = getpass("Sender password: ")
        server.login(sender, passwd)
        logged_in = True
    except smtplib.SMTPAuthenticationError:
        print("Authentication Failed! Try again.", file=sys.stderr)

if not logged_in:
    exit(-1)
passwd = ''
print("Successfully logged in! Sending passwords...")

# Prepare email content
message_subject = 'Avery rotation website password'
curDate = email.utils.formatdate(localtime=True)[:-14]
curDate += '04:20:00 +500' #same
message_content = (
    "Hi, {0}!\n"
    "The rotation website should be up now at at https://avery.caltech.edu/rotation. "
    "Here is your login information: \n"
    "\tUsername: {1}\n"
    "\tPassword: {2}\n"
    "Let me (Alvin) know if something doesn't work (something definitely doesn't)."
)
message_skeleton = "Date: {0}\r\nSubject: {1}\r\n\r\n{2}"

msg_cnt = message_content.format("Averite", "averite@caltech.edu", "thePassword")
msg_exl = message_skeleton.format(curDate, message_subject, msg_cnt)
print("\n----------EXAMPLE EMAIL----------: \n"
   "{0}\n---------------------------------".format(msg_exl))

# Send emails to voters
total = 0
with open('users.csv', 'r') as file:
    lines = csv.reader(file, delimiter=',')

    for line in lines:
        time.sleep(2)
        name = line[0]
        email = line[1]
        curPasswd = line[2]
        message_text = message_content.format(name, email, curPasswd)
        msg = message_skeleton.format(curDate, message_subject, message_text)
        server.sendmail(sender, email, msg)
        total += 1

print("Successfully sent {0} emails!".format(total))
server.quit()
        
