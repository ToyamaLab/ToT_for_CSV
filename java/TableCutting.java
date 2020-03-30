package dbtest1;
import java.util.*;
import java.io.*;

public class TableCutting {
//行指定csvの変換/header無しclass・eclipse・php・パラメータあり
	public static void main(String[] args) throws ClassNotFoundException 
	{
        Integer start_row = Integer.parseInt(args[1]);
        Integer last_row = Integer.parseInt(args[2]);
        Integer start_column = Integer.parseInt(args[3]);
        Integer last_column = Integer.parseInt(args[4]);
		String basedir = System.getProperty("user.dir");
		String inputCsv = basedir + args[0];
		String[] tmp_output = args[0].split("\\.csv", 0);
		String outputCsv = basedir + tmp_output[0] + "_tmp.csv";
	
		try{
			FileInputStream fis = new FileInputStream(new File(inputCsv));
			InputStreamReader isr = new InputStreamReader(fis , "UTF-8");
			BufferedReader br = new BufferedReader(isr);
			FileOutputStream fos = new FileOutputStream(new File(outputCsv));
			OutputStreamWriter osw = new OutputStreamWriter(fos , "UTF-8");
			BufferedWriter bw = new BufferedWriter(osw);
			cutting(br,bw,start_row,last_row,start_column,last_column); //CSVでDBの内容を追加(上書き)する
			br.close(); isr.close(); fis.close(); bw.close(); osw.close(); fos.close();

		} 
		catch(FileNotFoundException exception) { exception.printStackTrace(); }
		catch(IOException exception) { exception.printStackTrace(); }
		
	}

	/**
	* CSVの(1)行目から(2)行目、(3)列目から(4)列目までを抽出→ファイル書き込み
	**/
	private static void cutting(BufferedReader br,BufferedWriter bw, Integer start_row, Integer last_row, Integer start_column, Integer last_column) 
	{


 
		try{
			String line = ""; //一行ずつ読み込む				
			//boolean header = true; //ヘッダーフラグ
			int row_queue = 0; //何行目かのポイント
			while((line = br.readLine()) != null)
			{
				//if(header) { header=false; continue; } //headerはとばす
				row_queue++;
				if(row_queue >= start_row && row_queue <= last_row){
					StringTokenizer token = new StringTokenizer(line, ",");
					
					int column_queue = 0; //何カラム存在するか
					String row="";
					/**
					* パターン1: 100, 1111, null
					* パターン2: 100, 1111, null, etc ,etc...
					* パターン3: 100, 1111, relation
					* パターン4: 100, 1111, relation, etc, etc...
					**/
					while(token.hasMoreTokens())
					{
						String tmpString = token.nextToken();
						System.out.println("column :"+(++column_queue)+"\t"+tmpString);
						//(3)列目から(4)列目まで
						if(column_queue >= start_column && column_queue <= last_column){
							 row += tmpString+",";
						}
					}
					
					System.out.println(row);
                    row = row.substring(0,row.length()-1);//最後の","までを削除した文            
                    System.out.println(row);            
					bw.write(row);
					bw.newLine();      		
				}
			}
		}
		catch( IOException exception) { exception.printStackTrace(); }
	}

}
