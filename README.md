# Description

Quick Vagrant example displaying the benefits of using Fermata for a fake SMTP daemon

## Starting up the image
vagrant up --provision 

## ssh'ing into the machine
vagrant ssh mailtest

## URL's
Fermata Web UI = http://localhost:9092
Fermata SMTP = smtp://localhost:2500

# Reference

I modified the code from Srinivas Tamada's [9lessons](http://www.9lessons.info/2009/10/send-mail-using-smtp-and-php.html) website, for the email generation code, so thank you for your blog article on this.

(Github Link to Fermata)[https://github.com/scsibug/fermata] created by Greg Heartsfield.


# Disclaimer

When using this example please be careful on who you send test emails to, by default the app should send to a localhost on port 2500 so should be safe and uses one of the RFC example domains [http://tools.ietf.org/html/rfc2606#section-3](http://tools.ietf.org/html/rfc2606#section-3)