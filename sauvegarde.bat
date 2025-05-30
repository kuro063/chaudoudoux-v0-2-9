rem Ce fichier est destiné a être exécuté automatiquement mais dans l'état actuel il faut le faire manuellement

rem Afficher 4 caractères à partir de la position 6
set jour=%date:~0,2%

rem Afficher 2 caractères à partir de la position 3
set mois=%date:~3,2%

rem Afficher 4 caractères à partir de la position 6
set annee=%date:~6,4%

rem Sauvegarde sur le disque en local C: - Remplacer à chaque fois pour éviter une surcharge du disque dur / On appelle le fichier que cela pour éviter de le confondre après celui de la sauvegarde manuelle de phpmyadmin (bdchaudoudoux.sql)
C:\xampp\mysql\bin\mysqldump --dump-date -f --user=root --databases bdchaudoudoux > C:\sauvegardebdd\SauvegardeBDChaudoudoux.sql

rem Sauvegarde sur le disque dur externe F: - Créer une nouvelle sauvegarde car l'espace du disque dur le permet
C:\xampp\mysql\bin\mysqldump --dump-date -f --user=root --databases bdchaudoudoux > F:\sauvegardebdd\SauvegardeBDChaudoudoux-%annee%-%mois%-%jour%.sql