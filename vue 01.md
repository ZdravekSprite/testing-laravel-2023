# Role

```bash
php artisan make:model Role -a
```

- vue\app\Models\Role.php

```php
  public function users()
  {
    return $this->belongsToMany(User::class);
  }
```

- vue\app\Models\User.php

```php
  public function roles()
  {
    return $this->belongsToMany(Role::class);
  }

  public function hasAnyRoles($roles)
  {
    return null !== $this->roles()->whereIn('name', $roles)->first();
  }

  public function hasAnyRole($role)
  {
    return null !== $this->roles()->where('name', $role)->first();
  }
```

- vue\database\migrations\2023_03_11_093402_create_roles_table.php

```php
  public function up(): void
  {
    Schema::create('roles', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('icon');
      $table->timestamps();
    });
    Schema::create('role_user', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->foreignId('role_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
      $table->timestamps();
    });
  }
  public function down()
  {
    Schema::dropIfExists('roles');
    Schema::dropIfExists('role_user');
  }
```

```bash
php artisan migrate
```

- vue\database\seeders\RoleSeeder.php

```php
use App\Models\Role;
  public function run(): void
  {
    Role::truncate();
    Role::create(['name' => 'superadmin', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/5/55/User-admin-gear.svg']);
    Role::create(['name' => 'admin', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_1.svg']);
    Role::create(['name' => 'user', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Blank_user.svg']);
    Role::create(['name' => 'socialuser', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_2.svg']);
    Role::create(['name' => 'blockeduser', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/0/0a/Gnome-stock_person.svg']);
    DB::table('role_user')->truncate();
    $superadminRole = Role::where('name', 'superadmin')->first();
    $adminRole = Role::where('name', 'admin')->first();
    $super_admin = User::create([
      'name' => env('SUPER_ADMIN_NAME', 'Super Admin'),
      'email' =>  env('SUPER_ADMIN_EMAIL', 'super@admin.com'),
      'password' => Hash::make(env('SUPER_ADMIN_PASS', 'password'))
    ]);
    $super_admin->roles()->attach($superadminRole);
    $super_admin->roles()->attach($adminRole);
  }
```

- vue\database\seeders\DatabaseSeeder.php

```php
  public function run(): void
  {
    $this->call(RoleSeeder::class);
  }
```

- vue/.env

```ts
SUPER_ADMIN_NAME="Super Admin"
SUPER_ADMIN_EMAIL=super@admin.com
SUPER_ADMIN_PASS=password
```

```bash
php artisan db:seed --class=RoleSeeder
```
