#!/usr/bin/python
# coding: UTF-8
from __future__ import unicode_literals
import argparse
import codecs
import json
import os.path
import requests
import sys
import time
import datetime
import os

def handle_args():
    parser = argparse.ArgumentParser(description='')
    parser.add_argument('-d', '--dir', default='.', \
                            help='Output directory for csv files', type=str)
    parser.add_argument('-i', '--interval', default=60, \
                            help='Interval for submit request', type=int)
    parser.add_argument('-l', '--log', action='store_true', \
                            help='Set this if you want request logs')
    parser.add_argument('-n', '--ignore', type=str, nargs='+', \
                            help='Specify resource UUIDs to be ignored')
    parser.add_argument('-y', '--date', type=str, \
                            help='Set date')
    parser.add_argument('mdfile', metavar='FILE', type=str, nargs=1, \
                            help='Metadata file')
    return parser.parse_args()

def get_csv(dir, id, url, date):
    # File name is the UUID of the resource + .csv
    filename = '../csv/' + dir + '/' + date + '/' +id + '.csv'

    try:
        r = requests.get(url, timeout=60)

    except Exception as e:
        print('HTTP request error:', url)
        return 0

    if r.status_code == 200:
        f = open(filename, 'w')
        content = str(r.content)
        f.write(content)
        f.close

    return r.status_code

if __name__ == '__main__':
    args = handle_args()
    new_dir_path = '../csv/' + args.dir + '/' + args.date
    if not os.path.exists(new_dir_path):
        os.mkdir(new_dir_path)
    mdfile = args.mdfile[0]
    f = codecs.open(mdfile, 'r', 'utf-8')
    json_dict = json.load(f)

    # Log file is stored in the directory same as the metadata file
    logfile = os.path.splitext(mdfile)[0] + '_log.csv'
    log = codecs.open(logfile, 'w', 'utf-8')

    if not os.path.isdir(args.dir):
        print('Cannot output csv files for the directory:', args.dir)
        sys.exit(-1)

    for entry in json_dict['result']['results']:
        if not args.date in entry['metadata_modified']:
                continue
        for resource in entry['resources']:
            #if resource['id'] in args.ignore:
                #continue
            if resource['format'] == 'CSV':
                print(resource['id'])
                res = get_csv(args.dir, resource['id'], resource['url'], args.date)
                print(res, resource['url'])
                if args.log:
                    log.write(entry['id'] + ',' \
                                  + resource['id'] + ',' \
                                  + str(res) + ',' \
                                  + unicode(resource['url']) + '\n')

                time.sleep(args.interval)
