## INSTALLATION GUIDE

1. Clone the repository
    ```
    git clone 
    ```
1. Navigate to the project directory
    ```
    cd weather-forecast
    ```
1. Install dependencies via composer
    ```
    composer install
    ```
1. Install frontend dependencies via npm
    ```
    npm install
    ```
1. Run database migration via bin/console
    ```
    php bin/console doctrine:migrations:migrate
    ```


### EASY ENVIRONMENT SETUP GUIDE via LARAGON (Windows 10)
1. Install Laragon app
1. Clone the repository to C:\laragon\www
1. Run the steps on the installation guide above
1. Start laragon app
1. Visit app on browser via http://weather-forecast.local or http://weather-forecast.test
