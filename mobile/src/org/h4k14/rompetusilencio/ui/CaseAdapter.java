package org.h4k14.rompetusilencio.ui;

import java.util.List;

import org.h4k14.rompetusilencio.R;
import org.h4k14.rompetusilencio.domain.Case;

import android.content.Context;
import android.widget.ArrayAdapter;

public class CaseAdapter extends ArrayAdapter<Case>{

	public CaseAdapter(Context c, List<Case> cases) {
		super(c, R.layout.case_list_item, cases);
	}
	
}
