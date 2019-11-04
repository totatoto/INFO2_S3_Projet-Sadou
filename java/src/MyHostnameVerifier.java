import javax.net.ssl.HostnameVerifier;
import javax.net.ssl.SSLSession;
import javax.net.ssl.HttpsURLConnection;

public class MyHostnameVerifier implements HostnameVerifier
{
	@Override
	public boolean verify(String hostname, SSLSession session)
	{
		System.out.println("je suis là !");
		System.out.println(HttpsURLConnection.getDefaultHostnameVerifier().verify(hostname, session));
		if (HttpsURLConnection.getDefaultHostnameVerifier().verify(hostname, session))
			return true;
		
		return true;
	}
}