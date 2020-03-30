import pandas as pd

df = pd.read_csv('./data/cross_sample1.csv', sep=',')

print(df.head())

column=['row','column','value']
df2 = pd.DataFrame(columns=column)
df3 = pd.DataFrame()

for index, row in df.iterrows():
    #print(type(index))
    #print(index)
    #print('~~~~~~')

    print(type(row))
    print(row)
    print('------')

    df_tmp = df3.append(row)
    #print(df_append)
    #print('~~~~~~')

    for column_name , item in df_tmp.iteritems():
        print(type(item))
        print(item)
        print('======')
        df4 = pd.Series(item)
        print(df4)
        df4 = pd.DataFrame(data=df4, columns=column)
        print(df4)
        df_append = df2.append(df4)
        print(df_append)
        df2 = df_append
        print('******')
