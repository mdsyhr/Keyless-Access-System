#include <WiFi.h>
#include <HTTPClient.h>
#include <MFRC522.h>
#include <SPI.h>
#include "driver/ledc.h"

#define SS_PIN 5
#define RST_PIN 13
#define ON_Board_LED 2
#define BUTTON_PIN 12
#define RED_LED 16
#define GREEN_LED 17
#define BLUE_LED 25
#define BUZZER_PIN 14

MFRC522 mfrc522(SS_PIN, RST_PIN);

const char* ssid = "syahir";
const char* password = "syhr0404";

int readsuccess;
byte readcard[4];
char str[32] = "";
String StrUID;
bool vehicleStarted = false;
int buttonPressCount = 0;

void playMotorcycleStartSound();
void setColor(uint8_t red, uint8_t green, uint8_t blue);

void setup() {
    Serial.begin(115200);
    SPI.begin();
    mfrc522.PCD_Init();

    pinMode(ON_Board_LED, OUTPUT); 
    pinMode(RED_LED, OUTPUT);
    pinMode(GREEN_LED, OUTPUT);
    pinMode(BLUE_LED, OUTPUT);
    pinMode(BUZZER_PIN, OUTPUT);
    pinMode(BUTTON_PIN, INPUT_PULLUP);

    digitalWrite(ON_Board_LED, HIGH);

    WiFi.begin(ssid, password);
    Serial.print("Connecting");
    while (WiFi.status() != WL_CONNECTED) {
        Serial.print(".");
        digitalWrite(ON_Board_LED, LOW);
        delay(250);
        digitalWrite(ON_Board_LED, HIGH);
        delay(250);
    }
    digitalWrite(ON_Board_LED, HIGH);
    Serial.println("");
    Serial.print("Successfully connected to : ");
    Serial.println(ssid);
    Serial.print("IP address: ");
    Serial.println(WiFi.localIP());

    Serial.println("Please tag a card or keychain to see the UID !");
    Serial.println("");

    ledcSetup(0, 1000, 8);
    ledcAttachPin(BUZZER_PIN, 0);
}

void loop() {
    readsuccess = getid();
    if (readsuccess) {
        digitalWrite(ON_Board_LED, LOW);
        HTTPClient http;
        String UIDresultSend = StrUID;
        
        // Send both UID and status
       String postData = "UIDresult=" + UIDresultSend;
        if (digitalRead(BUTTON_PIN) == LOW) {
            // Button 1 pressed, vehicle started
            postData += "&status=vehicle_started";
        } else if (digitalRead(12) == LOW) { // Replace '3' with the actual pin number of the second button
            // Button 2 pressed, vehicle stopped
            postData += "&status=vehicle_stopped";
          }


       
        http.begin("http://172.20.10.3/NodeMCU_RC522_Mysql/getUID.php");
        http.addHeader("Content-Type", "application/x-www-form-urlencoded");
        int httpCode = http.POST(postData);
        String payload = http.getString();

        Serial.print("THE UID OF THE SCANNED CARD IS : ");
        Serial.println(StrUID); // Print the UID of the scanned card

        if (httpCode == 200) {
            if (payload == "UID_FOUND") {
                Serial.println("Access Granted, Welcome back!");
                setColor(0, 0, 255);
                buttonPressCount = 0;
                while (buttonPressCount < 2) {
                    if (digitalRead(BUTTON_PIN) == LOW) {
                        delay(200);
                        while (digitalRead(BUTTON_PIN) == LOW);
                        delay(200);
                        if (!vehicleStarted) {
                            setColor(0, 255, 0);
                            playMotorcycleStartSound();
                            Serial.println("Vehicle Started");
                            vehicleStarted = true;
                        } else {
                            setColor(255, 0, 0);
                            ledcWriteTone(0, 1000);
                            delay(1000);
                            ledcWrite(0, 0);
                            Serial.println("Vehicle Stopped");
                            vehicleStarted = false;
                            delay(2000);
                            setColor(255, 255, 0);
                        }
                        buttonPressCount++;
                    }
                }
                buttonPressCount = 0;
                setColor(255, 255, 0);
            } else {
                Serial.println("Access Denied"); // Print access denied on a separate line
                for (int i = 0; i < 8; i++) {
                    setColor(255, 0, 0);
                    delay(125);
                    setColor(0, 0, 0);
                    delay(125);
                }
            }
        } else {
            Serial.printf("HTTP request failed with code: %d\n", httpCode);
        }

        http.end();
        delay(1000);
        digitalWrite(ON_Board_LED, HIGH);
    }
}

int getid() {
    if (!mfrc522.PICC_IsNewCardPresent()) {
        return 0;
    }
    if (!mfrc522.PICC_ReadCardSerial()) {
        return 0;
    }
    Serial.print("THE UID OF THE SCANNED CARD IS : ");
    for (int i = 0; i < 4; i++) {
        readcard[i] = mfrc522.uid.uidByte[i];
        array_to_string(readcard, 4, str);
        StrUID = str;
    }
    mfrc522.PICC_HaltA();
    return 1;
}

void array_to_string(byte array[], unsigned int len, char buffer[]) {
    for (unsigned int i = 0; i < len; i++) {
        byte nib1 = (array[i] >> 4) & 0x0F;
        byte nib2 = (array[i] >> 0) & 0x0F;
        buffer[i * 2 + 0] = nib1 < 0xA ? '0' + nib1 : 'A' + nib1 - 0xA;
        buffer[i * 2 + 1] = nib2 < 0xA ? '0' + nib2 : 'A' + nib2 - 0xA;
    }
    buffer[len * 2] = '\0';
}

void setColor(uint8_t red, uint8_t green, uint8_t blue) {
    analogWrite(RED_LED, red);
    analogWrite(GREEN_LED, green);
    analogWrite(BLUE_LED, blue);
}

void playMotorcycleStartSound() {
    int tones[] = {500, 700, 900, 1100, 1300, 1500, 1700, 1900, 2100};
    int durations[] = {100, 100, 100, 100, 100, 100, 100, 100, 100};

    for (int i = 0; i < 9; i++) {
        ledcWriteTone(0, tones[i]);
        delay(durations[i]);
    }
    ledcWrite(0, 0);
}
