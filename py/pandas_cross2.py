import pandas as pd

df = pd.read_csv('./data/cross_sample1.csv', sep=',')

print(df.head())

df2 = pd.DataFrame()
print(df2.head())

for column_name, item in df.iteritems():
    #print(type(column_name))
    #print(column_name)
    #print('~~~~~~')

    print(type(item))
    print(item)
    print('------')

    #s = pd.Series(item)
    print('======')

    df_append = df2.append(item)
    print(df_append)
    df2 = df_append
    print('~~~~~~')
