import java.net.URL;
import java.net.URI;
import java.net.MalformedURLException;
import java.net.URISyntaxException;
import java.io.IOException;
import java.io.InputStream;
import java.util.Scanner;

public class RSSParser {
	
	public static InputStream getInputStreamFromUri(URI uri) {
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
	
	public static void main(String[] args)
	{
		try {
			Scanner sc =new Scanner(RSSParser.getInputStreamFromUri(new URI("https://www.google.fr")));
			
			while (sc.hasNextLine())
			{
				System.out.println(sc.nextLine());
				
			}
		}
		catch (URISyntaxException e) {
		   e.printStackTrace();
		}
	}
}