## About this API

This API was developed as a working prototype as part of a compettion alongside an android mobile app by an Orchestra company where the winner would continue development. Unfortunately the team this API was part of did not win said competition.

This Repo contains commit names that reflect my earlier stepping stones in learning before I adopted the conventional commits specification standard for Git commit messages.

## Structure and Functionalities

The API is developed following the PSR-12 coding standards and PSR-4 autoloading standards with separate controller and service layers.

The API is capable of:
- Registering a new user
- Logging in with refresh token
- Create, Edit and Delete orchestra events
- List all hired orchestra events
- Invalidating all tokens associated with a user

Includes scaffolding for future features:
- Short Expiry access tokens for web app (10 min)
- Admininistrator panel functionality

## Tech Stack
- PHP (Laravel)
- PSR-12 coding standards
- MariaDB
- JWT based authentication

## Database Schema 
<img width="811" height="746" alt="DB Schema" src="https://github.com/user-attachments/assets/8cafa919-9f3d-4edf-a2cc-7c3b487193c4" />


