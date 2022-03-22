package com.example.monapplication;



import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.StrictMode;
import android.text.Html;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;


import com.android.volley.RequestQueue;

import com.android.volley.toolbox.Volley;


import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.ArrayList;

import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Spinner;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.LinkedBlockingDeque;

public class FormActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_form);
        String urlGetVille = "http://172.16.46.18/epoka/search_villes.php";
        getServerDataJSON(urlGetVille);
    }




    public void sendData(View view){

        String urlServiceWeb;

        //DECLARATION DE VARIABLE :
        EditText dateDepart = findViewById(R.id.etdFrom);
        EditText dateArriver = findViewById(R.id.etdTo);
        Spinner spinner = (Spinner)findViewById(R.id.spinner);
        String city = spinner.getSelectedItem().toString();


        //RECUPERATION ID SESSION (ENVOIE PAR L'INTENT PRECEDENT):
        Bundle extras = getIntent().getExtras();
        String sess_id = extras.getString("sess_id");

        //URL WEB :
        urlServiceWeb = "http://172.16.46.18/epoka/insertion_date.php?date_depart="+dateDepart.getText()+"&date_rentrer="+dateArriver.getText()+"&sess_id="+sess_id+"&ville_dest="+city;

        //RECUPERATION RETOUR PAGE WEB :
        String insert = (insert(urlServiceWeb)); //INSERTION


        if (insert.equals("true")) {
            Toast.makeText(FormActivity.this, "Mission ajouter", Toast.LENGTH_LONG).show();
        }else{
            Toast.makeText(FormActivity.this, "Une erreur est survenue", Toast.LENGTH_LONG).show();
        }
    }

    private String insert(String urlString) {
        try {
            InputStream is = null;
            URL url = new URL(urlString);
            HttpURLConnection connexion = (HttpURLConnection)url.openConnection();
            connexion.connect();
            is = connexion.getInputStream();
            BufferedReader br = new BufferedReader(new InputStreamReader(is));
        }catch (Exception expt) {
            expt.printStackTrace();
        }
        return "true";
    }

    private String getServerDataJSON (String urlString){
        InputStream is = null;
        String ch = "";
        List<LibelleEtNo> list = new ArrayList<LibelleEtNo>();


        try{
            URL url = new URL(urlString);
            HttpURLConnection connexion = (HttpURLConnection)url.openConnection();
            connexion.connect();
            is = connexion.getInputStream();

            BufferedReader br = new BufferedReader(new InputStreamReader(is));
            String ligne;
            while((ligne = br.readLine()) != null){
                ch = ch + ligne +"\n";
            }
            JSONArray jArray = new JSONArray(ch);
            ch = "";
            for(int i = 0; i<jArray.length();i++){
                JSONObject jsonData = jArray.getJSONObject(i);
                list.add(new LibelleEtNo(jsonData.getString("ville"), jsonData.getInt("cp")));
                ch = jsonData.getString("ville") ;

            }
        }catch(Exception expt){
            expt.printStackTrace();
        }
        ArrayAdapter<LibelleEtNo> adapter = new ArrayAdapter<LibelleEtNo>(this, android.R.layout.simple_spinner_item,list);
        Spinner ville = (Spinner) findViewById(R.id.spinner);
        ville.setAdapter(adapter);
        return (ch);
    }

public class LibelleEtNo{
        public String libelle;
        public int no;
        public LibelleEtNo(String unLibelle, int unNo){
            libelle = unLibelle;
            no = unNo;
        }
        @Override
        public String toString(){
            return libelle;
        }

}


}