import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class Database {
	private Connection connec;
	private static Database dbInstance;

	private PreparedStatement psUpdateFluxRssLastItem;
	private PreparedStatement psSelectFluxRssItem;
	private PreparedStatement psSelectFluxRss;
	private PreparedStatement psInsertFluxRssItem;
	private PreparedStatement psInsertItemOfFluxRss;

	private int nbRequest;

	private Database() {
		try {
			Class.forName("org.postgresql.Driver");
		}
		catch (ClassNotFoundException e) {
			e.printStackTrace();
		}

		try {
			connec = DriverManager.getConnection("jdbc:postgresql://127.0.0.1:5432/info2_s3_projet_sadou","pi","Martin123");
			psUpdateFluxRssLastItem = connec.prepareStatement("UPDATE FLUX_RSS SET id_last_rss = ? WHERE link = ? ");
			psSelectFluxRssItem = connec.prepareStatement("SELECT * FROM RSS_ITEM WHERE id = ?");
			psSelectFluxRss = connec.prepareStatement("SELECT * FROM FLUX_RSS WHERE link = ?");
			psInsertFluxRssItem = connec.prepareStatement("INSERT INTO RSS_ITEM(title,link,pub_date,description,category,importance) VALUES(?,?,?,?,?,?)");
			psInsertItemOfFluxRss = connec.prepareStatement("INSERT INTO ITEM_OF_FLUX_RSS VALUES(?,?)");
		}
		catch (SQLException e) {
			try
			{
				connec = DriverManager.getConnection("jdbc:postgresql://5.50.179.242:5432/info2_s3_projet_sadou","pi","Martin123");
				psUpdateFluxRssLastItem = connec.prepareStatement("UPDATE FLUX_RSS SET id_last_rss = ? WHERE link = ? ");
				psSelectFluxRssItem = connec.prepareStatement("SELECT * FROM RSS_ITEM WHERE id = ?");
				psSelectFluxRss = connec.prepareStatement("SELECT * FROM FLUX_RSS WHERE link = ?");
				psInsertFluxRssItem = connec.prepareStatement("INSERT INTO RSS_ITEM(title,link,pub_date,description,category,importance) VALUES(?,?,?,?,?,?)");
				psInsertItemOfFluxRss = connec.prepareStatement("INSERT INTO ITEM_OF_FLUX_RSS VALUES(?,?)");
			}
			catch (SQLException e2)
			{
				System.out.println("Impossible de se connecter à la base !");
			}
		}

		this.nbRequest = 0;
	}

	public static Database getInstance() {
		if(dbInstance==null){dbInstance=new Database();}
		return dbInstance;
	}

	private void requested()
	{
		this.nbRequest++;
	}

	private ArrayList<FluxRSS> getFluxRSSReq(String req) throws SQLException {
		Statement selectRSS=connec.createStatement();
		ArrayList<FluxRSS> listeFluxRss=new ArrayList<FluxRSS>();

		ResultSet rsFluxRSS=selectRSS.executeQuery(req);
		this.requested();

		while(rsFluxRSS.next()){
			FluxRSS fluxRss = new FluxRSS(rsFluxRSS.getString("link"),rsFluxRSS.getInt("id_last_rss"));
			listeFluxRss.add(fluxRss);
		  }
		rsFluxRSS.close();
		return listeFluxRss;
	}

	public ArrayList<FluxRSS> getFluxRSS() throws SQLException {
		return getFluxRSSReq("SELECT * FROM FLUX_RSS");
	}

	public RSSItem getRSSItem(int id) throws SQLException{
		RSSItem rssItem = null;

		psSelectFluxRssItem.setInt(1,id);
		ResultSet rsRSSItem=psSelectFluxRssItem.executeQuery();
		this.requested();

		if(rsRSSItem.next())
			rssItem = new RSSItem(rsRSSItem.getInt("id"),rsRSSItem.getString("title"),rsRSSItem.getString("link"),rsRSSItem.getTimestamp("pub_date"),rsRSSItem.getString("description"),rsRSSItem.getArray("category"),rsRSSItem.getInt("importance"));
		rsRSSItem.close();
		return rssItem;
	}

	public FluxRSS getFluxRSS(String link) throws SQLException{
		FluxRSS fluxRSS = null;

		psSelectFluxRss.setString(1,link);
		ResultSet rsFluxRSS=psSelectFluxRss.executeQuery();
		this.requested();

		if(rsFluxRSS.next())
			fluxRSS = new FluxRSS(rsFluxRSS.getString("link"),rsFluxRSS.getInt("id_last_rss"));
		rsFluxRSS.close();
		return fluxRSS;
	}

	public void updateFluxRss(String link, int idLastRss) throws SQLException {
		this.psUpdateFluxRssLastItem.setString(2,link);
		this.psUpdateFluxRssLastItem.setInt(1,idLastRss);

		this.psUpdateFluxRssLastItem.executeUpdate();
		this.requested();
	}

	private void insertItemOfFluxRss(ItemOfFluxRss itemOfFluxRss) throws SQLException {
		this.psInsertItemOfFluxRss.setString(1,itemOfFluxRss.getLinkFluxRss());
		this.psInsertItemOfFluxRss.setInt(2,itemOfFluxRss.getIdRssItem());

		this.psInsertItemOfFluxRss.executeUpdate();
		this.requested();
	}

	public void insertFluxRSSItem(RSSItem rssItem, FluxRSS fluxRSS) throws SQLException
	{
		this.psInsertFluxRssItem.setString(1,rssItem.getTitle());
		this.psInsertFluxRssItem.setString(2,rssItem.getLink());
		this.psInsertFluxRssItem.setTimestamp(3,rssItem.getPubDate());
		this.psInsertFluxRssItem.setString(4,rssItem.getDescription());
		this.psInsertFluxRssItem.setString(5,this.connec.createArrayOf("varchar[]",rssItem.getCategory()));
		this.psInsertFluxRssItem.setInt(6,rssItem.getImportance());
		this.psInsertFluxRssItem.executeUpdate();
		this.requested();

		Statement selectLastId=connec.createStatement();
		int lastId = -1;

		ResultSet rsLastId=selectLastId.executeQuery("SELECT currval('rss_item_id_seq');");
		this.requested();

		if(rsLastId.next())
			lastId = rsLastId.getInt("currval");
		rsLastId.close();


		this.insertItemOfFluxRss(new ItemOfFluxRss(fluxRSS.getLink(),lastId));
		this.updateFluxRss(fluxRSS.getLink(), lastId);
	}

	public void insertFluxRSSItem(List<RSSItem> rssItems, FluxRSS fluxRSS) throws SQLException
	{
		for (RSSItem rssItem : rssItems)
			this.insertFluxRSSItem(rssItem, fluxRSS);
	}

	public void resetNbRequest()
	{
		this.nbRequest = 0;
	}

	public int getNbRequest()
	{
		return nbRequest;
	}
}
