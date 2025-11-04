# notas-app

Aplicación para la gestión de notas, evaluaciones y alumnos.

## Stack

- Laravel
- Blade, Unstyled Blade Starter Kit — https://github.com/javdome/unstyled-blade-starter-kit
- Bootstrap 5 - https://getbootstrap.com/

## Detalle de Modelos

- **User**: Login y autenticación. contiene credenciales y relaciones con los roles (Teacher y Student).

- **Teacher**: Perfil de docente. relación con cursos y evaluaciones que administra.

- **Student**: Perfil de alumno. relación con asistencias, calificaciones y grupos.

- **Course**: Representa un curso/materia.

- **Assessment**: Evaluación (prueba, tarea, concepto, etc.) asociada a un Course. Las evaluaciones individuales tienen notas asociadas a los alumnos. Las evaluaciones grupales tienen notas asociadas a grupos de alumnos.

- **StudentGroup**: Grupo de alumnos, para una evaluación. En un mismo curso, cada evaluación puede agrupar de manera diferente a los alumnos del curso.

- **Grade**: Nota/Calificación asociada a un Student para un Assessment individual o a un StudentGroup para un Assessment grupal. La nota puede ser de alguno de los diferentes tipos
    - Numérica
    - Aprobado / Desaprobado
    - Semáforo (satisfactorio, atención, no satisfactorio)

- **ClassDay**: Registro asistencia para una clase/jornada individual (fecha/hora).

- **Attendance**: Marca de asistencia de un Student en un ClassDay.

## Deploy

Para el deploy se construye una imagen Docker que utiliza FrankenPHP como server para ejecutar Laravel. 

Para la creación inicial de usuarios, A través de Tinker (`php artisan tinker`), se puede ejecutar:

```php
App\Models\User::create(['email'=>'teacher@example.com', 'password' => 'password'])->teacher()->create(['first_name'=>'Teacher','last_name'=>'Example']);

App\Models\User::create(['email'=>'student@example.com', 'password' => 'password'])->student()->create(['first_name'=>'Student','last_name'=>'Example']);
```
