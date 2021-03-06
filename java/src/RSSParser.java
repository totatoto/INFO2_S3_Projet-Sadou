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
	private static Map<String, List<String>> MAP_CORRESP_CATEGORY;

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

		List<String> listDescription = new ArrayList<>();
		listDescription.add("description");
		listDescription.add("summary");
		MAP_CORRESP.put("description",listDescription);

		List<String> listCategory = new ArrayList<>();
		listCategory.add("category");
		MAP_CORRESP.put("category",listCategory);


		MAP_CORRESP_CATEGORY = new HashMap<>();

		List<String> listCategoryCybersecurity = new ArrayList<>();
		listCategoryCybersecurity.add("cybersecurity");
		listCategoryCybersecurity.add("hacking");
		listCategoryCybersecurity.add("virus");
		listCategoryCybersecurity.add("piratage");
		listCategoryCybersecurity.add("phishing");
		listCategoryCybersecurity.add("securite informatique");
		listCategoryCybersecurity.add("cyberattaque");
		listCategoryCybersecurity.add("vulnérabilités");
		listCategoryCybersecurity.add("rançongiciels");
		listCategoryCybersecurity.add("rançonnage");
		listCategoryCybersecurity.add("ransmware");
		listCategoryCybersecurity.add("malware");
		listCategoryCybersecurity.add("Firewall");
		listCategoryCybersecurity.add("Antivirus");
		MAP_CORRESP_CATEGORY.put("cybersecurity",listCategoryCybersecurity);



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

				conn = (HttpsURLConnection) url.openConnection();


			}

			conn.addRequestProperty("User-Agent", "");

			stream = conn.getInputStream();
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

	private static List<RSSItem> parseDocumentToRSSItemList(Document document) throws SQLException
	{
		List<RSSItem> listRssItem = new ArrayList<RSSItem>();

		if (document == null)
			return null;

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
				String description = null;
				List<String> category = null;

				for (int b = 0; b < nodeListItem.getLength() ; b++)
				{
					Node itemInformation = nodeListItem.item(b);

					String name = itemInformation.getNodeName();

					if (RSSParser.MAP_CORRESP.get("link").contains(name))
						if (link == null)
						{
							link = itemInformation.getTextContent();
							if (link.equals("") && itemInformation.hasAttributes())
								link = itemInformation.getAttributes().getNamedItem("href").getTextContent();
						}

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

					if (RSSParser.MAP_CORRESP.get("description").contains(name))
						if (description == null)
							description = itemInformation.getTextContent();

					if (RSSParser.MAP_CORRESP.get("category").contains(name))
					{
						if (category == null)
							category = new ArrayList<>();

						category.add(itemInformation.getTextContent());
					}

				}

				title = title.trim();

				if (description != null)
					description = description.trim();

				listRssItem.add(new RSSItem(title, link, pubDate, description, (String[])(category == null ? null : category.toArray(new String[0]))));

			}
		}

		return listRssItem;
	}

	public static List<RSSItem> getRssItems(URI uri) throws SQLException
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


			RSSItem.sort(rssItems, RSSItem.SORT_RISING);
		}
		catch (SQLException e) {e.printStackTrace();}
		catch (Exception e) {e.printStackTrace();}

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
