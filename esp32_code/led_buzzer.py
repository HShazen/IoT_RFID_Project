from machine import Pin, PWM
import utime

BUZZER_PIN = 27
RED_LED_PIN = 32
GREEN_LED_PIN = 25

def play_tone(frequency, duration, duty=6000):
    """Plays a tone at a given frequency and duration."""
    buzzer = PWM(Pin(BUZZER_PIN))
    buzzer.freq(frequency)
    buzzer.duty_u16(duty)  # Adjust volume (higher = louder)
    utime.sleep_ms(duration)
    buzzer.duty_u16(0)  # Stop sound
    utime.sleep_ms(50)  # Small gap between beeps

def denied(pin_number=RED_LED_PIN):
    """Flashes red LED and plays a deeper 'buzz buzz' for denied access."""
    red = Pin(pin_number, Pin.OUT)
    red.value(1)  # Turn on red LED
    start_time = utime.ticks_ms()

    # Deep "buzz buzz" sound like a real lock error
    for _ in range(3):
        play_tone(120, 300, 10000)  # Lower, stronger buzz
        utime.sleep_ms(200)

    utime.sleep_ms(500)  # Keep LED on longer for visibility
    red.value(0)  # Turn off red LED
    print("Denied sequence duration:", utime.ticks_diff(utime.ticks_ms(), start_time), "ms")

def granted(pin_number=GREEN_LED_PIN):
    """Flashes green LED and plays a 'click-clack' unlocking sound."""
    green = Pin(pin_number, Pin.OUT)
    green.value(1)  # Turn on green LED
    start_time = utime.ticks_ms()

    # Smooth motorized lock effect
    for _ in range(2):
        for note in [60, 80, 100, 120, 150]:  # Gradual sweep up
            play_tone(note, 100, 12000)  # Higher duty for a strong sound

    utime.sleep_ms(500)  # Keep LED on longer
    green.value(0)  # Turn off green LED
    print("Granted sequence duration:", utime.ticks_diff(utime.ticks_ms(), start_time), "ms")

def connection_succ():
    """Turns both LEDs on and plays a success buzzer sound with a short double beep."""
    red = Pin(RED_LED_PIN, Pin.OUT)
    green = Pin(GREEN_LED_PIN, Pin.OUT)
    
    # First beep with green LED
    green.value(1)
    play_tone(500, 120, 12000)
    green.value(0)  # Turn off before switching LED
    utime.sleep_ms(50)

    # Second beep with red LED
    red.value(1)
    play_tone(700, 150, 12000)
    red.value(0)
    utime.sleep_ms(50)

    # Third beep with red LED again
    green.value(1)
    play_tone(2000, 150, 12000)
    green.value(0)
    utime.sleep_ms(50)

    utime.sleep_ms(500)  # Keep LEDs on for half a second

    # Turn LEDs off
    red.value(0)
    green.value(0)

"""
Old buzzer code
BUZZER_PIN = 25

def play_tone(frequency, duration):
    # Plays a tone at a given frequency and duration.
    buzzer = PWM(Pin(BUZZER_PIN))
    buzzer.freq(frequency)

    buzzer.duty_u16(6000)  # Increase duty cycle for louder sound
    utime.sleep_ms(duration)
    buzzer.duty_u16(0)  # Stop sound
    utime.sleep_ms(50)  # Small gap between beeps

def denied(pin_number=12):
    # Flashes red LED and plays a buzzer sequence for denied access.
    red = Pin(pin_number, Pin.OUT)
    red.value(1)  # Turn on red LED
    start_time = utime.ticks_ms()

    for _ in range(3):
        play_tone(200, 150)  # Slightly longer beep
        utime.sleep_ms(100)
        play_tone(100, 150)
        utime.sleep_ms(100)

    utime.sleep_ms(300)  # Keep LED on for visibility
    red.value(0)  # Turn off red LED
    print("Denied sequence duration:", utime.ticks_diff(utime.ticks_ms(), start_time), "ms")

def granted(pin_number=27):
    # Flashes green LED and plays an ascending buzzer tone for granted access.
    green = Pin(pin_number, Pin.OUT)
    green.value(1)  # Turn on green LED
    start_time = utime.ticks_ms()

    for note in [300, 400, 500, 700]:
        play_tone(note, 80)  # Slightly longer beeps
        utime.sleep_ms(50)

    utime.sleep_ms(300)  # Keep LED on longer
    green.value(0)  # Turn off green LED
    print("Granted sequence duration:", utime.ticks_diff(utime.ticks_ms(), start_time), "ms")
"""


