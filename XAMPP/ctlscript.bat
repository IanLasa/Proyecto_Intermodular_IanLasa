@echo off
rem START or STOP Services
rem ----------------------------------
rem Check if argument is STOP or START

if not ""%1"" == ""START"" goto stop

if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\hypersonic\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\server\hsql-sample-database\scripts\ctl.bat START)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\ingres\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\ingres\scripts\ctl.bat START)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\mysql\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\mysql\scripts\ctl.bat START)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\postgresql\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\postgresql\scripts\ctl.bat START)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\apache\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\apache\scripts\ctl.bat START)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\openoffice\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\openoffice\scripts\ctl.bat START)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\apache-tomcat\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\apache-tomcat\scripts\ctl.bat START)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\resin\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\resin\scripts\ctl.bat START)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\jetty\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\jetty\scripts\ctl.bat START)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\subversion\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\subversion\scripts\ctl.bat START)
rem RUBY_APPLICATION_START
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\lucene\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\lucene\scripts\ctl.bat START)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\third_application\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\third_application\scripts\ctl.bat START)
goto end

:stop
echo "Stopping services ..."
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\third_application\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\third_application\scripts\ctl.bat STOP)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\lucene\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\lucene\scripts\ctl.bat STOP)
rem RUBY_APPLICATION_STOP
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\subversion\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\subversion\scripts\ctl.bat STOP)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\jetty\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\jetty\scripts\ctl.bat STOP)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\hypersonic\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\server\hsql-sample-database\scripts\ctl.bat STOP)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\resin\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\resin\scripts\ctl.bat STOP)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\apache-tomcat\scripts\ctl.bat (start /MIN /B /WAIT C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\apache-tomcat\scripts\ctl.bat STOP)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\openoffice\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\openoffice\scripts\ctl.bat STOP)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\apache\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\apache\scripts\ctl.bat STOP)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\ingres\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\ingres\scripts\ctl.bat STOP)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\mysql\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\mysql\scripts\ctl.bat STOP)
if exist C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\postgresql\scripts\ctl.bat (start /MIN /B C:\Users\ianla\Documents\Proyecto_Intermodular_IanLasa\XAMPP\postgresql\scripts\ctl.bat STOP)

:end

