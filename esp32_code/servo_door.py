from machine import Pin, PWM
import time

# Define servo on GPIO 33
servo = PWM(Pin(33), freq=50)  # 50Hz is standard for servos

# Function to set servo angle
def set_angle(angle):
    duty = int(25 + (angle / 180) * 100)  # Convert angle to duty cycle
    servo.duty(duty)
    time.sleep(1)  		# Give time to move

def open_door():
    set_angle(0)
    set_angle(180)
    #servo.deinit()		# Stop the PWM signal

"""
from machine import Pin, PWM
import time
import utime

def rotate_servo(speed):
    
    # Rotate the continuous servo at a given speed.
    # speed > 1500: Clockwise (faster if higher)
    # speed < 1500: Counterclockwise (slower if closer to 1500)
    # speed = 1500: Stop
    
    duty = int((speed / 20000) * 65535)  # Convert speed to PWM duty
    servo.duty_u16(duty)

# **Turn one full rotation (you may need to adjust timing)**
def full_turn():
    rotate_servo(1520)  # Start rotating clockwise
    time.sleep(1)       # Wait for ~1 second (adjust if needed)
    rotate_servo(1500)
    

full_turn()
"""
