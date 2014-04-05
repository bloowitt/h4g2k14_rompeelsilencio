package org.h4k14.rompetusilencio.domain;

import java.util.LinkedList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class Case {

	private String identifier;
	private String resume;
	private String timestamp;
	
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
	public String getTimestamp() {
		return timestamp;
	}
	public void setTimestamp(String timestamp) {
		this.timestamp = timestamp;
	}
	
	public static List<Case> parseJsonCaseList(String string) throws JSONException {
		List<Case> cases = new LinkedList<Case>();
		JSONArray jsonCases = new JSONArray(string);
		
		for (int i = 0; i< jsonCases.length(); i++) {
			JSONObject jsonCase = jsonCases.getJSONObject(i);
			Case c = new Case();
			c.setIdentifier(jsonCase.getString("identificator"));
			c.setResume(jsonCase.getString("summary"));
			c.setTimestamp(jsonCase.getString("ts"));
		}
		return cases;
	}
	
}
