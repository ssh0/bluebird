#!/usr/bin/env python
# -*- coding:utf-8 -*-
#
# written by Shotaro Fujimoto
# 2016-09-19


from faker import Factory
import random
import csv


source_str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'

with open("dummy_users.csv", "w") as f:
    writer = csv.writer(f)

    fake_ja = Factory.create('ja_JP')
    fake_en = Factory.create('en_US')

    for _ in range(100):
        username = "".join(fake_en.name().split()).replace(".", "_")
        if len(username) > 20:
            username = username[:20]
        fullname = fake_ja.name()
        password = "".join([random.choice(source_str) for x in range(random.randint(4, 8))])
        mail = fake_ja.safe_email()
        is_public = '1'
        created = fake_ja.date(pattern="%Y-%m-%d") + ' ' + fake_ja.time("%H:%M:%S")

        row = [s.encode('utf-8') for s in [username, fullname, password, mail, is_public, created]]
        writer.writerow(row)
