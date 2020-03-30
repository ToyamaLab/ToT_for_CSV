#!/usr/bin/python
# coding: UTF-8

import argparse
import requests
import time

# URL_US_DATA_GOV='https://catalog.data.gov/api/3/action/package_search'
# URL_UK_DATA_GOV='https://data.gov.uk/api/3/action/package_search'
# URL_JP_DATA_GOV='https://ckan.open-governmentdata.org/api/3/action/package_search'
# URL_FK_DATA_GOV='https://data.gov.jp/api/3/action/package_search'

def handle_args():
    parser = argparse.ArgumentParser(description='')
    parser.add_argument('-i', '--interval', default=60, \
                            help='Interval for submit request', type=int)
    parser.add_argument('-r', '--rows', default=100, \
                            help='Number of rows to request', type=int)
    parser.add_argument('-s', '--start', default=0, \
                            help='Starting offset of the request', type=int)
    parser.add_argument('-t', '--total', required=True, \
                            help='Number of data in total', type=int)
    parser.add_argument('-c', '--country', required=True, \
                         help='Target country', type=str)
    parser.add_argument('-u', '--url', required=True, \
                         help='Target URL', type=str)
    return parser.parse_args()

# def get_url(country):
#     if country == 'uk':
#         return URL_UK_DATA_GOV
#     elif country == 'jp':
#         return URL_JP_DATA_GOV
#     elif country == 'fk':
#         return URL_FK_DATA_GOV
#     elif country == 'us2':
#         return URL_US_DATA_GOV
#     else:
#         return URL_US_DATA_GOV

def get_single_result(country, start, rows, url):
    file_name = '../metadata/' + country + '/' + country + '_' + '{0:05d}'.format(start) + '.json'
    params= {'q': 'res_format:CSV', 'sort': 'metadata_created+asc', 'start': str(start), 'rows': str(rows)}
    params_str = '&'.join('%s=%s' % (k,v) for k,v in params.items())

    r = requests.get(url, params=params_str)
    if r.status_code == 200:
        f = open(file_name, 'w')
        content = str(r.content)
        f.write(content)
        f.close
        print(file_name);
    return r.status_code

if __name__ == '__main__':
    args = handle_args()
    print('開始')
    offset = args.start
    while offset < args.total:
        res = get_single_result(args.country, offset, args.rows, args.url)
        # print ('Offset:', offset, 'Status:', res)
        offset = offset + args.rows
        time.sleep(args.interval)

    print('完了')
