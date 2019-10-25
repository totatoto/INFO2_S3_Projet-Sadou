import java.net.URL;
import java.net.URI;
import java.net.MalformedURLException;
import java.net.URISyntaxException;
import java.io.IOException;
import java.io.InputStream;
import java.util.Scanner;
import java.util.ArrayList;
import java.util.List;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.ParserConfigurationException;
import org.xml.sax.SAXException;
import org.w3c.dom.Document;
import org.w3c.dom.NodeList;
import org.w3c.dom.Node;
import java.sql.Timestamp;

public class RSSParser {
	
	private static DocumentBuilderFactory factory;
	private static DocumentBuilder builder;
	
	static {
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
			stream = url.openStream();
		} catch (MalformedURLException e) {
		   e.printStackTrace();
		} catch (IOException e) {
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
		while (i < nodeList.getLength() && ! nodeList.item(i).getNodeName().equals("rss")) {i++;}
		
		if (i == nodeList.getLength())
			throw new IndexOutOfBoundsException();
		
		Node rss = nodeList.item(i);
		NodeList nodeRss = rss.getChildNodes();
		
		i = 0;
		while (i < nodeRss.getLength() && ! nodeRss.item(i).getNodeName().equals("channel")) {i++;}
		
		if (i == nodeRss.getLength())
			throw new IndexOutOfBoundsException();
		
		Node channel = nodeRss.item(i);
		NodeList nodeChannel = channel.getChildNodes();
		
		
		for (int a = 0; a < nodeChannel.getLength() ; a++)
		{
			Node currentNode = nodeChannel.item(a);
			if (currentNode.getNodeName().equals("item"))
			{
				NodeList nodeListItem = currentNode.getChildNodes();
				
				String title = null;
				String link = null;
				Timestamp pubDate = null;
				
				for (int b = 0; b < nodeListItem.getLength() ; b++)
				{
					Node itemInformation = nodeListItem.item(b);
					
					switch (itemInformation.getNodeName())
					{
						case "feedburner:origLink" :
							if (link == null)
								link = itemInformation.getTextContent();
							break;
						case "link" :
							if (link == null)
								link = itemInformation.getTextContent();
							break;
						case "title" :
							if (title == null)
								title = itemInformation.getTextContent();
							break;
						case "dc:date" :
							if (pubDate == null)
							{
								String timestampString = itemInformation.getTextContent();
								timestampString = timestampString.replaceAll("T"," ").substring(0,19);
								pubDate = Timestamp.valueOf(timestampString);
							}
							break;
					}
					
				}
				
				listRssItem.add(new RSSItem(title, link, pubDate));
				
			}
		}
		
		return listRssItem;
	}
	
	public static List<RSSItem> getRssItems(URI uri)
	{
		return parseDocumentToRSSItemList(parseXMLInputStreamToDOM(getInputStreamFromUri(uri)));
	}
	
	public static List<RSSItem> getNewRssItems(String link)
	{
		List<RSSItem> rssItems = getRssItems(new URI(link));
		RSSItem.sort(rssItems);
		
		Database db = Database.getInstance();
		FluxRSS fluxRSS = db.getFluxRSS(link);
		RSSItem lastRssItem = db.getRSSItem(fluxRSS.getIdLastRss());
		
		int i = 0;
		while (i < rssItems.size() && !rssItems.get(i).equals(lastRssItem))
		{
			i++
		}
		
		if (i != rssItems.size())
			rssItems.subList(0,i);
		
		return rssItems;
	}
	
	public static void main(String[] args)
	{
		try {
			getNewRssItems("http://feeds.feedburner.com/phoenixjp/CWoG?format=xml");
			//System.out.println(parseDocumentToRSSItemList(parseXMLInputStreamToDOM(RSSParser.getInputStreamFromUri(new URI("http://feeds.feedburner.com/phoenixjp/CWoG?format=xml")))).size());
			//System.out.println(parseXMLInputStreamToDOM(RSSParser.getInputStreamFromUri(new URI("http://feeds.feedburner.com/phoenixjp/CWoG?format=xml"))).getChildNodes().item(2).getNodeName());
		}
		catch (URISyntaxException e) {
		   e.printStackTrace();
		}
	}
}