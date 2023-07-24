### Установка проекта через докер

Запустите установку

    docker compose build    
    
Запустите контейнеры

    docker compose up -d

Запустите установку зависимостей

    docker exec -it testlifemart-php-1 cd /var/www/html & php composer.phar install

Загрузите в базу данных файл по указанному пути:

    docker-build/test_task_202204011832.sql
    
Для получения JSON-массива, содержащего все возможные комбинации продуктов
необходмо запустить команду 

     docker exec -it testlifemart-php-1 php ./bin/console app:build-dishes cciiiidd

где cciiiidd - строка, содержащая коды ингредиентов.

Данная команда создаст файл по следующему пути

    upload/uniqueDishes.json
