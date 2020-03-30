package dbtest1;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class HeaderReading{
    public static void main(String[] args) {
        Connection conn = null;
        Statement stmt = null;
        ResultSet rset = null;
        String query = "";
        for(int i=0; i<args.length; i++){
         query += args[i] + " ";
      }
      System.out.println(query);
        //接続文字列
        String url = "jdbc:postgresql://spacia.db.ics.keio.ac.jp/";
        String user = "doi";
        String password = "doi";

        try{
            Class.forName("org.postgresql.Driver");

            //PostgreSQLへ接続
            conn = DriverManager.getConnection(url, user, password);

            //自動コミットOFF
            conn.setAutoCommit(false);

            //SELECT文の実行
            stmt = conn.createStatement();
            String sql = "SELECT 1";
            rset = stmt.executeQuery(sql);

            //SELECT結果の受け取り
            while(rset.next()){
                String col = rset.getString(1);
                System.out.println(col);
            }
            //CREATE文の実行
            sql = query;
            stmt.executeUpdate(sql);
            conn.commit();

//            //INSERT文の実行
//            sql = "INSERT INTO jdbc_test VALUES (1, 'AAA')";
//            stmt.executeUpdate(sql);
//            conn.commit();
        }
        catch (ClassNotFoundException e) {
            e.printStackTrace();
        }
        catch (SQLException e){
            e.printStackTrace();
        }
        finally {
            try {
                if(rset != null)rset.close();
                if(stmt != null)stmt.close();
                if(conn != null)conn.close();
            }
            catch (SQLException e){
                e.printStackTrace();
            }

        }
    }
}