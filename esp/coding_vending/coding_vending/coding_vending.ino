// #define BLYNK_TEMPLATE_ID "TMPLvXAW4OOf"
// #define BLYNK_DEVICE_NAME "SNACK VENDING MACHINE"
// #define BLYNK_AUTH_TOKEN "5-zpjyMvcsbkHfr3ao0RKbMwrN8NqpOo"
// #define BLYNK_PRINT Serial
#include <WiFi.h>
#include <WiFiClient.h>
// #include <Servo.h>
// Servo myservo;  // create servo object to control a servo
#include <ESP32Servo.h>
#include <ArduinoJson.h>
#include <WiFiClientSecure.h>
#include <Wire.h>
#include <SPI.h>
#include <HTTPClient.h>

// Servo myservo;  // create servo object to control a servo
// #include <BlynkSimpleEsp32.h>

#include <LiquidCrystal_I2C.h>
LiquidCrystal_I2C lcd(0x27, 16, 2);
#define MOTOR1 15
#define MOTOR2 2

const char* ssid = "Nadjmi";
const char* password = "nadjmiami";

String serverName = "http://172.20.10.6/RackPowerIOTMonitor/functions.php";
String devicename = "BME280";
String apikey = "tPmAT5Ab3j7F9";
WiFiClientSecure client;

// WidgetLCD virtualLCD(V0);
const byte interruptPin = 23;
int count = 100;
int countreal = 0;
float total = 0.0;
unsigned long Timer = 0;
int timedelay = 1300;
const float set1 = 0.50;
const float set2 = 1.00;
int stock1;
int stock2;
int noty1 = 0;
int noty2 = 0;
int pos;
TaskHandle_t Task1;

unsigned long lastTime = 0;

unsigned long timerDelay = 1000;


void setup() {
  Serial.begin(9600);
  // Blynk.begin(auth, ssid, pass);
  pinMode(interruptPin, INPUT_PULLUP);
  pinMode(4, INPUT_PULLUP);
  pinMode(5, INPUT_PULLUP);
  pinMode(MOTOR1, OUTPUT);
  pinMode(MOTOR2, OUTPUT);
  digitalWrite(MOTOR1, HIGH);
  digitalWrite(MOTOR2, HIGH);
  attachInterrupt(digitalPinToInterrupt(interruptPin), billAcceptor, RISING);
  lcd.init();  // initialize the lcd
  lcd.backlight();
  lcd.setCursor(0, 0);
  lcd.print(" PLEASE INSERT ");
  lcd.setCursor(0, 1);
  lcd.print("     COIN      ");
  Timer = millis();

  // virtualLCD.print(0, 0, "Stock1 : " + String(stock1) + "   ");
  // virtualLCD.print(0, 1, "Stock2 : " + String(stock2) + "   ");
  // // myservo.attach(MOTOR2);  // attaches the servo on pin 13 to the servo object
  // myservo.setPeriodHertz(50);         // Standard 50hz servo
  // myservo.attach(MOTOR2);  // attaches the servo on pin 18 to the servo object
  //                                     // using SG90 servo min/max of 500us and 2400us
  //                                     // for MG995 large servo, use 1000us and 2000us,
  //                                     // which are the defaults, so this line could be
  //                                     // "myservo.attach(servoPin);"



  //                                       xTaskCreatePinnedToCore(
  //   Task1code, /* Task function. */
  //   "Task1",   /* name of task. */
  //   10000,     /* Stack size of task */
  //   NULL,      /* parameter of the task */
  //   1,         /* priority of the task */
  //   &Task1,    /* Task handle to keep track of created task */
  //   0);        /* pin task to core 0 */
  // delay(500);



  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi..");
  }
  // Print ESP32 Local IP Address
  Serial.println(WiFi.localIP());
}

void loop() {
  // Blynk.run();
  Serial.println(count);
  if (millis() - Timer > 1000) {
    countreal = count - 100;
    Serial.println("COUNTREAL:" + String(countreal) + " ");
    Timer = millis();
  }

  //DUIT SYIILING
  if (countreal == 1) {
    countreal = 0;
    count = 100;
    total = total + 0.10;
  } else if (countreal == 2) {
    countreal = 0;
    count = 100;
    total = total + 0.20;
  } else if (countreal == 3) {
    countreal = 0;
    count = 100;
    total = total + 0.50;
  } else if (countreal == 4) {
    countreal = 0;
    count = 100;
    total = total + 0.10;
  } else if (countreal == 5) {
    countreal = 0;
    count = 100;
    total = total + 0.20;
  } else if (countreal == 6) {
    countreal = 0;
    count = 100;
    total = total + 0.50;
  }

  //SELECT SNACK 1
  if (total >= set1 && digitalRead(5) == LOW && stock1 >= 1) {
    while (digitalRead(5) == LOW) {
    }
    total = total - set1;
    stock1--;
    // virtualLCD.print(0, 0, "Stock1 : " + String(stock1) + "  ");
    lcd.setCursor(0, 0);
    lcd.print("    SNACK 1    ");
    lcd.setCursor(0, 1);
    lcd.print("   SELECTED    ");
    delay(1000);
    digitalWrite(MOTOR1, LOW);
    delay(timedelay);
    digitalWrite(MOTOR1, HIGH);
  }

  //SELECT SNACK 2
  if (total >= set2 && digitalRead(4) == LOW && stock2 >= 1) {
    while (digitalRead(4) == LOW) {
    }
    total = total - set2;
    stock2--;
    // virtualLCD.print(0, 1, "Stock2 : " + String(stock2) + "  ");
    lcd.setCursor(0, 0);
    lcd.print("    SNACK 2    ");
    lcd.setCursor(0, 1);
    lcd.print("   SELECTED    ");
    delay(1000);
    delay(1000);
    digitalWrite(MOTOR2, LOW);
    delay(timedelay);
    digitalWrite(MOTOR2, HIGH);
  }

  //Baki
  if (total == 0) {
    lcd.setCursor(0, 0);
    lcd.print(" PLEASE INSERT ");
    lcd.setCursor(0, 1);
    lcd.print("     COIN      ");
  } else if (total > 0) {
    lcd.setCursor(0, 0);
    lcd.print("S2:" + String(set1) + " S1:" + String(set2) + " ");
    lcd.setCursor(0, 1);
    lcd.print("   COIN : " + String(total) + "    ");
  }

  if (stock1 <= 0 && noty1 == 0) {
    noty1 = 1;
    // Blynk.logEvent("noty", "SNACK 1 OUT OF STOCK");
  }
  if (stock2 <= 0 && noty2 == 0) {
    noty2 = 1;
    // Blynk.logEvent("noty", "SNACK 2 OUT OF STOCK");
  }
}



void billAcceptor() {
  count++;
}


void GetSTOCK() {

  //Check WiFi connection status
  if (WiFi.status() == WL_CONNECTED) {
    Serial.print("Task1 running on core ");
    Serial.println(xPortGetCoreID());
    WiFiClient client;
    HTTPClient http;

    // Your Domain name with URL path or IP address with path
    http.begin(client, serverName);


    // Specify content-type header
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    // Data to send with HTTP POST
    String httpRequestData = "api_key" + apikey;
    // Send HTTP POST request
    int httpResponseCode = http.POST(httpRequestData);
    String payload = "{}";

    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);

    // Free resources
    http.end();
    Serial.println(payload);
  } else {
    Serial.println("WiFi Disconnected");
  }
  lastTime = millis();
}