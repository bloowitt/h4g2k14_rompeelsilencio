package org.h4k14.rompetusilencio.domain;

import java.util.LinkedList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class Case {

	private String identifier;
	private String resume;
	private long timestamp;
	private List<Response> responses = new LinkedList<Response>();
	
	public String getIdentifier() {
		return identifier;
	}
	public void setIdentifier(String identifier) {
		this.identifier = identifier;
	}
	public String getResume() {
		return resume;
	}
	public void setResume(String resume) {
		this.resume = resume;
	}
	public long getTimestamp() {
		return timestamp;
	}
	public void setTimestamp(long timestamp) {
		this.timestamp = timestamp;
	}
	public List<Response> getResponses() {
		return responses;
	}
	public void setResponses(List<Response> responses) {
		this.responses = responses;
	}
	public long getLatestResponseTimeStamp() {
		long t = 0;
		for (Response r : responses) {
			if (t < r.getTimestamp()) t = r.getTimestamp();
		}
		return t;
	}
	
	public static List<Case> parseJsonCaseList(String string) throws JSONException {
		List<Case> cases = new LinkedList<Case>();
		JSONArray jsonCases = new JSONArray(string);
		
		for (int i = 0; i< jsonCases.length(); i++) {
			JSONObject jsonCase = jsonCases.getJSONObject(i);
			Case c = new Case();
			c.setIdentifier(jsonCase.getString("identifier"));
			c.setResume(jsonCase.getString("resume"));
			c.setTimestamp(jsonCase.getLong("ts"));
			cases.add(c);
			
			JSONArray jsonResponses = jsonCase.getJSONArray("responses");
			for (int r = 0; r < jsonResponses.length(); r++) {
				JSONObject jsonResponse = jsonResponses.getJSONObject(r);
				c.responses.add(Response.parseJsonResponse(jsonResponse));
			}
		}
		return cases;
	}
	
}
