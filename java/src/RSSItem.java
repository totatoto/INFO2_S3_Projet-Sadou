import java.sql.Timestamp;
import java.util.List;
import java.util.Comparator;
import java.sql.Array;
import java.sql.SQLException;

public class RSSItem {
	
	public static final int SORT_RISING = 0;
	public static final int SORT_RECEDING = 1;
	
	private int id;
	private String title;
	private String link;
	private Timestamp pubDate;
	private String description;
	private String[] category;
	private int importance;
	
	public static void calcImportance(List<RSSItem> listRssItem)
	{
		for (RSSItem rssItem : listRssItem)
		{
			rssItem.importance = 0;
		}
	}
	
	public static void sort(List<RSSItem> listRssItem, int type)
	{
		listRssItem.sort(new RSSItemComparator(type));
	}
	
	public RSSItem (String title, String link, Timestamp pubDate, String description) throws SQLException
	{
		this(title, link, pubDate, description, (String[]) null);
	}
	
	public RSSItem (String title, String link, Timestamp pubDate, String description, Array category) throws SQLException
	{
		this(-1, title, link, pubDate, description, category, -1);
	}
	
	public RSSItem (String title, String link, Timestamp pubDate, String description, String[] category) throws SQLException
	{
		this(-1, title, link, pubDate, description, category, -1);
	}
	
	public RSSItem (int id, String title, String link, Timestamp pubDate, String description, Array category, int importance) throws SQLException
	{
		this(id, title, link, pubDate, description, (String[])(category == null ? null : category.getArray()), importance);
	}
	
	public RSSItem (int id, String title, String link, Timestamp pubDate, String description, String[] category, int importance) throws SQLException
	{
		System.out.println(link + "::" + category);
		this.id = id;
		this.title = title;
		this.link = link;
		this.pubDate = pubDate;
		this.description = description;
		this.category = category;
		this.importance = importance;
	}
	
	public int getId()
	{
		return this.id;
	}
	
	public String getTitle()
	{
		return this.title;
	}
	
	public String getLink()
	{
		return this.link;
	}
	
	public Timestamp getPubDate()
	{
		return this.pubDate;
	}
	
	public String getDescription()
	{
		return this.description;
	}
	
	public String[] getCategory()
	{
		return this.category;
	}
	
	public int getImportance()
	{
		return this.importance;
	}
	
	public boolean equals(RSSItem rssItem)
	{
		return this.getLink().equals(rssItem.getLink());
	}
	
	public String toString()
	{
		String sRet = "";
		sRet += "id : " + this.id + "\n";
		sRet += "title : " + this.title + "\n";
		sRet += "link : " + this.link + "\n";
		sRet += "pubDate : " + this.pubDate + "\n";
		sRet += "description : " + this.description + "\n";
		sRet += "importance : " + this.importance + "\n";
		
		return sRet;
	}
}

class RSSItemComparator implements Comparator<RSSItem> {
	
	private int type;
	
	RSSItemComparator(int type)
	{
		this.type = type;
	}
	
	@Override
	public int compare(RSSItem rssItem1, RSSItem rssItem2)
	{
		if (rssItem1 == null || rssItem2 == null)
			return 0;
		
		if (type == RSSItem.SORT_RISING)
			return rssItem1.getPubDate().compareTo(rssItem2.getPubDate());
		
		return rssItem2.getPubDate().compareTo(rssItem1.getPubDate());
	}
}