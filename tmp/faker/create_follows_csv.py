#!/usr/bin/env python
# -*- coding:utf-8 -*-
#
# written by Shotaro Fujimoto
# 2016-09-19

import random
import csv


def create_follows_map(start_num=1, num_of_users=100, average_follows=20, pm=5):
    result = []
    for from_user in range(start_num, start_num + num_of_users):
        follows_one = []
        max_follows = random.randint(average_follows - pm, average_follows + pm)

        i = 0
        while i < max_follows:
            to_user = random.randint(start_num, start_num + num_of_users)
            if to_user == from_user:
                continue
            else:
                follows_one.append(to_user)
                i += 1
        result += [[from_user, u] for u in follows_one]
    return result

with open("dummy_follows.csv", "w") as f:
    writer = csv.writer(f)
    result = create_follows_map(start_num=36)
    for res in result:
        writer.writerow(res)

