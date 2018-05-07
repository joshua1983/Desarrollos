package catalina.lector;

import android.os.CountDownTimer;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.SeekBar;
import android.widget.TextView;

import java.util.Timer;
import java.util.TimerTask;

public class MainActivity extends AppCompatActivity {

    String TEXTO_CUENTO = "La liebre y la tortuga. En el mundo de los animales vivía una liebre muy orgullosa y vanidosa, que no cesaba de pregonar que ella era la más veloz y se burlaba de ello ante la lentitud de la tortuga. " +
            "¡Eh, tortuga, no corras tanto que nunca vas a llegar a tu meta! Decía la liebre riéndose de la tortuga. " +
            "Un día, a la tortuga se le ocurrió hacerle una inusual apuesta a la liebre: " +
            "Estoy segura de poder ganarte una carrera. " +
            "¿A mí? Preguntó asombrada la liebre. " +
            "Sí, sí, a ti, dijo la tortuga. Pongamos nuestras apuestas y veamos quién gana la carrera. " +
            "La liebre, muy ingreída, aceptó la apuesta. " +
            "Así que todos los animales se reunieron para presenciar la carrera. El búho señaló los puntos de partida y de llegada, y sin más preámbulos comenzó la carrera en medio de la incredulidad de los asistentes. " +
            "Astuta y muy confiada en si misma, la liebre dejó coger ventaja a la tortuga y se quedó haciendo burla de ella. Luego, empezó a correr velozmente y sobrepasó a la tortuga que caminaba despacio, pero sin parar. Sólo se detuvo a mitad del camino ante un prado verde y frondoso, donde se dispuso a descansar antes de concluir la carrera. Allí se quedó dormida, mientras la tortuga siguió caminando, paso tras paso, lentamente, pero sin detenerse. " +
            "Cuando la liebre se despertó, vio con pavor que la tortuga se encontraba a una corta distancia de la meta. En un sobresalto, salió corriendo con todas sus fuerzas, pero ya era muy tarde: ¡la tortuga había alcanzado la meta y ganado la carrera! " +
            "Ese día la liebre aprendió, en medio de una gran humillación, que no hay que burlarse jamás de los demás. También aprendió que el exceso de confianza es un obstáculo para alcanzar nuestros objetivos. Y que nadie, absolutamente nadie, es mejor que nadie\n" +
            "\n";

    String[] PALABRAS;
    SeekBar barraVelocidad;
    TextView txtPalabra;
    int palabraActual = 0;
    LectorTask lectorTask;
    Timer timerLector;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        barraVelocidad = findViewById(R.id.barraVelocidad);
        txtPalabra = findViewById(R.id.txtPalabra);
        final TextView textoVelocidad = findViewById(R.id.textoVelocidad);
        PALABRAS = TEXTO_CUENTO.split(" ");
        Button btnIniciar = findViewById(R.id.btnEmpezar);
        Button btnDetener = findViewById(R.id.btnDetener);
        Button btnPause = findViewById(R.id.btnPause);

        barraVelocidad.setOnSeekBarChangeListener(new SeekBar.OnSeekBarChangeListener() {
            @Override
            public void onProgressChanged(SeekBar seekBar, int i, boolean b) {
                textoVelocidad.setText("Velocidad: "+(String.valueOf(i)) + " palabras por minuto");
            }

            @Override
            public void onStartTrackingTouch(SeekBar seekBar) {

            }

            @Override
            public void onStopTrackingTouch(SeekBar seekBar) {

            }
        });

        btnIniciar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                empezarLeer();
            }
        });
        btnDetener.setOnClickListener(new View.OnClickListener(){

            @Override
            public void onClick(View view) {
                detenerLectura();
            }
        });
        btnPause.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                pausarLectura();
            }
        });

    }

    private void pausarLectura() {
        timerLector.cancel();
    }

    public void detenerLectura(){
        timerLector.cancel();
        palabraActual = 0;
    }

    public void actualizarPalabra(){
        runOnUiThread(new Runnable() {
            @Override
            public void run() {
                txtPalabra.setText(PALABRAS[palabraActual]);
                palabraActual++;
            }
        });

    }

    private void empezarLeer(){
        int velocidadLectura = barraVelocidad.getProgress();
        lectorTask = new LectorTask();
        timerLector = new Timer();
        long factorLectura = 60000/velocidadLectura;
        timerLector.schedule(lectorTask, 100, factorLectura);
    }

    class LectorTask extends TimerTask{
        public void run(){
            if (palabraActual < PALABRAS.length){
                actualizarPalabra();
            }else{
                detenerLectura();
            }

        }
    }

}
