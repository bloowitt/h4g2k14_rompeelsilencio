package org.h4k14.rompetusilencio.net;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.h4k14.rompetusilencio.domain.Case;

import android.content.Context;
import android.provider.Settings.Secure;

public class APIManager {

	public static String API_URL = "http://130.206.82.212/";
	
	public Context c;
	
	public APIManager(Context c) {
		this.c = c;
	}
	
	
	public List<Case> listCases() throws Exception {
		HttpPost httppost = new HttpPost(API_URL+"/case/list");
		try{
			String id_mobile = Secure.getString(c.getContentResolver(),Secure.ANDROID_ID);
			
			List<NameValuePair> data = new ArrayList<NameValuePair>();
			data.add(new BasicNameValuePair("id_mobile", id_mobile));
					
			httppost.setEntity(new UrlEncodedFormEntity(data,"UTF-8"));
			DefaultHttpClient client = new DefaultHttpClient();
			HttpResponse response = client.execute(httppost);
			
			if (response.getStatusLine().getStatusCode() != 200){
				throw new Exception("Error status code: " + response.getStatusLine().getStatusCode());
			}
			
			return Case.parseJsonCaseList(EntityUtils.toString(response.getEntity()));
			
		} catch (IOException e) {
			throw new Exception("There has been an error receiving data from the server.",e);
		}
	}


	public void sendNewCase(String string) throws Exception {
		HttpPost httppost = new HttpPost(API_URL+"/case/create");
		try{
			String id_mobile = Secure.getString(c.getContentResolver(),Secure.ANDROID_ID);
			
			List<NameValuePair> data = new ArrayList<NameValuePair>();
			data.add(new BasicNameValuePair("id_mobile", id_mobile));
			data.add(new BasicNameValuePair("text", string));
					
			httppost.setEntity(new UrlEncodedFormEntity(data,"UTF-8"));
			DefaultHttpClient client = new DefaultHttpClient();
			HttpResponse response = client.execute(httppost);
			
			if (response.getStatusLine().getStatusCode() != 200){
				throw new Exception("Error status code: " + response.getStatusLine().getStatusCode());
			}
			
		} catch (IOException e) {
			throw new Exception("There has been an error receiving data from the server.",e);
		}
	}

}
