# Operación: Deploy y Backups

## Deploy de producción

Ejecuta estos comandos en cada despliegue:

```bash
php artisan optimize:clear
php artisan migrate --force
php artisan storage:link
npm run build
```

## Checklist de deploy

1. Confirmar que `.env` de producción tenga `APP_URL` correcto.
2. Confirmar que `public/storage` apunte a `storage/app/public`.
3. Ejecutar migraciones antes de abrir tráfico.
4. Validar:
   - `/`
   - `/sitemap.xml`
   - `/admin`
   - una página de producto
   - una página de servicio

## Backup de base de datos

### MySQL / MariaDB

```bash
mysqldump -u TU_USUARIO -p TU_BASE_DE_DATOS > storage/app/backups/db-$(date +%F).sql
```

En Windows / Laragon puedes usar una variante como:

```powershell
mysqldump -u root -p opticaandina > storage\app\backups\db-%DATE:~10,4%-%DATE:~4,2%-%DATE:~7,2%.sql
```

## Backup de imágenes y archivos públicos

Respaldar al menos:

- `storage/app/public`
- `.env`

Ejemplo Linux:

```bash
tar -czf storage/app/backups/storage-public-$(date +%F).tar.gz storage/app/public .env
```

Ejemplo Windows PowerShell:

```powershell
Compress-Archive -Path storage\\app\\public,.env -DestinationPath storage\\app\\backups\\storage-public.zip -Force
```

## Recomendación mínima

- Base de datos: backup diario
- Imágenes / uploads: backup diario
- Retención: 14 a 30 días
- Guardar copia fuera del servidor
