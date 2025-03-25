import network
import urequests
import time

# Import my libraries
import _thread
import uid_sender as send
import rfid_reader as rf
import led_buzzer as lb
#import servo_door

# We send a connection request (40 times before it trigger an error)
send.connect_wifi("IdoomFibre_SDO","m4KKB3mc")

# This is the url that is responsible for adding logs
url = "http://192.168.100.109:8002/config/esp32_verify.php"

# Global variable present the attempt number
attempt = 1
super_attempt = 1

while True:
    # We read the uid every 1s in RC522
    rfid_uid = rf.read_tag()
    # print(rfid_uid)
    # Send the UID to the server
    response = send.send_rfid(url, rfid_uid)
    if ("Denied" in response):
        attempt += 1
        _thread.start_new_thread(lb.denied, ())
        if (attempt > 5):
            attempt = 1
            super_attempt += 1
            if (super_attempt > 5):
                super_attempt = 1
                print("Brute Force Detected, Door Locked for 20 minutes")
                send.send_rfid(url, -2)
                time.sleep(1200)
            else:
                print("suspisiouse activities, Door is locked for 3 minutes")
                send.send_rfid(url, -1)
                time.sleep(180)
                
    elif ("Access" in response):
        attempt = 1
        _thread.start_new_thread(lb.granted, ())
            
    # Delay to avoid brutforce
    time.sleep(1)
