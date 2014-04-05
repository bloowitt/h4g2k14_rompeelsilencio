package org.h4k14.rompetusilencio;

import java.util.Collections;
import java.util.Comparator;
import java.util.LinkedList;
import java.util.List;

import org.h4k14.rompetusilencio.domain.Case;
import org.h4k14.rompetusilencio.net.APIManager;
import org.h4k14.rompetusilencio.ui.CaseAdapter;

import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v7.app.ActionBarActivity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.Button;
import android.widget.ListView;

public class CaseListActivity extends ActionBarActivity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_case_list);

		if (savedInstanceState == null) {
			getSupportFragmentManager().beginTransaction()
					.add(R.id.container, new PlaceholderFragment()).commit();
		}
	}

	/**
	 * A placeholder fragment containing a simple view.
	 */
	public static class PlaceholderFragment extends Fragment {

		private ListView caseList;
		private CaseAdapter caseAdapter;
		private LinkedList<Case> cases;
		
		@Override
		public void onResume() {
			super.onResume();
			try {
				APIManager apiManager = new APIManager(getActivity());
				List<Case> remoteCases = apiManager.listCases();
				this.cases.clear();
				this.cases.addAll(remoteCases);
				Collections.sort(this.cases, new Comparator<Case> () {
	
					@Override
					public int compare(Case lhs, Case rhs) {
						return lhs.getTimestamp().compareTo(rhs.getTimestamp());
					}
					
				});
				caseAdapter.notifyDataSetChanged();
			} catch (Exception e) {
				AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
				builder.setTitle(R.string.error);
				builder.setMessage(e.getLocalizedMessage());
				builder.show();
			}
		}

		public PlaceholderFragment() {
		}

		@Override
		public View onCreateView(LayoutInflater inflater, ViewGroup container,
				Bundle savedInstanceState) {
			View rootView = inflater.inflate(R.layout.fragment_case_list,
					container, false);
			cases = new LinkedList<Case>();
			caseAdapter = new CaseAdapter(getActivity(), cases);
			caseList = (ListView) rootView.findViewById(R.id.cases);
			caseList.setAdapter(caseAdapter);
			caseList.setOnItemClickListener(new OnItemClickListener() {

				@Override
				public void onItemClick(AdapterView<?> parent, View view,
						int position, long id) {
					Case c = cases.get(position);
					Intent i = new Intent(getActivity(), ShowCaseActivity.class);
					i.putExtra(ShowCaseActivity.IDENTIFICATOR, c.getIdentifier());
					startActivity(i);
				}
			});
			
			Button newCase = (Button)rootView.findViewById(R.id.new_case);
			newCase.setOnClickListener(new OnClickListener() {
				
				@Override
				public void onClick(View v) {
					Intent i = new Intent(getActivity(),NewCaseActivity.class);
					startActivity(i);
				}
			});
			
			return rootView;
		}
		
		
	}

}
