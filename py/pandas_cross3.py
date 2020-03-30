import pandas as pd
import argparse

def handle_args():
    parser = argparse.ArgumentParser(description='')
    parser.add_argument('-d', '--dir', default='.', \
                            help='Input directory for csv files', type=str)
    return parser.parse_args()

args = handle_args()
file = args.dir
df = pd.read_csv(file, sep=',')

print(df.head())

df2 = pd.DataFrame()
print(df2.head())

for index, row in df.iterrows():
   for column_name, item in df.iteritems():
        if column_name == 'Unnamed: 0':
            continue
        print('++++++')
        print('index:'+str(index))
        print('column:'+str(column_name))
        print('value:'+str(df.loc[index][column_name]))
        value=df.loc[index][column_name]
        print('------')
        df_row = pd.Series([df.loc[index]['Unnamed: 0'], column_name, value], index=['row','column', 'value'])
        print(df_row)
         
        df_append=df2.append(df_row, ignore_index=True)
        df2=df_append


print(df2)
