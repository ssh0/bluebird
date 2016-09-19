#!/usr/bin/env python
# -*- coding:utf-8 -*-
#
# written by Shotaro Fujimoto
# 2016-09-19

from faker import Factory
import random
import csv


def create_tweets_data(start_num=1, num_of_users=100, num_of_tweets=10000):
    result = []
    fake = Factory.create()
    for t in range(num_of_tweets):
        user_id = random.randint(start_num, start_num + num_of_users)
        content = fake.text(max_nb_chars=140)
        timestamp = fake.date(pattern="%Y-%m-%d") + ' ' + fake.time("%H:%M:%S")
        result.append([user_id, content, timestamp])
    return result

with open("dummy_tweets.csv", "w") as f:
    writer = csv.writer(f)
    tweets = create_tweets_data(start_num=36)
    for t in tweets:
        writer.writerow(t)

