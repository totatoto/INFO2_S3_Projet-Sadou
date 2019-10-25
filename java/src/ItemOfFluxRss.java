public class ItemOfFluxRss {
	private String linkFluxRss;
	private int idRssItem;
	
	public ItemOfFluxRss (String linkFluxRss, int idRssItem) {
		this.linkFluxRss = linkFluxRss;
		this.idRssItem = idRssItem;
	}
	
	public String getLinkFluxRss() {
		return this.linkFluxRss;
	}
	
	public int getIdRssItem() {
		return this.idRssItem;
	}
}