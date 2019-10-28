import java.sql.Timestamp;
import java.util.List;
import java.util.Comparator;

public class RSSItem {
	
	public static final int SORT_RISING = 0;
	public static final int SORT_RECEDING = 1;
	
	private int id;
	private String title;
	private String link;
	private Timestamp pubDate;
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
	
	public RSSItem (String title, String link, Timestamp pubDate)
	{
		this(-1, title, link, pubDate, -1);
	}
	
	public RSSItem (int id, String title, String link, Timestamp pubDate, int importance) {
		this.id = id;
		this.title = title;
		this.link = link;
		this.pubDate = pubDate;
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
		if (type == RSSItem.SORT_RISING)
			return rssItem1.getPubDate().compareTo(rssItem2.getPubDate());
		
		return rssItem2.getPubDate().compareTo(rssItem1.getPubDate());
	}
}