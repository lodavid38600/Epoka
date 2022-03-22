package com.example.monapplication;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Toast;

public class MenuActivity extends Activity {

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu);


    }
    public void add(View v){
        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            String sess_id = extras.getString("sess_id");
            Intent i = new Intent(MenuActivity.this, FormActivity.class);
            i.putExtra("sess_id",sess_id);
            startActivity(i);
        }
    }
    public void quit(View v) {
        finish();
    }
}
