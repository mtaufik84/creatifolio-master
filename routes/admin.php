protected function mapAdminRoutes()
{
    Route::middleware(['web', 'auth']) // Menambahkan auth di sini
        ->prefix('admin')
        ->name('admin.')
        ->group(base_path('routes/admin.php'));
}