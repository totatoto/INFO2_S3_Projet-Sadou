import java.util.List;
import java.util.Map;
import java.util.HashMap;
import java.sql.SQLException;
import java.net.URISyntaxException;

public class RSSController
{
    public static final int TIME_BETWEEN_TWO_UPDATE = 120000; // 2 minutes
    public static final int NB_UPDATE = -1;

    private int timeBetweenTwoUpdate;

    private int stop;

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
        if (listNewRssItem != null)
        {
            RSSItem.calcImportance(listNewRssItem);

            Database.getInstance().insertFluxRSSItem(listNewRssItem, fluxRss);
        }

		return listNewRssItem;
    }

    public RSSController(int timeBetweenTwoUpdate)
    {
        this.timeBetweenTwoUpdate = timeBetweenTwoUpdate;
        this.stop = -1;
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
        return this.start(-1);
    }

    public boolean start(int nbTour)
    {
        if (this.runner == null)
            return false;

        this.stop = nbTour;
        this.runner.start();

        return true;
    }

    public void stop()
    {
        this.stop = 0;
    }

    public void updated(Map<FluxRSS,List<RSSItem>> updates)
    {
        System.out.println("updated");
		for (FluxRSS fluxRss : updates.keySet())
		{
			System.out.println("\t" + fluxRss.getLink() + " : " + (updates.get(fluxRss) == null ? "error" : updates.get(fluxRss).size()));
		}

        if (this.stop > 0)
            this.stop--;
    }

    public void failure(Exception e)
    {
        this.stop();
        System.out.println("failure : " + e.toString());
		e.printStackTrace();
    }

    public boolean isStoped()
    {
        return this.stop == 0;
    }

    public int getTimeBetweenTwoUpdate()
    {
        return this.timeBetweenTwoUpdate;
    }



    public static void main(String[] args)
    {
        int nbUpdate = RSSController.NB_UPDATE;
        int timeBetweenTwoUpdate = RSSController.TIME_BETWEEN_TWO_UPDATE;
        if (args.length > 0 && args[0].matches("[0-9]+"))
        {
            try
            {
                nbUpdate = Integer.parseInt(args[0]);
            } catch (Exception e) {e.printStackTrace();}
        }
        if (args.length > 1 && args[1].matches("[0-9]+"))
        {
            try
            {
                timeBetweenTwoUpdate = Integer.parseInt(args[1]);
            } catch (Exception e) {e.printStackTrace();}
        }

        RSSController controller = new RSSController(timeBetweenTwoUpdate);
        controller.init();
        controller.start(nbUpdate);
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
            while (!this.rssController.isStoped()){
				System.out.println("starting update");
				Database.getInstance().resetNbRequest();

                Map<FluxRSS,List<RSSItem>> updates = RSSController.updateAllRss();

                this.rssController.updated(updates);
				System.out.println("number of request : " + Database.getInstance().getNbRequest());

                if (!this.rssController.isStoped())
                    Thread.sleep(this.rssController.getTimeBetweenTwoUpdate());
            }
        } catch(Exception e) {this.rssController.failure(e);}
    }
}
