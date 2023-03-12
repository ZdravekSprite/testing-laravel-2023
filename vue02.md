# AdminAccess

```bash
php artisan make:middleware AccessAdmin
```

- vue\app\Http\Middleware\AccessAdmin.php

```php
use Illuminate\Support\Facades\Auth;
  public function handle(Request $request, Closure $next): Response
  {
    if (Auth::user() && Auth::user()->hasAnyRoles(['superadmin', 'admin'])) {
      return $next($request);
    }
    return redirect('dashboard');
  }
```

- vue\app\Http\Kernel.php

```php
  protected $middlewareAliases = [
    'auth.admin' => \App\Http\Middleware\AccessAdmin::class,
  ];
```

- vue\routes\web.php

```php
Route::middleware('auth.admin')->group(function () {
  Route::get('/role', [RoleController::class, 'index'])->name('role.index');
});
```

- vue\resources\js\Layouts\AuthenticatedLayout.vue

```php
const isAuth = usePage().props.auth;
const hasRole = isAuth ? usePage().props.auth.user.roles : false;
const isadmin = hasRole ? usePage().props.auth.user.roles.filter(r => r.name == 'admin').length : false;
              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink v-if="isadmin" :href="route('role.index')" :active="route().current('role.index')">
                  Role
                </NavLink>
              </div>
        <!-- Responsive Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink v-if="isadmin" :href="route('role.index')" :active="route().current('role.index')">
              Role
            </ResponsiveNavLink>
          </div>
```

- vue\app\Http\Middleware\HandleInertiaRequests.php

```php
        'user' => ($request->user() && $request->user()->roles()) ? array_merge($request->user()->toArray(), ['roles' => $request->user()->roles()->get()]) : $request->user(),
```
