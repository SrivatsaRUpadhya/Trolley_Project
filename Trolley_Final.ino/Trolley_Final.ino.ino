#include<WiFi.h>
#include<WiFiClient.h>
#include <WebServer.h>
#include <HTTPClient.h>
#include<Keypad.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <SPI.h>
#include <MFRC522.h>


#define RST_PIN         4          // Configurable, see typical pin layout above
#define SS_PIN          5          // Configurable, see typical pin layout above

MFRC522 mfrc522(SS_PIN, RST_PIN);   // Create MFRC522 instance
//#include <LiquidCrystal.h>

// initialize the library by associating any needed LCD interface pin
// with the arduino pin number it is connected to
//const int rs = 23, en = 22, d4 = 21, d5 = 25, d6 = 26, d7 = 27;
//LiquidCrystal lcd(rs, en, d4, d5, d6, d7);

#define SCREEN_WIDTH 128 // OLED display width, in pixels
#define SCREEN_HEIGHT 32 // OLED display height, in pixels
#define OLED_RESET     -1 // Reset pin # (or -1 if sharing Arduino reset pin)
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);

//ENTER YOUR WIFI SETTINGS
const char *ssid = "PRAVINDL";  
const char *password = "pravi@123";
const char *host = "000webhostapp.com"; 
WiFiClient wifiClient;

//Setup the keypad
const byte rows = 4;
const byte cols = 4;

char keys[rows][cols] = {
  {'1', '2', '3', 'A'},
  {'4', '5', '6', 'B'},
  {'7', '8', '9', 'C'},
  {'*', '0', '#', 'D'}
};

byte rowPins[rows] = {13, 12, 14, 27};
byte colPins[cols] = {26, 25, 33, 32};
Keypad keypad1 = Keypad( makeKeymap(keys), rowPins, colPins, rows, cols );//Create keypad object

String phone = "", pin = "";//String that stores the customers phone number
int digit_count = 0;


void setup() {
    delay(1000);
//  lcd.begin(16, 1);

  
  Serial.begin(9600);
  SPI.begin(); 
  mfrc522.PCD_Init(); 
  
  if(!display.begin(SSD1306_SWITCHCAPVCC, 0x3C)) {
    Serial.println(F("SSD1306 allocation failed"));
    for(;;); // Don't proceed, loop forever
  }
  else{
    Serial.println("Connected to display");
  }

  display.setTextSize(1);
  display.setTextColor(WHITE);
  display.setCursor(0, 0);
  display.clearDisplay();
  display.display();

  
  WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
  delay(1000);
  WiFi.mode(WIFI_STA);        //This line hides the viewing of ESP as wifi hotspot
  
  WiFi.begin(ssid, password);     //Connect to your WiFi router
  Serial.println("");

  Serial.print("Connecting");
  // Wait for connection
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  //If connection successful show IP address in serial monitor
  Serial.println("");
  Serial.print("Connected to ");
  Serial.println(ssid);
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());  //IP address assigned to your ESP
  
//  lcd.noAutoscroll();
//  lcd.clear();
  ask_details:
  display.print("Enter Phone: \n");
  display.display();
//  char mychar = 'a';
//  String mystr = "";
//  Serial.print(mystr + mychar);

  HTTPClient http;
  char key;
  

  for( ; ; ){
  key = keypad1.getKey();
  if(key != NO_KEY){
  if(key == 'D'){
  //Post Data
  phone.toInt();
  break;

  }

  else if(key == 'B'){
    phone.remove(phone.length() - 1, 1);
    display.clearDisplay();
    display.setCursor(0, 0);
    display.print("Enter Phone: \n");
    display.print(phone);
    display.display();
  }
  else{
    Serial.print(key);
    display.print(key);
    display.display();
//    lcd.autoscroll();
    phone = phone + key;   
//    lcd.clear();
//    lcd.print(phone); 
  }
  }
  delay(30);
  }
//Get the pin

  display.print("\nEnter Pin: ");
  display.display();
  for( ; ; ){
    key = keypad1.getKey();
    if(key != NO_KEY){
      if(key == 'D'){
        pin.toInt();
        break;
    
      }
    
      else if(key == 'B'){
        phone.remove(pin.length() - 1, 1);
        display.clearDisplay();
        display.setCursor(0, 0);
        display.print("Enter Phone: \n");
        display.print(pin);
        display.display();
      }
      else{
        Serial.print(key);
        display.print(key);
        display.display();
    //    lcd.autoscroll();
        pin = pin + key;   
    //    lcd.clear();
    //    lcd.print(phone); 
      }
    }
    delay(30);
  }

  // Send phone and pin to server
    display.print("\nLogging in");
    display.display();
    String postData = "submit&phone=" + phone + "&pin=" + pin;
    http.begin(wifiClient, "http://smart-trolley-project.000webhostapp.com/admin/authenticate.php");              //Specify request destination
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
    
    int httpCode = http.POST(postData);   //Send the request
    String payload = http.getString();    //Get the response payload
      String code = String(httpCode);
      while(code == ""){
      display.print(".");
      display.display();
    }
    Serial.println(httpCode);   //Print HTTP return code


    if(payload == "mc1"){
        Serial.println(payload);    //Print request response payload
        display.clearDisplay();
        display.setCursor(0, 0);
        display.print("User not found!, please create your account if your a first time user.");
        display.display();
        delay(3000);
        display.clearDisplay();
        display.setCursor(0, 0);
        phone = "";
        pin = "";
        goto ask_details;
    }

    else if(payload == "mc2"){
        Serial.println(payload);    //Print request response payload
        display.clearDisplay();
        display.setCursor(0, 0);
        display.print("Incorrect credentials entered!\nPlease try again.");
        display.display();
        delay(3000);
        display.clearDisplay();
        display.setCursor(0, 0);
        phone = "";
        pin = "";
        goto ask_details;
    }

    else if(payload == "mc3"){
      Serial.println(payload);    //Print request response payload
      display.clearDisplay();
      display.setCursor(0, 0);
      display.print("Login successful :)");
      display.display();
      delay(3000);
    }
    else{
      Serial.println(payload);    //Print request response payload
    }
    
    http.end();  //Close connection

    
   mfrc522.PCD_Init();        // Init MFRC522 card
   Serial.print("ready");
}



void loop() {

  display.clearDisplay();
  display.setCursor(0,0);
  display.print("Scan a Product...");
  display.display();
  String barcode = "";
  // Prepare key - all keys are set to FFFFFFFFFFFFh at chip delivery from the factory.
  MFRC522::MIFARE_Key key;
  for (byte i = 0; i < 6; i++) key.keyByte[i] = 0xFF;

  //some variables we need
  byte block;
  byte len;
  MFRC522::StatusCode status;

  //-------------------------------------------

  // Reset the loop if no new card present on the sensor/reader. This saves the entire process when idle.
  if ( ! mfrc522.PICC_IsNewCardPresent()) {
    return;
  }

  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return;
  }

  Serial.println(F("**Card Detected:**"));

  //-------------------------------------------

  mfrc522.PICC_DumpDetailsToSerial(&(mfrc522.uid)); //dump some details about the card

  //mfrc522.PICC_DumpToSerial(&(mfrc522.uid));      //uncomment this to see all blocks in hex

  //-------------------------------------------

  Serial.print(F("Barcode: "));


  //---------------------------------------- GET LAST NAME

  byte buffer2[100];
  len = 100;
  block = 1;

  status = mfrc522.PCD_Authenticate(MFRC522::PICC_CMD_MF_AUTH_KEY_A, 1, &key, &(mfrc522.uid)); //line 834
  if (status != MFRC522::STATUS_OK) {
    Serial.print(F("Authentication failed: "));
    Serial.println(mfrc522.GetStatusCodeName(status));
    return;
  }

  status = mfrc522.MIFARE_Read(block, buffer2, &len);
  if (status != MFRC522::STATUS_OK) {
    Serial.print(F("Reading failed: "));
    Serial.println(mfrc522.GetStatusCodeName(status));
    return;
  }

  //PRINT barcode
  for (uint8_t i = 0; i < 16; i++) {
    barcode += (char)buffer2[i];
//    Serial.write(buffer2[i]);
  }
  Serial.print(barcode);
  display.print("\nAdding product to cart");
  display.display();
  //----------------------------------------
  
  Serial.println(F("\n**End Reading**\n"));

  delay(500); //change value if you want to read cards faster

  mfrc522.PICC_HaltA();
  mfrc522.PCD_StopCrypto1();

//Post the data ie barcode and phone
  HTTPClient http;
  String postData = "add_prd&customer=" + phone + "&prd-id=" + barcode;
  Serial.print(postData);
  
  http.begin(wifiClient, "http://smart-trolley-project.000webhostapp.com/getEspData.php");              //Specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
  
  int httpCode = http.POST(postData);   //Send the request
  String payload = http.getString();    //Get the response payload
    String code = String(httpCode);
    while(code == ""){
    display.print(".");
    display.display();
  }
  Serial.println(httpCode);   //Print HTTP return code

  if(httpCode == -11 || httpCode == 200){
    display.clearDisplay();
    display.setCursor(0,0);
    display.print(barcode);
    display.print("\n\nProduct Added");
    display.display();
  }
  Serial.println(payload);    //Print request response payload

  http.end();  //Close connection
  delay(500);
}
