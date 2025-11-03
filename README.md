# NotasApp

Aplicación para la gestión de notas, evaluaciones y alumnos.

## Creación Inicial de usuarios

A través de Tinker (`php artisan tinker`), se puede ejecutar:

```php
App\Models\User::create(['email'=>'teacher@example.com', 'password' => 'password'])->teacher()->create(['first_name'=>'Teacher','last_name'=>'Example']);

App\Models\User::create(['email'=>'student@example.com', 'password' => 'password'])->student()->create(['first_name'=>'Student','last_name'=>'Example']);
```
