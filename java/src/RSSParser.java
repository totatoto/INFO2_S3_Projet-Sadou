import java.net.URL;
import java.net.URLConnection;
import java.net.URI;
import java.net.MalformedURLException;
import java.net.URISyntaxException;
import java.security.cert.X509Certificate;
import java.io.IOException;
import java.io.InputStream;
import java.io.FileInputStream;
import java.util.Scanner;
import java.util.ArrayList;
import java.util.List;
import java.util.Locale;
import java.util.Map;
import java.util.HashMap;
import javax.net.ssl.HttpsURLConnection;
import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.SSLContext;
import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.ParserConfigurationException;
import org.xml.sax.SAXException;
import org.w3c.dom.Document;
import org.w3c.dom.NodeList;
import org.w3c.dom.Node;
import java.sql.Timestamp;
import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.text.ParseException;

public class RSSParser {

	private static DocumentBuilderFactory factory;
	private static DocumentBuilder builder;

	private static Map<String, List<String>> MAP_CORRESP;

	private static SimpleDateFormat PARSE_DATE_FORMAT;

	static {
		PARSE_DATE_FORMAT = new SimpleDateFormat("EEE, d MMM yyyy HH:mm:ss Z", Locale.ENGLISH);
		MAP_CORRESP = new HashMap<>();

		List<String> listRss = new ArrayList<>();
		listRss.add("rss");
		MAP_CORRESP.put("rss",listRss);

		List<String> listChannel = new ArrayList<>();
		listChannel.add("channel");
		listChannel.add("feed");
		MAP_CORRESP.put("channel",listChannel);

		List<String> listItem = new ArrayList<>();
		listItem.add("item");
		listItem.add("entry");
		MAP_CORRESP.put("item",listItem);

		List<String> listLink = new ArrayList<>();
		listLink.add("link");
		listLink.add("feedburner:origLink");
		MAP_CORRESP.put("link",listLink);

		List<String> listTitle = new ArrayList<>();
		listTitle.add("title");
		MAP_CORRESP.put("title",listTitle);

		List<String> listDate1 = new ArrayList<>();
		listDate1.add("dc:date");
		listDate1.add("updated");
		MAP_CORRESP.put("date1",listDate1);

		List<String> listDate2 = new ArrayList<>();
		listDate2.add("pubDate");
		MAP_CORRESP.put("date2",listDate2);


		factory = DocumentBuilderFactory.newInstance();
		try
		{
			builder = factory.newDocumentBuilder();
		}
		catch (final ParserConfigurationException e)
		{
			e.printStackTrace();
			builder = null;
		}
	}

	private static InputStream getInputStreamFromUri(URI uri) {
		InputStream stream = null;

		try {
			URL url = uri.toURL();
			URLConnection conn = url.openConnection();

			if (conn instanceof HttpsURLConnection) {

				TrustManager[] trustAllCerts = new TrustManager[] { new X509TrustManager() {
		            public java.security.cert.X509Certificate[] getAcceptedIssuers() { return null; }
		            public void checkClientTrusted(X509Certificate[] certs, String authType) { }
		            public void checkServerTrusted(X509Certificate[] certs, String authType) { }

		        } };

				SSLContext sc = SSLContext.getInstance("SSL");
		        sc.init(null, trustAllCerts, new java.security.SecureRandom());
		        HttpsURLConnection.setDefaultSSLSocketFactory(sc.getSocketFactory());
				HttpsURLConnection.setDefaultHostnameVerifier(new MyHostnameVerifier());

				HttpsURLConnection conn1 = (HttpsURLConnection) url.openConnection();

				stream = conn1.getInputStream();
			}
			else
			{
				stream = url.openStream();
			}
		} catch (MalformedURLException e) {
		   e.printStackTrace();
		} catch (IOException e) {
		   e.printStackTrace();
	   } catch (Exception e)
	   {
		   e.printStackTrace();
	   }

		return stream;
	}

	private static Document parseXMLInputStreamToDOM(InputStream is)
	{
		Document document = null;

		try {
			document = RSSParser.builder.parse(is);
		} catch(IOException e) {
			e.printStackTrace();
		} catch(SAXException e) {
			e.printStackTrace();
		} catch(IllegalArgumentException e) {
			e.printStackTrace();
		}

		return document;
	}

	private static List<RSSItem> parseDocumentToRSSItemList(Document document)
	{
		List<RSSItem> listRssItem = new ArrayList<RSSItem>();

		NodeList nodeList = document.getChildNodes();

		int i = 0;
		while (i < nodeList.getLength() && ! RSSParser.MAP_CORRESP.get("rss").contains(nodeList.item(i).getNodeName()) && ! RSSParser.MAP_CORRESP.get("channel").contains(nodeList.item(i).getNodeName())) {i++;}

		Node channel = null;
		if (i == nodeList.getLength())
			throw new IndexOutOfBoundsException();

		if (RSSParser.MAP_CORRESP.get("rss").contains(nodeList.item(i).getNodeName()))
		{
			Node rss = nodeList.item(i);
			NodeList nodeRss = rss.getChildNodes();

			i = 0;
			while (i < nodeRss.getLength() && ! RSSParser.MAP_CORRESP.get("channel").contains(nodeRss.item(i).getNodeName())) {i++;}

			if (i == nodeRss.getLength())
				throw new IndexOutOfBoundsException();

			channel = nodeRss.item(i);
		}
		else
		{
			channel = nodeList.item(i);
		}

		NodeList nodeChannel = channel.getChildNodes();


		for (int a = 0; a < nodeChannel.getLength() ; a++)
		{
			Node currentNode = nodeChannel.item(a);
			if (RSSParser.MAP_CORRESP.get("item").contains(currentNode.getNodeName()))
			{
				NodeList nodeListItem = currentNode.getChildNodes();

				String title = null;
				String link = null;
				Timestamp pubDate = null;

				for (int b = 0; b < nodeListItem.getLength() ; b++)
				{
					Node itemInformation = nodeListItem.item(b);

					String name = itemInformation.getNodeName();

					if (RSSParser.MAP_CORRESP.get("link").contains(name))
						if (link == null)
							link = itemInformation.getTextContent();

					if (RSSParser.MAP_CORRESP.get("title").contains(name))
						if (title == null)
							title = itemInformation.getTextContent();

					if (RSSParser.MAP_CORRESP.get("date1").contains(name))
						if (pubDate == null)
						{
							String timestampString = itemInformation.getTextContent();
							timestampString = timestampString.replaceAll("T"," ").substring(0,19);
							pubDate = Timestamp.valueOf(timestampString);
						}

					if (RSSParser.MAP_CORRESP.get("date2").contains(name))
						if (pubDate == null)
						{
							try
							{
								pubDate = new Timestamp(PARSE_DATE_FORMAT.parse(itemInformation.getTextContent()).getTime());
							} catch (ParseException e) { e.printStackTrace();}
						}

				}
				
				while(title.startsWith(" ") || title.startsWith("\t") || title.startsWith("\n")) {title = title.substring(1);}

				listRssItem.add(new RSSItem(title, link, pubDate));

			}
		}

		return listRssItem;
	}

	public static List<RSSItem> getRssItems(URI uri)
	{
		return parseDocumentToRSSItemList(parseXMLInputStreamToDOM(getInputStreamFromUri(uri)));
	}

	public static List<RSSItem> getNewRssItems(FluxRSS fluxRss) throws URISyntaxException
	{
		return getNewRssItems(fluxRss.getLink());
	}

	public static List<RSSItem> getNewRssItems(String link) throws URISyntaxException
	{
		List<RSSItem> rssItems = null;
		try{
			rssItems = getRssItems(new URI(link));
			RSSItem.sort(rssItems, RSSItem.SORT_RECEDING);

			Database db = Database.getInstance();
			FluxRSS fluxRSS = db.getFluxRSS(link);

			if (fluxRSS.getIdLastRss() != 0)
			{
				RSSItem lastRssItem = db.getRSSItem(fluxRSS.getIdLastRss());
				int i = 0;
				while (i < rssItems.size() && !rssItems.get(i).equals(lastRssItem))
				{
					i++;
				}

				if (i != rssItems.size())
					rssItems = rssItems.subList(0,i);
			}
		} catch (SQLException e) {e.printStackTrace();}


		RSSItem.sort(rssItems, RSSItem.SORT_RISING);

		return rssItems;
	}

	public static void main(String[] args)
	{
		try {
			Database db = Database.getInstance();
			//System.out.println(getNewRssItems("http://feeds.feedburner.com/phoenixjp/CWoG?format=xml").size());
			//System.out.println(parseDocumentToRSSItemList(parseXMLInputStreamToDOM(RSSParser.getInputStreamFromUri(new URI("http://feeds.feedburner.com/phoenixjp/CWoG?format=xml")))).size());
			//System.out.println(parseXMLInputStreamToDOM(RSSParser.getInputStreamFromUri(new URI("http://feeds.feedburner.com/phoenixjp/CWoG?format=xml"))).getChildNodes().item(2).getNodeName());
			//System.out.println(db.getRSSItem(383));
			//System.out.println(db.getRSSItem(982));
			//System.out.println(db.getRSSItem(383).equals(db.getRSSItem(982)));
			System.out.println(parseXMLInputStreamToDOM(new FileInputStream("all-rss-feed.xml")).getChildNodes().item(0).getChildNodes().getLength());
		}
		catch (Exception e) {
		   e.printStackTrace();
		}
	}
}
