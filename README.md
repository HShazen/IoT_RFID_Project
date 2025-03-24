# IoT RFID-DACS (Door-Access-Control-System):
## Introduction:
This project is a university project for IoT Labs, through this project we will realise a access control system using ESP32 and RFID, in other term (RFID-Based Smart Door Lock System using ESP32).
![image](https://github.com/user-attachments/assets/4afe2ec6-65b0-4d2b-ab6f-4429eb8c5ec6)


## 1. Web Application:
The web application allows administrators to **monitor door usage** and **manage user access** efficiently. It provides detailed statistics and a user-friendly interface.


### **Admin Functionalities:**
- View **door statistics**
- View **users statistics**
- See/Edit **user information**
- **Add new users**

### **Web Application Structure:**
All information is displayed in an structured form with the following main elements:

#### **Authentication & Admin Dashboard**
- **Login page** (Admin authentication)
- **Admin profile information**
- **Home page** with a welcome message

#### **Door Statistics**
- **Line Chart:** Door usage over time (Today)
- **Bar Chart:** Door usage per day (Last 7 days)
- **Table Recent Access Logs:** Latest users who accessed the door with timestamps

#### **User Management**
- **Users List:** Displays all registered users
  - **View user details**
  - **Edit user information**
  - **Add a new user**

## Objectives:


## Components and Tools requirements:

### 🛠 **Hardware Components:**  
- **ESP32 Development Board** (NodeMCU ESP32, ESP32-WROOM, etc.)  
- **RFID Reader Module** (MFRC522 or RC522)  
- **RFID Tags or Cards**  
- **Stepper Motor**
- **Motor Driver Module** (ULN2003 for small stepper motors, A4988/DRV8825 for bigger motors)  
- **Power Supply** (5V for ESP32 & RFID, 12V for motor if needed)  
- **Jumper Wires** (Male-to-Male, Male-to-Female)  
- **Breadboard** (for prototyping)  
- **Push Button** (Optional, for manual override)  
- **Buzzer** (Optional, for access feedback)  

### 💻 **Software & Tools:**  
- **Thonny IDE** (For writing and uploading MicroPython code)  
- **MicroPython Firmware for ESP32** (Must be flashed onto the ESP32)  
- **MFRC522 Library** (MicroPython driver for RFID communication)  
- **Stepper Motor Library** (MicroPython module for stepper motor control)  
- **Wi-Fi Library (Optional)** (For IoT integration if needed)  


## **2. System Architecture**
### 🛠 **Hardware Components:**
For this project we will need those elements:
- **ESP32 Development Board**
- **RFID Reader Module** (MFRC522 or RC522)  
- **RFID Tags or Cards**  
- **Stepper Motor**
- **Power Supply** (5V for ESP32 & RFID)  
- **Jumper Wires** (Male-to-Male, Male-to-Female)  
- **Breadboard** (for prototyping)  
- **Push Button** (Optional, for manual override)  
- **Buzzer** (Optional, for access feedback)  
- **LCD Monitor**
### **The Circuite is shown here:**


## **3. ESP32 MicroPython Code**

## System Design and Architecture:
### Hardware:
### Software:


## **2. ESP32 MicroPython Code**
The ESP32 is programmed using **MicroPython** to control door access using **RFID authentication**. It handles user verification, logs events, and communicates with the web application.

### **ESP32 Features:**
- **Reads RFID cards** to authenticate users
- **Checks user credentials** against a stored database
- **Triggers door unlocking mechanism** when access is granted
- **Logs access attempts** and sends data to the web application
- **Implements security measures** (lockout after multiple failed attempts)

## **Installation & Setup**
### **Web Application**
1. Install necessary dependencies using:
   ```sh
   npm install  # If using a Node.js backend
   composer install  # If using a PHP backend
   ```
2. Configure database connection in the `.env` file
3. Run the web server:
   ```sh
   php -S localhost:8000  # For PHP
   npm start  # For Node.js
   ```

## Conclusion:
We were able to realise a Access Control System for multiple users, where each user has his own access card. we were able to control user data through a web application thats allow us to track when the door was open and by who at what time.
The system has a security control that prevents more than three incorrect attempts per minute. If unusual behavior is detected (more ten consecutive failed attempts are detected), it will trigger an alarm and send an alert to the web application.
