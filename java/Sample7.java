package dbtest1;

import java.util.*;
import java.io.*;
import java.util.ArrayList;
import java.io.FileWriter;
import java.io.PrintWriter;
import java.io.File;
import java.io.IOException;

public class Sample7 {
//クロス表をリスト化するclass・eclipse・php・パラメータ有り
	public static void main(String[] args) throws ClassNotFoundException 
	{
		//接続文字列
       
		String basedir = System.getProperty("user.dir");
		String inputCsv = basedir + args[0];
		String file[] = args[0].split("\\.", 1);
		String outputCsv = basedir + file[0] + "_tmp.csv";
		System.out.println(inputCsv);
		System.out.println(outputCsv);
	//	Class.forName("org.postgresql.Driver");

        

		try{

			FileInputStream fis = new FileInputStream(new File(inputCsv));
			InputStreamReader isr = new InputStreamReader(fis , "UTF-8");
			BufferedReader br = new BufferedReader(isr);
			cross_listing(br, outputCsv); //cross表をリスト化
			br.close(); isr.close(); fis.close();
			
		} 
		catch(FileNotFoundException exception) { exception.printStackTrace(); }
		catch(IOException exception) { exception.printStackTrace(); }
		
	}

	/**
	* cross表のcsvファイルをリスト化されたcsvファイルに書き換え
	**/
	private static void cross_listing(BufferedReader br, String outputCsv) 
	{
		try{
			ArrayList<ArrayList<String>> cross = new ArrayList<ArrayList <String>>();
			ArrayList<ArrayList<String>> listing = new ArrayList<ArrayList <String>>();
			String line = ""; //一行ずつ読み込む				
			//boolean header = true; //ヘッダーフラグ
			while((line = br.readLine()) != null)
			{
				//if(header) { header=false; continue; } //headerはとばす
				
				ArrayList<String> row = new ArrayList <String>();
				StringTokenizer token = new StringTokenizer(line, ",");
				int column_queue = 0; //何カラム存在するか
				/**
				* パターン1: 100, 1111, null
				* パターン2: 100, 1111, null, etc ,etc...
				* パターン3: 100, 1111, relation
				* パターン4: 100, 1111, relation, etc, etc...
				**/
				while(token.hasMoreTokens())
				{
					String tmpString = token.nextToken();
					row.add(tmpString);
					System.out.println("column :"+(++column_queue)+"\t"+tmpString);
				}				
				cross.add(row);
			}	
			for(int i = 0; i < cross.size(); i++){
			      //jは各配列の要素数、num[i].size(()までループ
			      for(int j = 0; j < cross.get(i).size();j++){ 
			        System.out.print(cross.get(i).get(j) + " ");
			      }
			      System.out.println(" ");
			    }
			    System.out.println(" ");
			for(int i = 1; i < cross.size(); i++){
                //jは各配列の要素数、cross[i].size(()までループ
                for(int j = 1; j < cross.get(i).size();j++){ 
                	ArrayList<String> row2 = new ArrayList <String>();
                  row2.add(cross.get(0).get(j));
                  row2.add(cross.get(i).get(0));
                  row2.add(cross.get(i).get(j));
                  listing.add(row2);
                }
            }
			for(int i = 0; i < listing.size(); i++){
			      //jは各配列の要素数、num[i].size(()までループ
			      for(int j = 0; j < listing.get(i).size();j++){ 
			        System.out.print(listing.get(i).get(j) + " ");
			      }
			      System.out.println(" ");
			    }
			    System.out.println(" ");
			System.out.println(cross.size()+" "+cross.get(1).size());
			System.out.println(listing.size()+" "+listing.get(1).size());
			try {
	            // 出力ファイルの作成
	            FileWriter f = new FileWriter(outputCsv, false);
	            PrintWriter p = new PrintWriter(new BufferedWriter(f));
	            
	            // 内容をセットする
	            for(int i = 0; i < listing.size(); i++){
	            	p.print(listing.get(i).get(0));
	            	for(int j = 1; j < listing.get(i).size();j++){ 
	            		p.print(",");
	            		p.print(listing.get(i).get(j));
		            }
	            	p.println();    // 改行
	            }
	 
	            // ファイルに書き出し閉じる
	            p.close();
	 
	            System.out.println("ファイル出力完了！");
	        } catch (IOException ex) {
	            ex.printStackTrace();
	        }
            
		}
		catch( IOException exception) { exception.printStackTrace(); }
	}
}
