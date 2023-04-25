# employee_api


1. docker-compose up --build
2. cp .env.example .env
3. docker exec php-api composer install
4. docker exec php-api php artisan migrate
5. simple tests: docker exec php-api php artisan test
6. Access to api: http://127.0.0.1:8000/api/employee


# Api endoints: 
#    
store employee - POST - http://127.0.0.1:8000/api/employee payload: name

#
store employee delegation - POST - http://127.0.0.1:8000/api/employee/{employee}/delegation payload: start_date, end_date, country 

#
get employeee - GET - http://127.0.0.1:8000/api/employee/{employee} payload: ~
