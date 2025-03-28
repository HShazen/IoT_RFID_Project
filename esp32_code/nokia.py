from machine import Pin, PWM
from time import sleep


# Define note frequencies
NOTE_E5 = 659
NOTE_D5 = 587
NOTE_FS4 = 370
NOTE_GS4 = 415
NOTE_CS5 = 554
NOTE_B4 = 494
NOTE_D4 = 294
NOTE_E4 = 330
NOTE_A4 = 440
NOTE_CS4 = 277

melody = [
    NOTE_E5, NOTE_D5, NOTE_FS4, NOTE_GS4,
    NOTE_CS5, NOTE_B4, NOTE_D4, NOTE_E4,
    NOTE_B4, NOTE_A4, NOTE_CS4, NOTE_E4,
    NOTE_A4
]

durations = [
    8, 8, 4, 4,
    8, 8, 4, 4,
    8, 8, 4, 4,
    2
]

BUZZER_PIN = 27

def play_tone(frequency, duration):
    # Change this to your actual GPIO pin
    buzzer = PWM(Pin(BUZZER_PIN))
    if frequency == 0:
        sleep(duration)
    else:
        buzzer.freq(frequency)
        buzzer.duty(512)  # Set 50% duty cycle
        sleep(duration)
        buzzer.duty(0)  # Stop the tone

def play_melody():
    for i in range(len(melody)):
        note_duration = 1 / durations[i]  # Calculate duration in seconds
        play_tone(melody[i], note_duration)
        sleep(note_duration * 0.3)  # Pause between notes

