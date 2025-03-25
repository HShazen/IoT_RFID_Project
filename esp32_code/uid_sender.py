import network
import urequests
import time

# Function to connect to the wifi get ssid with password
def connect_wifi(SSID, PASSWORD):        
    count = 0
    
    # Connect to WiFi
    wifi = network.WLAN(network.STA_IF)
    wifi.active(True)
    wifi.connect(SSID, PASSWORD)
    
    # Loop till you connect
    while not wifi.isconnected():
        time.sleep(0.5)  # Short delay to prevent CPU overload
        count += 1
        if count > 40:
            print("can not connect to the wifi")
            break

    print("Connected! IP:", wifi.ifconfig()[0])

# Used to test the connection
#connect_wifi("IdoomFibre_SDO","m4KKB3mc")

# Function to send RFID UID
def send_rfid(url, uid):
    url = f"{url}?uid={uid}"  # Replace with your server URL
    try:
        response = urequests.get(url)  # Send request
        print("Server response:", response.text)  # Print response from server
        return response.text
        response.close()
    except Exception as e:
        print("Error sending data:", e)

# Example UID (Replace with actual RFID reader input)
#rfid_uid = "111"
#url = "http://192.168.100.109:8002/config/esp32_verify.php"
#while True:
#    send_rfid(url, rfid_uid)  # Send the UID to server
#    time.sleep(2)  # 2-second delay to prevent overloading the server
