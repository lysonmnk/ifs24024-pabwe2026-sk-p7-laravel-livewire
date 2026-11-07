@echo off
set "PHP85=C:\Users\lyson\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.5_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe"
if exist "%PHP85%" (
    "%PHP85%" "%~dp0artisan" serve %*
) else (
    php "%~dp0artisan" serve %*
)
