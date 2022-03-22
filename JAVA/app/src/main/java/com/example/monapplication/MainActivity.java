package com.example.monapplication;


import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.StrictMode;
import android.text.Html;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class MainActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
    }

    public void recherche(View view){

        String urlServiceWeb;
        //Déclaration de variable :
        EditText utilisateur = findViewById(R.id.et_Utilisateur);
        EditText mdp = findViewById(R.id.et_Mdp);
        TextView resultat = findViewById(R.id.tv_Resultat);

        //URL ou l'on envoie la requête :
        urlServiceWeb = "http://172.16.46.18/epoka/login_mobile.php?identifiant="+utilisateur.getText()+"&mdp="+mdp.getText();
        //Récupération de la page en texte brut :
        String result = (getServerDataJson(urlServiceWeb));

        //Resultat de la page (true->Connexion else->affiche un texte)  :
        String login=result.substring(0,4);

            if (login.equals("true")) {
                //Renvoie uniquement l'id de session :
                String id_sess=result.substring(4);

                //Passage à la page suivante :
                Intent i = new Intent(MainActivity.this, MenuActivity.class);
                i.putExtra("sess_id",id_sess);
                startActivity(i);

            }else{
                resultat.setText("Mauvais identifiant ou mot de passe");
            }
        }


        //Sers à lire la page :
        private String getServerDataJson(String urlString) {

        InputStream is = null;
        String ch = "";

        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
        StrictMode.setThreadPolicy(policy);

        try {
            URL url = new URL(urlString);
            HttpURLConnection connexion = (HttpURLConnection) url.openConnection();
            connexion.connect();
            is = connexion.getInputStream();

            BufferedReader br = new BufferedReader(new InputStreamReader(is));
            String ligne;
            while ((ligne = br.readLine()) != null) {
                ch += Html.fromHtml(ligne);
            }
        } catch (Exception expt) {
            Toast.makeText(this, "erreur : " + expt.getLocalizedMessage(), Toast.LENGTH_SHORT).show();
            expt.printStackTrace();
        }
        return ch;
    }
}