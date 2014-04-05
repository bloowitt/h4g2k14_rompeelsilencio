package org.h4k14.rompetusilencio;

import android.content.Context;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.preference.PreferenceManager;

public class Prefs {

	private static final String WELCOME_MSG = "WELCOME_MSG";
	
	public static final boolean DEFAULT_WELCOME_MSG_SHOWN = false;
	public static final boolean DEFAULT_PRIVATE_MODE = false;
	
	private SharedPreferences _prefs = null;
	private Editor _editor = null;
	
	public Prefs(Context context){
		_prefs = PreferenceManager.getDefaultSharedPreferences(context); 
		_editor = _prefs.edit();
	}

	// métodos para acceder a las preferencias
	
	public void save(){
		if (_editor != null)
			_editor.commit();
	}

	public boolean isWelcomeMsgShown() {
		try {
			return _prefs.getBoolean(WELCOME_MSG, DEFAULT_WELCOME_MSG_SHOWN);
		} catch (Exception e) {
			return DEFAULT_WELCOME_MSG_SHOWN;
		}
	}

	public void setWelcomeMsgShown(Boolean b) {
		if (b == null)
			_editor.remove(WELCOME_MSG);
		else
			_editor.putBoolean(WELCOME_MSG, b);
	}

}
