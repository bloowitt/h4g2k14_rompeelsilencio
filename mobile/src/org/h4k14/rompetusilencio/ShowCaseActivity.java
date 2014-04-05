package org.h4k14.rompetusilencio;

import java.util.LinkedList;
import java.util.List;

import org.h4k14.rompetusilencio.domain.Response;
import org.h4k14.rompetusilencio.net.APIManager;
import org.h4k14.rompetusilencio.ui.ResponseAdapter;

import android.app.AlertDialog;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.app.ActionBarActivity;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

public class ShowCaseActivity extends ActionBarActivity {

	public static final String IDENTIFICATOR = "identificator";
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_show_case);

		if (savedInstanceState == null) {
			getSupportFragmentManager().beginTransaction()
					.add(R.id.container, new PlaceholderFragment()).commit();
		}
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {

		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.show_case, menu);
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// Handle action bar item clicks here. The action bar will
		// automatically handle clicks on the Home/Up button, so long
		// as you specify a parent activity in AndroidManifest.xml.
		int id = item.getItemId();
		if (id == R.id.action_settings) {
			return true;
		}
		return super.onOptionsItemSelected(item);
	}

	/**
	 * A placeholder fragment containing a simple view.
	 */
	public static class PlaceholderFragment extends Fragment {

		private List<Response> responses;
		private ResponseAdapter responseAdapter;
		private ListView list;
		private String caseIdentificator;
		
		public PlaceholderFragment() {
		}

		@Override
		public View onCreateView(LayoutInflater inflater, ViewGroup container,
				Bundle savedInstanceState) {
			View rootView = inflater.inflate(R.layout.fragment_show_case,
					container, false);
			
			caseIdentificator = getActivity().getIntent().getExtras().getString(IDENTIFICATOR);
			responses = new LinkedList<Response>();
			responseAdapter = new ResponseAdapter(getActivity(),responses);
			list = (ListView) rootView.findViewById(R.id.responses);
			list.setAdapter(responseAdapter);
			
			return rootView;
		}
		
		@Override
		public void onResume() {
			super.onResume();
			try {
				APIManager apiManager = new APIManager(getActivity());
				List<Response> remoteResponses = apiManager.getResponses(caseIdentificator);
				responses.clear();
				responses.addAll(remoteResponses);
				responseAdapter.notifyDataSetChanged();
			} catch (Exception e) {
				AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
				builder.setTitle(R.string.error);
				builder.setMessage(e.getLocalizedMessage());
				builder.show();
			}
		}
	}

}
