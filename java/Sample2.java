package dbtest1;
import java.sql.*;
import java.util.*;
import java.io.*;

public class Sample2 {

	public static void main(String[] args) throws ClassNotFoundException 
	{
		String basedir = System.getProperty("user.dir");
		String inputCsv = args.length>0 ? args[0] : basedir + "/csv/recipe_base_A-pattern.csv";
		String outputCsv = "output.csv";
		String table = "recipe";
		Class.forName("org.sqlite.JDBC");

		try{
			FileInputStream fis = new FileInputStream(new File(inputCsv));
			InputStreamReader isr = new InputStreamReader(fis , "UTF-8");
			BufferedReader br = new BufferedReader(isr);
			csv2db(table, br); //CSVでDBの内容を追加(上書き)する
			br.close(); isr.close(); fis.close();

			FileInputStream fis2 = new FileInputStream(new File(inputCsv));
			InputStreamReader isr2 = new InputStreamReader(fis2 , "UTF-8");
			BufferedReader br2 = new BufferedReader(isr2);
			String outText = matchDB(table, br2); //CSVに対応するDBのデータを取り出す
			br2.close(); isr2.close(); fis2.close();

			FileOutputStream fos = new FileOutputStream(new File(outputCsv));
			OutputStreamWriter osw = new OutputStreamWriter(fos , "UTF-8");
			BufferedWriter bw = new BufferedWriter(osw);
			bw.write(outText);
			bw.close(); osw.close(); fos.close();
		} 
		catch(FileNotFoundException exception) { exception.printStackTrace(); }
		catch(IOException exception) { exception.printStackTrace(); }
	}

	/**
	* CSVの2と3行目だけ(uidとvalue)をDBへ格納する．
	**/
	private static void csv2db(String table, BufferedReader br) 
	{
		Connection connection = null;
		try{
			connection = DriverManager.getConnection("jdbc:sqlite:BlogList.db"); //DB名指定
			Statement statement = connection.createStatement();
			statement.setQueryTimeout(30);
			statement.executeUpdate("create table if not exists "+ table +" (uid integer UNIQUE, value string)"); //table名指定

			String line = ""; //一行ずつ読み込む				
			boolean header = true; //ヘッダーフラグ
			while((line = br.readLine()) != null)
			{
				if(header) { header=false; continue; } //headerはとばす

				StringTokenizer token = new StringTokenizer(line, ",");
				int column_queue = 0; //何カラム存在するか
				String insert="";
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
					//2と3列目だけ
					if(column_queue == 2 || column_queue == 3) insert += "\'" + tmpString + "\', ";
				}
				if(column_queue == 2) //column=3がなく，column=2で止まっていた場合の追加
				{ //3列目に何も書かれていない場合はDBから情報を引っ張ってきて，上書きする
					String uid = insert.substring(0,insert.length()-2).replaceAll("'","");
					String value = getDB(table, uid);
					insert +=  "\'" + value + "\', ";
					System.out.print("select * from "+table+" where uid = "+uid);
					System.out.println(" → uid : "+uid+"\t getString('value') : "+value);
				}				
				
				insert = insert.substring(0,insert.length()-2);//最後の","までを削除した文            
           		insert ="insert or replace into "+ table +" values("+insert+")";           		
          		System.out.println("insert: \t"+insert);
           		statement.executeUpdate(insert);
			}
		}
		catch( IOException exception) { exception.printStackTrace(); }
		catch(SQLException exception) { System.err.println("exception :"+exception.getMessage()); }
		finally {
			try{ if(connection != null) connection.close(); }
			catch(SQLException exception) { System.err.println(exception); }
		}
	}

	/**
	* uidに対応するvalueをDBから取り出す
	**/
	private static String getDB(String table, String uid)
	{
		String value = "";
		Connection connection = null;
		try{
			connection = DriverManager.getConnection("jdbc:sqlite:BlogList.db"); //DB名指定
			Statement statement = connection.createStatement();
			statement.setQueryTimeout(30);
			String sql = "select * from "+table+" where uid = "+uid;
			System.out.println(sql);

			ResultSet rs = statement.executeQuery(sql);
			while(rs.next())
			{
				value = rs.getString("value");
			}
		} 
		catch(SQLException exception) { System.err.println("exception :"+exception.getMessage()); }
		finally {
			try{ if(connection != null) connection.close(); }
			catch(SQLException exception) { System.err.println(exception); }			
		}
		return value;
	}

	/**
	* ファイル(br)とDBのuidを比較し，一致したuidのvalueを付与して，返す
	**/
	private static String matchDB(String table, BufferedReader br)
	{
		StringBuilder outText = new StringBuilder();
		Connection connection = null;
		try{
			connection = DriverManager.getConnection("jdbc:sqlite:BlogList.db"); //DB名指定
			Statement statement = connection.createStatement();
			statement.setQueryTimeout(30);
			boolean header = true; //ヘッダーフラグ

			String line = ""; //一行ずつ読み込む
			while((line = br.readLine()) != null)
			{
				String[] readCsv = line.split(",");
				if(header) //ヘッダーの書き込み(一度だけ)
				{  
					outText.append(readCsv[0]+","+readCsv[1]+","+readCsv[2]+"\n");
					header=false; continue;
				}
				String value = "";
				ResultSet rs = statement.executeQuery("select * from "+table+" where uid = "+readCsv[1]);
				while(rs.next())
				{
					value = rs.getString("value");
				}
				outText.append(readCsv[0]+","+readCsv[1]+","+value+"\n");
			}
			System.out.println(outText);
		} 
		catch(IOException exception) { exception.printStackTrace(); }
		catch(SQLException exception) { System.err.println("exception :"+exception.getMessage()); }
		finally {
			try{ if(connection != null) connection.close(); }
			catch(SQLException exception) { System.err.println(exception); }			
		}
		return new String(outText);
	}

}
