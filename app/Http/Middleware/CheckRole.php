<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Перевіряємо, чи користувач авторизований
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;
        
        // Перевіряємо, чи має користувач одну з дозволених ролей
        foreach ($roles as $role) {
            if ($userRole === $role) {
                return $next($request);
            }
        }
        
        // Якщо ролі не співпали - помилка 403
        abort(403, 'У вас немає доступу до цієї сторінки');
    }
}