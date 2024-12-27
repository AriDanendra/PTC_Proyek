#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <Adafruit_Fingerprint.h>
#include <Arduino.h>
#include <WiFi.h>
#include <Firebase_ESP_Client.h>
#include "time.h"

#define SSID "OPPO A57"
#define PASSWORD "1234567891"
#define DATABASE_URL "https://project-ca9f7-default-rtdb.asia-southeast1.firebasedatabase.app/"
#define API_KEY "AIzaSyDLRPQyMT3yIZ9z_cGMEAYnMZ4WLrEY5uI" 

LiquidCrystal_I2C lcd(0x27, 16, 2);
FirebaseData fbdo;
FirebaseAuth auth;
FirebaseConfig config;

// Pin tombol
const int btnSelect = 12;  // Tombol pilih
const int btnUp = 14;      // Tombol naik
const int buzzer = 25;     // Pin buzzer

// Inisialisasi sensor sidik jari
HardwareSerial mySerial(2);
Adafruit_Fingerprint finger(&mySerial);

// Variabel menu
int currentMenu = 0;
String menus[] = {"DAFTAR DOSEN", "ABSEN MASUK", "ABSEN KELUAR", "HAPUS SEMUA"};
int totalMenus = 4;

// Data mahasiswa dan dosen
struct DataUser {
  uint8_t id;          // ID sidik jari
  String nama;         // Nama pengguna
  String matakuliah;    // Informasi tambahan (mata kuliah/jabatan)
};

DataUser daftarDosen[20];     // Maksimal 10 dosen
int totalDosen = 0;

void setup() {
  // Inisialisasi serial
  Serial.begin(115200);
  mySerial.begin(57600, SERIAL_8N1, 4, 5); // RX=4, TX=5 untuk sensor
  Serial.println("Menghubungkan ke Wi-Fi...");
  WiFi.begin(SSID, PASSWORD);
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(">");
    delay(500);
  }
  Serial.println("\nTerhubung ke Wi-Fi!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());

  config.api_key = API_KEY;
  config.database_url = DATABASE_URL;

  if (Firebase.signUp(&config, &auth, "", "")) {
    Serial.println("Terhubung ke Firebase");
  } else {
    Serial.printf("Gagal terhubung ke Firebase: %s\n", config.signer.signupError.message.c_str());
  }

  Firebase.begin(&config, &auth);

  // Inisialisasi LCD
  lcd.init();
  lcd.backlight();

  // Inisialisasi tombol
  pinMode(btnSelect, INPUT_PULLUP);
  pinMode(btnUp, INPUT_PULLUP);

  // Inisialisasi buzzer
  pinMode(buzzer, OUTPUT);
  digitalWrite(buzzer, LOW);

  // Inisialisasi sensor sidik jari
  finger.begin(57600);
  if (finger.verifyPassword()) {
    Serial.println("Sensor sidik jari ditemukan.");
  } else {
    Serial.println("Sensor sidik jari tidak terdeteksi.");
    while (1); // Hentikan program
  }

  configTime(7 * 3600, 0, "pool.ntp.org", "time.nist.gov");

  lcd.print("SELAMAT DATANG!");
  delay(5000);
  lcd.clear();

  // Memuat data dosen dari Firebase
  muatDataDariFirebase();

  // Tampilkan menu setelah data dimuat
  tampilkanMenu();
}

void loop() {
  if (digitalRead(btnUp) == LOW) {
    currentMenu = (currentMenu - 1 + totalMenus) % totalMenus;
    tampilkanMenu();
    delay(200);
  }

  if (digitalRead(btnSelect) == LOW) {
    delay(200);
    switch (currentMenu) {
      case 0: daftarSidikJari(daftarDosen, totalDosen, 20, "Dosen"); break;
      case 1: absen(daftarDosen, totalDosen, "Dosen", 1); break; // Absen Masuk
      case 2: absen(daftarDosen, totalDosen, "Dosen", 0); break; // Absen Keluar
      case 3: hapusSemuaSidikJari(); break; // Hapus Semua
    }
  }
}

void tampilkanMenu() {
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("MENU:");
  lcd.setCursor(0, 1);
  lcd.print(menus[currentMenu]);
}

void muatDataDariFirebase() {
  Serial.println("Memuat data dari Firebase...");
  String path = "/dosen";

  if (Firebase.RTDB.getJSON(&fbdo, path)) {
    Serial.println("Data diterima dari Firebase!");
    FirebaseJson &json = fbdo.jsonObject();
    FirebaseJsonData jsonData;

    // Reset data dosen
    totalDosen = 0;

    size_t len = json.iteratorBegin();
    for (size_t i = 0; i < len; i++) {
      String key, value;
      int type;
      json.iteratorGet(i, type, key, value); // Perbaikan tipe parameter kedua

      // Parse data dosen
      if (json.get(jsonData, key + "/id") && jsonData.success) {
        daftarDosen[totalDosen].id = jsonData.intValue;
      }

      if (json.get(jsonData, key + "/nama") && jsonData.success) {
        daftarDosen[totalDosen].nama = jsonData.stringValue;
      }

      if (json.get(jsonData, key + "/matakuliah") && jsonData.success) {
        daftarDosen[totalDosen].matakuliah = jsonData.stringValue;
      }

      totalDosen++;
    }
    json.iteratorEnd();

    Serial.println("Data dosen berhasil dimuat.");
  } else {
    Serial.printf("Gagal memuat data: %s\n", fbdo.errorReason().c_str());
  }
}

int cariIDKosong() {
  for (int i = 1; i <= 127; i++) { // ID valid untuk sensor biasanya dari 1-127
    if (finger.loadModel(i) != FINGERPRINT_OK) {
      return i;
    }
  }
  return -1; // Tidak ada ID kosong
}

void daftarSidikJari(DataUser* daftar, int& total, int kapasitas, String tipe) {
  if (total >= kapasitas) {
    lcd.clear();
    lcd.print(tipe + " Penuh!");
    delay(2000);
    return;
  }

  int id = cariIDKosong();
  if (id == -1) {
    lcd.clear();
    lcd.print("Memori Penuh!");
    delay(2000);
    return;
  }

  lcd.clear();
  lcd.print("SCAN SIDIK JARI...");
  while (finger.getImage() != FINGERPRINT_OK);

  if (finger.image2Tz(1) != FINGERPRINT_OK) {
    lcd.clear();
    lcd.print("GAGAL MENDAFTAR!");
    delay(2000);
    return;
  }

  lcd.clear();
  lcd.print("SCAN LAGI..");
  delay(2000);
  while (finger.getImage() != FINGERPRINT_OK);

  if (finger.image2Tz(2) != FINGERPRINT_OK) {
    lcd.clear();
    lcd.print("GAGAL MENDAFTAR!");
    delay(2000);
    return;
  }

  if (finger.createModel() != FINGERPRINT_OK) {
    lcd.clear();
    lcd.print("MODEL GAGAL!");
    delay(2000);
    return;
  }

  if (finger.storeModel(id) != FINGERPRINT_OK) {
    lcd.clear();
    lcd.print("SIMPAN GAGAL!");
    delay(2000);
    return;
  }

  lcd.clear();
  lcd.print("NAMA");
  Serial.println("Masukkan Nama " + tipe + " via serial:");
  while (Serial.available() == 0);
  String nama = Serial.readStringUntil('\n');

  lcd.clear();
  lcd.print("MATAKULIAH");
  Serial.println("Masukkan Matakuliah " + tipe + " via serial:");
  while (Serial.available() == 0);
  String matakuliah = Serial.readStringUntil('\n');

  daftar[total].id = id;
  daftar[total].nama = nama;
  daftar[total].matakuliah = matakuliah;
  total++;

  lcd.clear();
  lcd.print("BERHASIL DAFTAR!");
  delay(2000);

  String path = "/dosen";
  path += "/" + String(id); // Setiap data berdasarkan ID

  FirebaseJson json;
  json.set("id", id);
  json.set("nama", nama);
  json.set("matakuliah", matakuliah);

  if (Firebase.RTDB.setJSON(&fbdo, path, &json)) {
    Serial.println("Data berhasil dikirim ke Firebase!");
  } else {
    Serial.printf("Gagal mengirim data ke Firebase: %s\n", fbdo.errorReason().c_str());
  }

  delay(2000);
}

void absen(DataUser* daftar, int total, String tipe, int status) {
  lcd.clear();
  lcd.print("SCAN SIDIK JARI...");
  while (finger.getImage() != FINGERPRINT_OK);

  if (finger.image2Tz(1) != FINGERPRINT_OK) {
    lcd.clear();
    lcd.print("GAGAL MENDAFTAR!");
    bunyiBuzzer(1, 200); // Bunyi buzzer 1 kali jika gagal membaca sidik jari
    delay(500);
    return;
  }

  if (finger.fingerSearch() != FINGERPRINT_OK) {
    lcd.clear();
    lcd.print("TIDAK DITEMUKAN!");
    bunyiBuzzer(1, 200); // Bunyi buzzer 1 kali jika sidik jari tidak ditemukan
    delay(500);
    return;
  }

  int fid = finger.fingerID;
  for (int i = 0; i < total; i++) {
    if (daftar[i].id == fid) {
      lcd.clear();
      lcd.print(daftar[i].nama);
      lcd.setCursor(0, 1);
      lcd.print(status == 1 ? "ABSEN MASUK" : "ABSEN KELUAR");
      bunyiBuzzer(2, 500); // Bunyi buzzer 2 kali jika absen berhasil
      delay(500);

      time_t now;
      struct tm timeinfo;
      time(&now);
      localtime_r(&now, &timeinfo);

      char timeStr[20];
      strftime(timeStr, sizeof(timeStr), "%Y-%m-%d %H:%M:%S", &timeinfo);

      // Perbarui status absen di Firebase
      String path = "/dosen/" + String(fid) + "/absen";

      // Format JSON untuk menyimpan waktu dan status absen
      FirebaseJson json;
      json.set("status", status);
      json.set("waktu", timeStr);

      if (Firebase.RTDB.setJSON(&fbdo, path, &json)) {
        Serial.println("Data absen berhasil diperbarui ke Firebase!");
      } else {
        Serial.printf("Gagal memperbarui data absen: %s\n", fbdo.errorReason().c_str());
      }

      return;
    }
  }

  lcd.clear();
  lcd.print("DATA TIDAK ADA!");
  bunyiBuzzer(1, 200); // Bunyi buzzer 1 kali jika data tidak ditemukan
  delay(2000);
}

void hapusSemuaSidikJari() {
  lcd.clear();
  lcd.print("HAPUS SEMUA?");
  lcd.setCursor(0, 1);
  
  // Tunggu konfirmasi dari pengguna
  while (digitalRead(btnSelect) == HIGH);

  lcd.clear();
  lcd.print("MENGHAPUS...");
  
  // Hapus database pada sensor
  if (finger.emptyDatabase() == FINGERPRINT_OK) {
    lcd.clear();
    lcd.print("BERHASIL HAPUS!");
    Serial.println("Database sidik jari berhasil dihapus.");
  } else {
    lcd.clear();
    lcd.print("GAGAL HAPUS!");
    Serial.println("Gagal menghapus database sidik jari.");
  }
  
  delay(3000);
  lcd.clear();
  tampilkanMenu();
}

void bunyiBuzzer(int jumlah, int durasi) {
  for (int i = 0; i < jumlah; i++) {
    digitalWrite(buzzer, HIGH);
    delay(500);
    digitalWrite(buzzer, LOW);
    delay(500);
  }
}
