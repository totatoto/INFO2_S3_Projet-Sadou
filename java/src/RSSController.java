import java.util.List;
import java.util.Map;
import java.util.HashMap;
import java.sql.SQLException;
import java.net.URISyntaxException;

public class RSSController
{
    public static final int TIME_BETWEEN_TWO_UPDATE = 120000; // 2 minutes

    private int timeBetweenTwoUpdate;

    private boolean stop;

    private Thread runner;

    public static Map<FluxRSS,List<RSSItem>> updateAllRss() throws SQLException, URISyntaxException
    {
		Map<FluxRSS,List<RSSItem>> mapUpdate = new HashMap<FluxRSS,List<RSSItem>>();

        Database db = Database.getInstance();

        List<FluxRSS> listFluxRss = db.getFluxRSS();

        for (FluxRSS fluxRss : listFluxRss)
        {
            mapUpdate.put(fluxRss, RSSController.updateRss(fluxRss));
        }

		return mapUpdate;
    }

    public static List<RSSItem> updateRss(FluxRSS fluxRss) throws SQLException, URISyntaxException
    {
        List<RSSItem> listNewRssItem = RSSParser.getNewRssItems(fluxRss);
        RSSItem.calcImportance(listNewRssItem);

        Database.getInstance().insertFluxRSSItem(listNewRssItem, fluxRss);

		return listNewRssItem;
    }

    public RSSController(int timeBetweenTwoUpdate)
    {
        this.timeBetweenTwoUpdate = timeBetweenTwoUpdate;
        this.stop = false;
        this.runner = null;
    }

    public boolean init()
    {
        if (this.runner != null)
            return false;

        this.runner = new Runner(this);
        return true;
    }

    public boolean start()
    {
        if (this.runner == null)
            return false;

        this.stop = false;
        this.runner.start();

        return true;
    }

    public void stop()
    {
        this.stop = true;
    }

    public void updated(Map<FluxRSS,List<RSSItem>> updates)
    {
        System.out.println("updated");
		for (FluxRSS fluxRss : updates.keySet())
		{
			System.out.println(fluxRss.getLink() + " : " + updates.get(fluxRss).size());
		}
    }

    public void failure(Exception e)
    {
        this.stop = true;
        System.out.println("failure : " + e.toString());
    }

    public boolean isStoped()
    {
        return this.stop;
    }

    public int getTimeBetweenTwoUpdate()
    {
        return this.timeBetweenTwoUpdate;
    }



    public static void main(String[] args)
    {
        RSSController controller = new RSSController(RSSController.TIME_BETWEEN_TWO_UPDATE);
        controller.init();
        controller.start();
    }
}

class Runner extends Thread
{
    private RSSController rssController;

    public Runner(RSSController rssController)
    {
        super();
        this.rssController = rssController;
    }

    @Override
    public void run()
    {
        try{
            do{
				System.out.println("starting update");
				Database.getInstance().resetNbRequest();

                Map<FluxRSS,List<RSSItem>> updates = RSSController.rssController.updateAllRss();

                this.rssController.updated(updates);
				System.out.println("number of request : " + Database.getInstance().getNbRequest());

                Thread.sleep(this.rssController.getTimeBetweenTwoUpdate());
            } while (!this.rssController.isStoped());
        } catch(Exception e) {this.rssController.failure(e);}
    }
}
