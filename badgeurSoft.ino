/*
 *  This sketch sends data via HTTP GET requests to data.sparkfun.com service.
 *
 *  You need to get streamId and privateKey at data.sparkfun.com and paste them
 *  below. Or just customize this script to talk to other HTTP servers.
 *
 */
 
 /*
 * --------------------------------------------------------------------------------------------------------------------
 * Example sketch/program showing how to read new NUID from a PICC to serial.
 * --------------------------------------------------------------------------------------------------------------------
 * This is a MFRC522 library example; for further details and other examples see: https://github.com/miguelbalboa/rfid
 * 
 * Example sketch/program showing how to the read data from a PICC (that is: a RFID Tag or Card) using a MFRC522 based RFID
 * Reader on the Arduino SPI interface.
 * 
 * When the Arduino and the MFRC522 module are connected (see the pin layout below), load this sketch into Arduino IDE
 * then verify/compile and upload it. To see the output: use Tools, Serial Monitor of the IDE (hit Ctrl+Shft+M). When
 * you present a PICC (that is: a RFID Tag or Card) at reading distance of the MFRC522 Reader/PCD, the serial output
 * will show the type, and the NUID if a new card has been detected. Note: you may see "Timeout in communication" messages
 * when removing the PICC from reading distance too early.
 * 
 * @license Released into the public domain.
 * 
 * Typical pin layout used:
 * -----------------------------------------------------------------------------------------
 *             MFRC522      Arduino       Arduino   Arduino    Arduino          Arduino
 *             Reader/PCD   Uno           Mega      Nano v3    Leonardo/Micro   Pro Micro
 * Signal      Pin          Pin           Pin       Pin        Pin              Pin
 * -----------------------------------------------------------------------------------------
 * RST/Reset   RST          9             5         D9         RESET/ICSP-5     RST
 * SPI SS      SDA(SS)      10            53        D10        10               10
 * SPI MOSI    MOSI         11 / ICSP-4   51        D11        ICSP-4           16
 * SPI MISO    MISO         12 / ICSP-1   50        D12        ICSP-1           14
 * SPI SCK     SCK          13 / ICSP-3   52        D13        ICSP-3           15
 */


#include <ESP8266WiFi.h>

#include <LiquidCrystal_I2C.h>
#include <Wire.h>

#include <MFRC522.h>

#define SS_PIN 15
#define RST_PIN 16

MFRC522 rfid(SS_PIN, RST_PIN);    //instance de RFID
MFRC522::MIFARE_Key key; 
LiquidCrystal_I2C lcd(0x27,20,4);

byte nuidPICC[3];

const char* ssid     = "Les Usines Nouvelles";
const char* password = "usinesnouvelles";
const char* host = "192.168.0.27";

unsigned int id_badge=6664269, id_badgeuse=2;

//=======================================================================
// initialisation des éléments LCD, Série et WiFi 
//=======================================================================

void setup() {

  //=======================================================================
  // Initilisation de la broche 0 en sortie pour la commande du relais
  //=======================================================================  
  pinMode(0,OUTPUT);
  
  //=======================================================================
  // Initilisation de l'afficheur LCD I²C
  //=======================================================================  
  lcd.begin(20,4,1);
  lcd.init();
  lcd.init();
  lcd.backlight();
  lcd.setCursor(0,0);
  lcd.print("Starting ...");

  //=======================================================================
  // Initialisation de la liaison série pour le débug 
  //=======================================================================  
  Serial.begin(115200);
  delay(10);

  // We start by connecting to a WiFi network
  Serial.println();
  Serial.println();
  Serial.print("Connecting to : ");
  Serial.println(ssid);
  
  //=======================================================================
  // Activation du bus SPI et initialisation du lecteur RFID
  //======================================================================= 
  SPI.begin(); // Init SPI bus
  rfid.PCD_Init(); // Init MFRC522 
  for (byte i = 0; i < 6; i++)
  {
    key.keyByte[i] = 0xFF;
  }
  Serial.println(F("This code scan the MIFARE Classsic NUID."));
  Serial.print(F("Using the following key:"));
  //printHex(key.keyByte, MFRC522::MF_KEY_SIZE);

  //=======================================================================
  // Activation du wifi
  //=======================================================================    
  lcd.setCursor(0,1);
  lcd.print("Network connection");
  lcd.setCursor(0,2);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    lcd.print(".");
  }
  
  //Affichage de la connexion réseau
  lcd.clear();
  lcd.setCursor(0,1);
  lcd.print("Network connected");
  lcd.setCursor(0,2);
  lcd.print(WiFi.localIP());

  
  Serial.println();
  Serial.println();
  Serial.print("WiFi connected");
  Serial.println();
  Serial.print("IP address : ");
  Serial.print(WiFi.localIP());
}

int value = 0;

void loop() {
  if(WiFi.status() != WL_CONNECTED)
  {
    setup();
  }
  delay(5000);
  ++value;
  
  //=======================================================================
  // Scan du badge
  //======================================================================= 
  lcd.clear();
  lcd.setCursor(0,1);
  lcd.print("Scanez votre badge");  
  // Look for new cards
  if ( ! rfid.PICC_IsNewCardPresent())
    return;

  // Verify if the NUID has been readed
  if ( ! rfid.PICC_ReadCardSerial())
    return;

  Serial.print(F("PICC type: "));
  MFRC522::PICC_Type piccType = rfid.PICC_GetType(rfid.uid.sak);
  Serial.println(rfid.PICC_GetTypeName(piccType));

  // Check is the PICC of Classic MIFARE type
  if (piccType != MFRC522::PICC_TYPE_MIFARE_MINI &&  
    piccType != MFRC522::PICC_TYPE_MIFARE_1K &&
    piccType != MFRC522::PICC_TYPE_MIFARE_4K) {
    Serial.println(F("Your tag is not of type MIFARE Classic."));
    return;
  }

  Serial.println(F("A new card has been detected."));

  // Store NUID into nuidPICC array
  for (byte i = 0; i < 4; i++) {
    nuidPICC[i] = rfid.uid.uidByte[i];
  }

  Serial.println(F("The NUID tag is:"));
  Serial.print(F("In dec: "));
  printDec(rfid.uid.uidByte, rfid.uid.size);
  Serial.println();

  
  
  //=======================================================================
  // Fin Scan du badge
  //=======================================================================
  //=======================================================================
  // Début de l'ajout en BDD
  //=======================================================================  
  Serial.println("Ma fonction : ");
  String ficelle = convertUID(rfid.uid.uidByte, rfid.uid.size);
  
  Serial.println();
  Serial.println();
  Serial.print("connecting to : ");
  Serial.print(host);
  
  // Use WiFiClient class to create TCP connections
  WiFiClient client;
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) {
    Serial.println("connection failed");
    return;
  }
  //convertUID(rfid.uid.uidByte, rfid.uid.size);
  // We now create a URI for the request
  String url = "http://";
  url += host;
  url += "/GestionBadgeuses/badgeuse_acces.php";
  url += "?id_badge=";
  url += convertUID(rfid.uid.uidByte, rfid.uid.size);
  url += "&id_badgeuse=";
  url += id_badgeuse;

  Serial.println();
  Serial.print("Requesting URL : ");
  Serial.print(url);
  
  // This will send the request to the server
  client.print(String("GET ") + url +
               "\nHost: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
  unsigned long timeout = millis();
  while (client.available() == 0)
  {
    if (millis() - timeout > 5000)
    {
      Serial.println(">>> Client Timeout !");
      client.stop();
      return;
    }
  }
  
  lcd.clear();
  // Read all the lines of the reply from server and print them to Serial
  String line = "";
  lcd.setCursor(0,0);
  lcd.print("Badge scane");
 
  digitalWrite(0,HIGH); //envoi d'une impulsion sur GPIO 0
  
  int i=1;
  while(client.available()){
    client.readStringUntil('>');
    line="";
    line = client.readStringUntil('<');
    
    Serial.println();
    Serial.println(line);
    
    lcd.setCursor(0,i);
    lcd.print(line);
    i++;
  }
  digitalWrite(0,LOW);
  Serial.println("closing connection");

  //delay(2000);
  //lcd.clear();
}

/**
 * Helper routine to dump a byte array as hex values to Serial. 
 */
/*void printHex(byte *buffer, byte bufferSize) {
  for (byte i = 0; i < bufferSize; i++) {
    Serial.print(buffer[i] < 0x10 ? " 0" : " ");
    Serial.print(buffer[i], HEX);
  }
}//*/

String convertUID(byte *buffer, byte bufferSize)
{
  String result="";
  for(byte i=0;i<bufferSize;i++)
  {
    result += String(buffer[i]);
  }
  Serial.print(result);
  return result;
}


/**
 * Helper routine to dump a byte array as dec values to Serial.
 */
void printDec(byte *buffer, byte bufferSize) {
  for (byte i = 0; i < bufferSize; i++) {
    Serial.print(buffer[i] < 0x10 ? " 0" : " ");
    Serial.print(buffer[i], DEC);
    lcd.print(buffer[i] < 0x10 ? " 0" : " ");
    lcd.print(buffer[i], DEC);
  }
}//*/
