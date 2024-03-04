# CLI-Based Two-Player Vehicle Racing Game in PHP

This project is a simple command-line interface (CLI) based two-player racing game implemented in PHP. Players can choose a vehicle from a list provided in a `vehicles.json` file. Each vehicle has a maximum speed, and the application calculates the time taken by each vehicle to complete a given distance(It's being set as default to 100 kms) based on its speed. The winner is then declared based on the race results.

## Core Features

1. **Vehicle Selection**: Load the list of available vehicles from the `vehicles.json` file and allow two players to select a vehicle each.
2. **Race Simulation**: Run a race using the selected vehicles.
3. **Time Calculation**: Calculate the time taken by each vehicle to complete the race based on its speed.
4. **Winner Declaration**: Determine and display the winner based on the race results.
5. **Race Statistics**: Display the time taken by each vehicle to finish the race.

## Usage (how to play)

1. clone the project. (make sure to place it where you can run php).
2. in the root directory of the project execute this command in the terminal
```bash
php ./public/index.php
```
3. You will face this:
```
Welcome to the CLI Racing Game!
** Choose your vehicle: **
1. Car (150 km/h)
2. Motorcycle (200 km/h)
3. Bus (100 km/h)
4. Bicycle (30 km/h)
5. Jet Ski (92.6 km/h)
6. Speed Boat (129.64 km/h)
7. Yacht (37.04 km/h)
8. Helicopter (259.28 km/h)
9. Airplane (898.22 km/h)
10. Hot Air Balloon (9.26 km/h)
Player 1, choose your vehicle (1-10):
```
4. choose a number between 1-10
5. do it again for the player two
6. The race will begin and the winner and race statistics will appear.

p.s: _The speed numbers are being converted to `km/h` for the sake of simplicity in comparison_

p.s: _I know that this game may be boring. It's for the sake of OOD and not for entertainment!_ :)
