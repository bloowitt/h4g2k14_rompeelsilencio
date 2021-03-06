package org.h4k14.rompetusilencio.ui;

import java.util.List;

import org.h4k14.rompetusilencio.R;
import org.h4k14.rompetusilencio.domain.Case;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

public class CaseAdapter extends ArrayAdapter<Case>{

	public CaseAdapter(Context c, List<Case> cases) {
		super(c, R.layout.case_list_item, cases);
	}
	
	@Override
	public View getView(int position, View convertView, ViewGroup parent) {
		View v = convertView;
		if (v == null || v.getId() != R.layout.case_list_item) {
			LayoutInflater inflater = (LayoutInflater) getContext()
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			v = inflater.inflate(R.layout.case_list_item, null);
			v.setId(R.layout.case_list_item);
		}

		Case c = getItem(position);

		TextView summary = (TextView) v.findViewById(R.id.summary);
		summary.setText(c.getResume());

		return v;
	}
	
}
