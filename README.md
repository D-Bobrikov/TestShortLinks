php artisan db:seed --class=AdminSeeder - добавить администратора с паролем 12345678

php artisan telegraph:new-bot - добавить существующего бота

php artisan telegraph:new-chat - добавить чат(ы) в которые будет писать бот, id чата можно унать командой /chatid

Что бы создать токен, необходимо залогиниться в админке и ввести имя источника и нажать "CREATE SOURCE", токен сгенерируется автоматически.

api/link - получить все ссылки для конкретного источника, источник определяем по токену.
method - GET.
token - обязательный параметр.

api/link/store - создать новую сокращённую ссылку либо получить сокращение уже имеющейся.
method - POST.
token - обязательный параметр.
full_reference - обязательный параметр.

api/link - удалить ссылку по её id.
method - DELETE.
token - обязательный параметр.
id - обязательный параметр.

