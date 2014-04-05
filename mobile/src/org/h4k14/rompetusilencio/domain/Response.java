package org.h4k14.rompetusilencio.domain;

import org.json.JSONException;
import org.json.JSONObject;

public class Response {

	private int author;
	private long timestamp;
	private String text;
	public int getAuthor() {
		return author;
	}
	public void setAuthor(int author) {
		this.author = author;
	}
	public long getTimestamp() {
		return timestamp;
	}
	public void setTimestamp(long timestamp) {
		this.timestamp = timestamp;
	}
	public String getText() {
		return text;
	}
	public void setText(String text) {
		this.text = text;
	}
	public static Response parseJsonResponse(JSONObject jsonResponse) throws JSONException {
		Response r = new Response();
		r.author = jsonResponse.getInt("author");
		r.timestamp = jsonResponse.getLong("ts");
		r.text = jsonResponse.getString("text");
		return r;
	}
	
}
