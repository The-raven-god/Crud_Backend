# 📚 Laravel API - Gestión de Autores y Libros

Este repositorio corresponde al backend de una API RESTful desarrollada en Laravel para gestionar autores y sus libros.

## 🔧 Requisitos

* PHP >= 8.1
* Composer
* Laravel >= 10
* MySQL o MariaDB

---

## 📁 Estructura del Proyecto

### 📌 Controladores

#### **`AuthorsController`**

Ubicación: `App\Http\Controllers\AuthorsController`

* `index()` → Retorna todos los autores con sus libros relacionados.
* `store(Request $request)` → Valida y crea un nuevo autor.
* `show($id)` → Muestra un autor con sus libros.
* `update(Request $request, $id)` → Valida y actualiza un autor existente.
* `destroy($id)` → Elimina un autor (y sus libros por cascada).

#### **`BooksController`**

Ubicación: `App\Http\Controllers\BooksController`

* `index()` → Retorna todos los libros con su autor asociado.
* `store(Request $request)` → Valida y crea un nuevo libro.
* `show($id)` → Muestra un libro con su autor.
* `update(Request $request, $id)` → Valida y actualiza un libro existente.
* `destroy($id)` → Elimina un libro.

---

## 🧩 Modelos Eloquent

### **`Author`**

Ubicación: `App\Models\Author`

```php
protected $table = 'autores';
protected $fillable = ['nombre', 'email', 'biografia'];

public function libros() {
    return $this->hasMany(Book::class, 'autor_id');
}
```

### **`Book`**

Ubicación: `App\Models\Book`

```php
protected $table = 'libros';
protected $fillable = ['titulo', 'sinopsis', 'autor_id'];

public function autor() {
    return $this->belongsTo(Author::class, 'autor_id');
}
```

---

## 🗃 Migraciones de Base de Datos

### 📌 Tabla: `autores`

Ubicación: `database/migrations/xxxx_xx_xx_create_autores_table.php`

```php
Schema::create('autores', function (Blueprint $table) {
    $table->id();
    $table->string('nombre');
    $table->string('email')->unique();
    $table->text('biografia')->nullable();
    $table->timestamps();
});
```

### 📌 Tabla: `libros`

Ubicación: `database/migrations/xxxx_xx_xx_create_libros_table.php`

```php
Schema::create('libros', function (Blueprint $table) {
    $table->id();
    $table->string('titulo');
    $table->text('sinopsis')->nullable();
    $table->unsignedBigInteger('autor_id');
    $table->timestamps();

    $table->foreign('autor_id')
        ->references('id')
        ->on('autores')
        ->onDelete('cascade');
});
```

---

## 🔗 Relaciones

* **Un autor puede tener muchos libros.**
* **Cada libro pertenece a un autor.**
* La eliminación de un autor conlleva la eliminación de todos sus libros por `ON DELETE CASCADE`.

---

## ▶️ Comandos útiles

```bash
php artisan migrate            # Ejecuta las migraciones
php artisan migrate:rollback  # Revierte la última migración
php artisan migrate:fresh --seed # Reinicia la base de datos
```

---

## 📬 Rutas API

Estas rutas están definidas en `routes/api.php` y permiten interactuar con los controladores `AuthorsController` y `BooksController`.

### 🔹 Autores

* `GET /api/authors` → Obtener todos los autores.
* `POST /api/authors/store` → Crear un nuevo autor.
* `GET /api/authors/{id}` → Mostrar un autor por ID.
* `PUT /api/authors/update/{id}` → Actualizar un autor existente.
* `DELETE /api/authors/delete/{id}` → Eliminar un autor por ID.

### 🔹 Libros

* `GET /api/books` → Obtener todos los libros.
* `POST /api/books/store` → Crear un nuevo libro.
* `GET /api/books/{id}` → Mostrar un libro por ID.
* `PUT /api/books/{id}` → Actualizar un libro por ID.
* `DELETE /api/books/{id}` → Eliminar un libro por ID.

---

## 🌱 Seeders y Factories

Laravel utiliza *Factories* y *Seeders* para poblar la base de datos de prueba con datos realistas.

### 🔧 Factories

#### `AuthorFactory`

Ubicación: `database/factories/AuthorFactory.php`

```php
public function definition(): array
{
    return [
        'nombre' => $this->faker->name(),
        'email' => $this->faker->unique()->safeEmail(),
        'biografia' => $this->faker->paragraph(),
    ];
}
```

#### `BookFactory`

Ubicación: `database/factories/BookFactory.php`

```php
public function definition(): array
{
    return [
        'titulo' => $this->faker->sentence(),
        'sinopsis' => $this->faker->paragraph(),
        'autor_id' => Author::inRandomOrder()->first()->id,
    ];
}
```

### 🌱 Seeders

#### `AuthorSeeder`

```php
public function run(): void
{
    Author::factory()->count(10)->create();
}
```

#### `BookSeeder`

```php
public function run(): void
{
    Book::factory()->count(20)->create();
}
```

#### `DatabaseSeeder`

```php
public function run(): void
{
    $this->call(AuthorSeeder::class);
    $this->call(BookSeeder::class);
}
```

Para ejecutar los seeders, puedes usar:

```bash
php artisan migrate:fresh --seed
```

Esto eliminará y volverá a crear todas las tablas, insertando registros generados automáticamente.

---

## ✍️ Autor

**Santiago Rueda Quintero** - Backend API para gestión de libros y autores.

---

¿Deseas también agregar autenticación, Swagger (OpenAPI), pruebas unitarias o seeders? Avísame y lo incluimos fácilmente. ✅

