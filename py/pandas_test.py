import pandas as pd

df = pd.read_csv('./data/lunch_box.csv', sep=',')

print(df.head(3))

print(df.tail())
