package org.h4k14.rompetusilencio.ui;

import java.util.List;

import org.h4k14.rompetusilencio.R;
import org.h4k14.rompetusilencio.domain.Response;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.ViewGroup.LayoutParams;
import android.widget.ArrayAdapter;
import android.widget.LinearLayout;
import android.widget.TextView;

public class ResponseAdapter extends ArrayAdapter<Response> {
	
	public ResponseAdapter(Context c, List<Response> cases) {
		super(c, R.layout.response_item_layout, cases);
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

		Response c = getItem(position);

		TextView text = (TextView) v.findViewById(R.id.text);
		text.setText(c.getText());
		
		LinearLayout.LayoutParams llp = new LinearLayout.LayoutParams(0, LayoutParams.WRAP_CONTENT);
		if (c.getAuthor() <= 0) {
			llp.setMargins(0, 0, 50, 0);
		} else {
			llp.setMargins(50, 0, 0, 0);
		}
		v.setLayoutParams(llp);

		return v;
	}
	
}
