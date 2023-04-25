# employee_api


1. docker-compose up
2. cp .env.example .env
3. docker exec php-api php artisan migrate
4. simple tests: docker exec php-api php artisan test
5. Access to api: http://127.0.0.1:8000/api/employee


# Api endoints: 
#    
store employee - POST - http://127.0.0.1:8000/api/employee payload: name

#
store employee delegation - POST - http://127.0.0.1:8000/api/employee/{employee}/delegation payload: start_date, end_date, country 

#
get employeee - GET - http://127.0.0.1:8000/api/employee/{employee} payload: ~
