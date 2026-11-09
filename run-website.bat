@echo off
title Muktada's Boighor Server Runner
color 0A

echo ===================================================
echo     Muktada's Boighor - System Startup
echo ===================================================
echo.

:: 1. Check & Start MySQL if XAMPP exists
echo [1/3] Checking MySQL Database...
netstat -ano | findstr :3306 >nul
if %errorlevel% neq 0 (
    echo MySQL is not running. Starting XAMPP MySQL...
    if exist "C:\xampp\mysql\bin\mysqld.exe" (
        start "" /B "C:\xampp\mysql\bin\mysqld.exe" --defaults-file="C:\xampp\mysql\bin\my.ini" --standalone
        timeout /t 3 /nobreak >nul
    ) else (
        echo [Warning] Could not find XAMPP MySQL. Please start MySQL manually from XAMPP Control Panel.
    )
) else (
    echo MySQL is already running.
)

:: 2. Open browser automatically
echo [2/3] Opening browser at http://127.0.0.1:8000...
start "" "http://127.0.0.1:8000"

:: 3. Start Laravel development server
echo [3/3] Starting Laravel Server...
echo ===================================================
echo   Server is running at: http://127.0.0.1:8000
echo   Admin Login: admin@muktadasbookhouse.com
echo   Password:    password123
echo.
echo   Press Ctrl + C in this window to stop server.
echo ===================================================
echo.

php artisan serve --port=8000
pause
