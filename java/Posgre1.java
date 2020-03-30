package dbtest1;

import java.sql.Connection;
import java.sql.DriverManager;

public class Posgre1 {
	public static void main(String[] args) {
		Connection conn = null;
		try {
			Class.forName("org.postgresql.Driver");
			conn = DriverManager.getConnection("jdbc:postgresql://spacia.db.ics.keio.ac.jp/", "doi", "doi");
			conn.close();
			System.out.println("OK");
		} catch (Exception e) {
			e.printStackTrace();
			System.out.println("NG");
		}
	}
}