public class FluxRSS {
	
	private String link;
	private int idLastRss;
	
	public FluxRSS (String link, int idLastRss)
	{
		this.link = link;
		this.idLastRss = idLastRss;
	}
	
	public String getLink()
	{
		return this.link;
	}
	
	public int getIdLastRss()
	{
		return this.idLastRss;
	}
}