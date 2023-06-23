# Zombie Apocalypse Simulator

Simulator for zombie apocalypse, where user can specify some variables and then run the simulation either turn by turn
or loop through it until it finishes itself.

## Installation

```bash
You need to copy .env.example to .env file in project root directory
(directory with docker-compose.yml)
```

Install project with docker, in application home directory, where Dockerfile is located use command below to build
application that consist of apache container and postgresql container

```bash
    docker compose up --build
```

Then you will need to open bash of apache docker container by using first command, then in bash you can
run ``entrypoint.sh`` - which is a shell script that kickstart our project. Script itself checks if you need to install
packages with node or composer if you do it does so for you. Script also copies example env (which is filled without of
box data that should be enough to start project without changing anything) and migrate and seed starting data for
simulation that app execute

```bash
    docker exec -it zombie-apocalypse-apache-1 sh
    cd /var/www/html
    ./entrypoint.sh
```

To quit docker exec(#) use exit

#### By default application can be opened on http://localhost/settings

## Environment Variables

To run this project, you will need to add the following environment variables to your .env file - however if you copy
.example.env or kickstart project with ``entrypoint.sh`` you won't need to make any changes

`DB_HOST` - you should use here name of postgres container not localhost or any ip

`DB_PORT`

`DB_DATABASE`

`DB_USERNAME`

`DB_PASSWORD`


## Application logic

#### During single turn of simulation following actions take place:

- Humans who couldn't eat for 3 turns die
- Humans who were injured for 2 turns and couldn't use medical resources die
- Humans infected for one turn get turned into zombies
- Humans generate resources based on their professions
- Humans can consume food or heal their injuries if resources are available
- Humans have set chance of getting injuries not caused by zombie bites
- There is set chance for encounter between human and zombie (number of encounters is limited to number of zombies).
  Result of encounter is zombie getting killed or human getting bitten. Chance for what happens is determined by human
  profession, weapon resources availability, and set base chance. Bitten human has a set chance to avoid getting
  infected and only becomes injured if that's the case.
- Next turn is generated if the simulation didn't end

#### Conditions for simulation to end:

- All humans are dead
- All zombies are killed
- There is no more food
- If enough turns happened humans create vaccine

### There are 3 views on frontend: settings, dashboard and statistics

#### Settings

Place for user to define simulation settings such as:

- chance for encounter between human and zombie
- base chance for human to get bitten by zombie during an encounter
- chance for human to get injured by something other than zombie
- chance for human to not become infected after getting bitten
- base number of humans on simulation start
- base number of zombies on simulation start
- checkbox if simulation should be run turn by turn, or in the loop with only results shown after it ends

There are also 3 buttons:

- save settings and go to simulation. Either sends user to dashboard or run the whole simulation in loop and sends user
  to statistics after it ends, depending on selected option.
- reset simulation, which is only visible when there is already simulation ongoing. Clicking it clears current
  simulation.

#### Dashboard

Place for user to see current state of the simulation. It shows number of:

- current turn
- alive humans
- zombies that are still walking
- resources available

Additionally, it also shows 3 randomly chosen alive humans and zombies. There is also a button that allows user to
reroll them.

In top right corner there is a button that leads to settings page. The button on the bottom change turn to the next one.

#### Statistics

Place for user to see how simulation ended. There are many statistics and button to go to settings.

## Tech Stack

**Client:** Blade, Javascript

**Server:** Apache, Laravel

## Roadmap of creation

The application is built using Docker containers with Apache Laravel and PostgreSQL. Here's how I approached this
project as a whole.

- First I've chosen Laravel as my backend, because its easy deployable and provides high amount of solutions that lets
  you create sophisticated applications in no time

- When I had my stack chosen I've started preparing my Docker environment for work, I've created `docker-compose.yml`
  that contains Apache as my server and PostgreSQL as my Database and `Dockerfile` that uses php:8.2-apache image to
  create environment needed to use Laravel 10. (More about what `Dockerfile` does can be found in files comments). I've
  prepared config for Apache2 and php as well.

- Then I've moved to programming - I've created basic models and migrations for Humans, Zombies and Resources, and I've
  created methods that let them interact with each-other, I've prepared basic frontend to show those interactions.

- After manually testing application I've noticed some opportunities to optimize application - like n+1 queries or
  redundant loops.

## Lessons Learned

During the development of this project I've tried to follow principles from books "Clean Code" and "Clean Architecture"
written by Robert C. Martin. These principles and architectural pattern have significantly influenced me and my view at
the project. I've noticed that I've spent more time thinking about creating better code. I tried to create smaller
functions, modular and extensible code and eliminate duplicated one.

## Appendix

This project was created within a relatively short period of time due to it being an assignment for a job application.
The time constraints meant that certain aspects of the project, including optimization, may not have been fully realized
or could have been improved further with additional time and resources.

If you have any feedback or suggestions regarding this project, please feel free to reach out to me.
