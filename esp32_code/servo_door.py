from machine import Pin,PWM
import time
import utime

X = PWM(Pin(33, mode=Pin.OUT))
X.freq(100)
X.duty(131)


def full_turn():
    X.duty(150)
    time.sleep(1)
    X.duty(135)

full_turn()

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
